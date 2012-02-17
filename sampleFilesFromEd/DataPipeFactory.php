<?php 

// DataPipeFactory.php returns a datapipe object that matches the query asked for.
include('baseDataPipe.php');
include('EssayDataPipe.php');
include('ManyDataPipe.php');
include('sequenceoidDataPipe.php');
include('SequenceOidManyDataPipe.php');
include('NextStepsDataPipe.php');
include('SearchDataPipe.php');
include('KeyWordDataPipe.php');
include('CommentsDataPipe.php');
include('UserDataPipe.php');
include('MembersDataPipe.php');
include('UserCheckDataPipe.php');
include('ChangeGroupDataPipe.php');
include('ProcedureDataPipe.php');
include('quotesDataPipe.php');
include('ViewerDataPipe.php');
include('AnalyticsDataPipe.php');
include('SiteFeedbackDataPipe.php');
include('LookUpDataPipe.php');
include('EssayListDataPipe.php');
include('EssayQuestionDataPipe.php');
include('EssayAnswerDataPipe.php');
include('PatternViewDataPipe.php');
include('AllEssayDataPipe.php');

// Any query doing basic CRUD will fall through to the default and use the BaseDataPipe.
// These queries do one table and one record at a time.
//  If multiple records are to be returned, the queryType will have a switched name.  The 
//  query will also be a select.
function dataPipeFactory($mapManager, $dataManager) {

	$dataPipe = "";
	switch ( $_REQUEST['pipe'] ) {
	
		case "sequenceoid" :
			$dataPipe = new SequenceoidDataPipe($mapManager, $dataManager);
			break;			
			
		case "nextsteps" :
			$dataPipe = new NextStepsDataPipe($mapManager, $dataManager);
			break;
	
		case "many":
			if ( $_REQUEST['tableName'] == "sequenceoids" ) {
				$dataPipe = new SequenceOidManyDataPipe($mapManager, $dataManager);
			}
			else {
				$dataPipe = new ManyDataPipe($mapManager, $dataManager);
			}
			break;
			
		case "quotes":
			$dataPipe = new QuotesDataPipe($mapManager, $dataManager);
			break;

		case "essay":
			$dataPipe = new EssayDataPipe($mapManager, $dataManager);
			break;
			
		case "search":
			$dataPipe = new SearchDataPipe($mapManager, $dataManager);
			break;
			
		case "keywords":
			$dataPipe = new KeyWordDataPipe($mapManager, $dataManager);
			break;
			
		case "comments":
			$dataPipe = new CommentsDataPipe($mapManager, $dataManager);
			break;
			
		case "user":
			$dataPipe = new UserDataPipe($mapManager, $dataManager);
			break;
			
		case "members":
			$dataPipe = new MembersDataPipe($mapManager, $dataManager);
			break;
			
		case "usercheck":
			$dataPipe = new UserCheckDataPipe($mapManager, $dataManager);
			break;
			
		case "changegroup":
			$dataPipe = new ChangeGroupDataPipe($mapManager, $dataManager);
			break;
			
		case "procedure":
			$dataPipe = new ProcedureDataPipe($mapManager, $dataManager);
			break;
			
		case "viewers":
			$dataPipe = new ViewerDataPipe($mapManager, $dataManager);
			break;
			
		case "analytics":
			$dataPipe = new AnalyticsDataPipe($mapManager, $dataManager);
			break;
			
		case "sitefeedback":
			$dataPipe = new SiteFeedbackDataPipe($mapManager, $dataManager);
			break;
			
		case "lookup":
			$dataPipe = new LookUpDataPipe($mapManager, $dataManager);
			break;
			
		case "essays":
			$dataPipe = new EssayListDataPipe($mapManager, $dataManager);
			break;
			
        case "essayAll":
            $dataPipe = new AllEssayDataPipe($mapManager, $dataManager);
            break;
            
		case "equestions":
			$dataPipe = new EssayQuestionDataPipe($mapManager, $dataManager);
			break;
			
		case "eanswers":
			$dataPipe = new EssayAnswerDataPipe($mapManager, $dataManager);
			break;
			
		case "enotes":
			$dataPipe = new EssayQuestionDataPipe($mapManager, $dataManager);
			break;
			
		case "patternview":
			$dataPipe = new PatternViewDataPipe($mapManager, $dataManager);
			break;

		default:
			$dataPipe = new BaseDataPipe($mapManager, $dataManager);
	}
	
	return $dataPipe;
}

?>