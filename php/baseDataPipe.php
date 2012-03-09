<?php 

/***********************************************************************
 * Foundation data pipe code.  Given a tablemap, a tablename, a query type,
 * an author, an essay id, etc., automatically create the needed sql for selects,
 * insertions, updates, and deletes.  
 *
 * The instructions needed to trigger a particular line of sql comes from the browser 
 * through the REQUEST.  "object_ID", "queryType", "pipe choice", "tableName", and 
 * like are established at the browser controller and get passed to the server through
 * the request.  Control information and form data get passed in the same request.
 * Control information and data are combined into a single object on the browser.
 * 
 * Additional information for creating sql comes from tablemaps.  Specific requests 
 * will often be handled through special purpose data pipes created as extensions 
 * to BaseDataPipe.  Many queries are handled through the BaseDataPipe itself.
 **********************************************************************/

include ('utilities.php');

class BaseDataPipe {

   protected $map;
   protected $tableName;
   protected $queryType;
   protected $object_ID;
   protected $db;
   protected $groupoid;
   protected $authoroid;

   function __construct($mapMgr, $dataManager) {

      $this->object_ID = $_REQUEST['object_ID'];
      $this->queryType = $_REQUEST['queryType'];
      $this->groupoid = $_REQUEST['groupoid'];
      $this->db = $dataManager;
      $this->tableName = $this->setTableName();

      if ( !is_string($this->groupoid) ) {
            $this->groupoid = "null";
      }

      // Look first to see if there is a map specific to this table and queryType.
      $this->map = $mapMgr->findMatchingMaps($this->tableName, $this->queryType);

      // If no specific map was found, try the table and the 'select' map.
      if ( count($this->map) === 0 && $this->tableName !== 'authors') {
            $this->map = $mapMgr->findMatchingMaps($this->tableName, "select" );
      }

      /*+ TODO::location=baseDataPipe.php::task=When deciding on numeric or 
                 alpha as a dataType, handle more numeric cases than just int.::
                 author=Ed Anderson */

      // If no maps were present in the map table, then get the column headings 
      // from the data table itself.  Assume the browser side and the table side 
      // are the same in this case.
      if ( count($this->map) === 0 ) {
         $sql = "SHOW COLUMNS FROM ".$this->tableName;
         $result = $this->db->execute($sql);
         while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if ( substr($row['Type'], 0, 3) === "int" ) {
               $alphanumeric = "numeric";	
            } else {
               $alphanumeric = "alpha";
            }
            $this->map[] = new tableMap($this->tableName, $row['Field'],
                 $row['Field'], $this->queryType, $alphanumeric );			
         }
      }
   }
	
   /*+ TODO::location=BaseDataPipe.php::task=Think through the logic of masterid
              table handling and the possible failure of an insert into the masterid
              table::author=Ed Anderson   */

   /**********************************************************************
   * Execute creates the necessary sql and then executes it.  
   * The result set is returned.
   *********************************************************************/
   public function execute() {
      $masterSql = "";
      switch ( $this->queryType ) {
		
         case "search";
                 $sql = $this->select();
                 $this->tableName = $this->tableName."Search";
                 break;

         case "select":
                 $sql = $this->select();
                 break;

         case "insert":
            $sql = $this->insert();
            $this->db->test($sql);
            $masterSql = "insert into masterID ( object_ID, tableName, authoroid ) ";
            $masterSql .= "values ( '".$this->object_ID."', '".
                       $this->tableName."', '".$_REQUEST['authoroid']."' )";
            break;

         case "delete":
            $sql = $this->delete();
            $masterSql = "delete from masterid where object_ID = '".$this->object_ID."'";
            break;

         case "update":
            $sql = $this->update();
            $this->db->test('Execute update: '.$sql);
            $masterSql = "update masterid set entryDate = '".date('Y-m-d H:i:s').
                          "' where object_ID = '".$this->object_ID."'";
            break;
      }
        
      // Work first with the masterid table.  Manage inserts, updates, and selects.
      if ( strlen($masterSql) > 0 ) {
         $master_result = $this->db->execute($masterSql);
         $this->db->test($masterSql);
         if ($master_result != 1) {
            $this->db->test("Master ID failure.");
             return $master_result;
         }
      }
        
      // SQL finished, now execute the constructed statement.
      $result = $this->db->execute($sql);
        
      return $result;
      
   }
	
   protected function select() {
      $sql = "SELECT ";
      $fieldList = "";
      $fieldList = $this->fieldList($fieldList);
      $from = " FROM ".$this->tableName." ";
      $sql .= $fieldList.$from.$this->where();
      return $sql;
   }

   protected function where() {
      return "WHERE object_ID = '".$this->object_ID."'";
   }

   protected function insert() {

      // Automatically generate a random object_ID for the new object.
      // getObjectID() is located in utilities.php.
      $_REQUEST['object_ID'] = getObjectID();
      $this->object_ID = $_REQUEST['object_ID'];

      // SQL stem.
      $sql = "INSERT INTO ".$this->tableName;

      // List of table columns to be given new information.
      $fieldList = " ( ";
      $fieldList = $this->fieldList($fieldList)." ) ";

      // Construct the values portion of the SQL.
      $values = "VALUES ( ";
      for ( $i=0, $len=count($this->map); $i<$len; $i+=1 ) {

         // Get the name the browser uses for the field being mapped.
         $browser = $this->map[$i]->get('browser');

         if ( $this->map[$i]->get('dataType') === "alpha" ) {
            $thisData = $this->db->scrub($_REQUEST[$browser]);
            if ( strpos($browser, "Date") > 0 ) {
               if ( strlen($thisData) === 0 ) {
                  $thisData = "0000-00-00";
               }
            }
            if ( $browser !== "entryDate" ) {
               $values .= "'".$thisData."', ";
            }
         } else {
            $thisData = $_REQUEST[$browser];
            if ( strlen($thisData) === 0 ) {
               $thisData = 0;
            }
            $values .= $thisData.", ";
         }
       }
       $values = substr($values, 0, strrpos($values, ", "))." ) ";

       return $sql.$fieldList.$values;

   }

   // Can't take this out without removing it from the master index as well 
   // (See $this->execute case 'delete').  There are trigger issues as well.
   protected function delete() {
          $sql = "DELETE FROM ".$this->tableName." ".$this->where();
          return $sql;
   }

   protected function update() {

      // SQL stem.
      $sql = "UPDATE ".$this->tableName." SET ";
      $this->db->test($sql);
 
      // Create the set values for the update.
      for ( $i=0, $len=count($this->map); $i<$len; $i+=1 ) {

         // Analyze each field to insure that it has data.  If data is missing, the field 
         // does not get added to the update.
         $browser = $this->map[$i]->get('browser');
         $dataType = $this->map[$i]->get('dataType');
         $thisData = $_REQUEST[$browser];

         if ( $dataType === "alpha" || strpos($browser, "Date") ) {
            if ( strlen($thisData) < 1 )
               continue;
         }

         if ( $dataType === "numeric" ) {
            if ( !is_numeric($thisData) ) 
               continue;
         }

         $sql .= $this->map[$i]->get('dbCol')." = ";
         if ( $this->map[$i]->get('dataType') === "alpha" ) {
            $sql .= "'".$this->db->scrub($thisData)."', ";
         } else {
            $sql .= $thisData.", ";
         }
      }
      $sql .= "entryDate = '".date('Y-m-d H:i:s')."', ";
      $sql = substr($sql, 0, strrpos($sql, ", "))." ";
      $sql .= $this->where();
      $this->db->test('At exit of update(): '.$sql);
      return $sql;
   }

	
   // Convert the map into a field list for a SQL command.
   protected function fieldlist($fieldList) {
      for ( $i=0; $i<count($this->map); $i+=1 ) {
         $dbCol = $this->map[$i]->get('dbCol');
         if ( stripos($dbCol, "entryDate") === false ) {
            if ( stripos($dbCol, ".") === false )
               $fieldList .= $this->tableName.".".$dbCol.", ";
            else
               $fieldList .= $dbCol.", ";
         }
      }
      if ( strrpos($fieldList, ", " ) ) {
         $fieldList = substr($fieldList, 0, strrpos($fieldList, ", "));
      }
      return $fieldList;
   }

   // If the tableName is given in the REQUEST, use it.  Otherwise, look up the object_ID 
   // in the masterid table and find the name of the table it resides in.
   protected function setTableName() {
      $this->tableName = $_REQUEST['tableName'];
      if ( strlen($this->tableName) > 0 ) {
         return $this->tableName;
      }

      return lookUpInMaster( $this->object_ID );

   }

   // Look through the tableMaps to see if one of them is a groupoid.  Return true if there is one.
   protected function groupoidPresent() {
      $len = count($this->map);
      for ( $i=0; $i<$len; $i+=1 ) {
         if ( $this->map[$i]->get('dbCol') === "groupoid" ) 
            return true;		
      }
      return false;			
   }
		
   /****************************************************************
   * Data returned in the resultset stemming from the executed sql is passed 
   * to resultToXML for packaging with XML tags.  The package is the same
   * format MySQL produces when you save a query directly to a file.
   ****************************************************************/
   public function resultToXML($recordSet) {
      
      $XML = "";
      $offset = 1;
      if ( $this->tableName === "viewers"
             || $this->tableName === "allcomments" 
	     || $this->tableName === "alternativeqs" )
	$offset = 0;
      
      switch ( $this->queryType ) {
        
         // Create XML reflecting successful or unsuccessful execution
         // back to the browser.
         case "update" :
         case "delete" :
         case "insert" :
            $successFlag = "@true@";
            if ( $recordSet != 1 ) {
                   $successFlag = "@false@";
            }
            $XML .="<row tableName=\"success\">";
            $XML .= "<field name=\"object_ID\">".$this->object_ID."</field>";
            $XML .= "<field name=\"result\">".$successFlag."</field>";
            $XML .= "</row>";
            break;

         // Package data retrieved in XML tags for transmission back to the browser.
         // Format:
         // <row tableName="enotes">
         //          <field name="object_ID">xsaew-triee-uoirw-kdixi</field>
         //          <field name="note">This could be a note of considerable length.</field>
         //                                     . . .
         // </row>
         case "keyword" :
            $this->tableName = "keywords";
         case "search" :
         case "select" :
            $XML = "";
            while ($row = $recordSet->fetch(PDO::FETCH_ASSOC)) {
               $XML .= "<row tableName=\"".$this->tableName."\">";
               for ( $i=0, $len=count($this->map)-$offset; $i<$len; $i+=1 ) {
                  $XML .= "<field name=\"".$this->map[$i]->get('browser').
                             "\">".$this->db->deScrub($row[$this->map[$i]->get('dbCol')]);
                  $XML .= "</field>";
               }

               if ( strlen($record[$i]) > 0 ) {
                  $XML .= "<field name=\"commentPresent\">".
                          $this->db->deScrub($row[$this->map[$i]->get('dbCol')]);
                  $XML .= "</field>";
               }
               $XML .= "</row>";

            }
            break;
      }

      return $XML;      
   }
   
}

?>
