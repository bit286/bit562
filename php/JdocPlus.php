<?php
/***************************************************************************
* JdocPlus.php
****************************************************************************/

class JdocPlus{

	private $sqlMgr;
	private $sqlResult = '';
	private $header = '';
	private $footer = '';
	private $htmlTables = '';
	private $beforeTable = '';
	private $tableOpenTag = '';
	private $tableRowCmd = '';
	private $tableRowCmdKey = '';
	private $tableCloseTag = '';
	private $afterTable = '';

	public function __construct(DBManager $databaseManager) {
		$this->sqlMgr = $databaseManager;
	}
	
	public function createJdocPlusHtmlDocument(){
		$this-> readHtmlHeader();
		$this-> readHtmlFooter();
		$this-> readHtmlBody();
		$this-> retrieveSqlData();
		$this-> packageSqlDataInHtmlTables();
		$this-> writeJdocPlusHtmlDocument();
	}

	private function readHtmlHeader(){
		$inputFilename = '../templates/header.html';
		$fileReader = fopen($inputFilename, 'r');
		while (!feof($fileReader)) {
			$fileLine = fgets($fileReader);
			// Substitute the "JdocPlus" into the Title.
			if (preg_match('/~TITLE~/', $fileLine)) {
				$fileLine = str_replace('~TITLE~', 'JdocPlus', $fileLine);
			}
			$this->header .= $fileLine;
		}
		fclose($fileReader);
	}

	private function readHtmlFooter(){
		$inputFilename = '../templates/footer.html';
		$fileReader = fopen($inputFilename, 'r');
		while (!feof($fileReader)) {
			$fileLine = fgets($fileReader);
			$this->footer .= $fileLine;
		}
		fclose($fileReader);
	}

	private function readHtmlBody(){
		$inputFilename = '../templates/JdocPlusBody.html';
		$fileReader = fopen($inputFilename, 'r');
		$marker = 'BEFORETABLE';

		while (!feof($fileReader)) {
			$fileLine = fgets($fileReader);
			switch ($marker) {
				case 'BEFORETABLE':
					if (!preg_match('/\<table /', $fileLine)) {
						$this->beforeTable .= $fileLine;
					} else {
						$this->tableOpenTag .= $fileLine;
						$marker = 'TABLE';
					}
					break;
				case 'TABLE':
					if (preg_match('/commandJdocPlus/', $fileLine)) {
						$this->tableRowCmd .= $fileLine;
					} elseif (preg_match('/commandKeyJdocPlus/', $fileLine)) {
						$this->tableRowCmdKey .= $fileLine;
					} else {
						$this->tableCloseTag .= $fileLine;
						$marker = 'AFTERTABLE';
					}
					break;
				case 'AFTERTABLE':
					$this->afterTable .= $fileLine;
					break;
			}
		}
		fclose($fileReader);
	}

	private function retrieveSqlData(){
		$sqlQuery =
			"SELECT
				 c.commandName
				,c.name
				,ck.commandKey
				,ck.commandValue
			FROM commands AS c
			INNER JOIN commandKeys AS ck ON (c.commandId = ck.commandId)
			ORDER BY c.commandName, ck.commandKey;";

		$this->sqlResult = $this->sqlMgr->execute($sqlQuery);
	}

	private function packageSqlDataInHtmlTables(){
		$currentCommandName = '';
		while ($sqlRow = $this->sqlResult->fetch(PDO::FETCH_ASSOC)) {
			if ($sqlRow['commandName'] != $currentCommandName) {
				if (!empty($currentCommandName)) {
					$this->htmlTables .= $this->tableCloseTag;
				}
				$currentCommandName = $sqlRow['commandName'];
				
				$buildRowCmd = $this->tableRowCmd;
				$buildRowCmd = str_replace('~COMMANDNAME~', $sqlRow['commandName'], $buildRowCmd);
				$buildRowCmd = str_replace('~NAME~', $sqlRow['name'], $buildRowCmd);
				
				$this->htmlTables .= $this->tableOpenTag . $buildRowCmd;

			}
				$buildRowCmdKey = $this->tableRowCmdKey;
				$buildRowCmdKey = str_replace('~COMMANDKEY~', $sqlRow['commandKey'], $buildRowCmdKey);
				$buildRowCmdKey = str_replace('~COMMANDVALUE~', $sqlRow['commandValue'], $buildRowCmdKey);
				
				$this->htmlTables .= $buildRowCmdKey;
		}
		$this->htmlTables .= $this->tableCloseTag;
	}

	private function writeJdocPlusHtmlDocument(){
		$outputFilename = '../doc/JdocPlus.html';
		$fileWriter = fopen($outputFilename, 'w');

		fwrite($fileWriter, $this->header);
		fwrite($fileWriter, $this->beforeTable);
		fwrite($fileWriter, $this->htmlTables);
		fwrite($fileWriter, $this->afterTable);
		fwrite($fileWriter, $this->footer);

		fclose($fileWriter);
	}
}

?>