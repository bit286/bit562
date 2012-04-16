<?php

// DataPipeFactory.php returns a datapipe object that matches the query asked for.
include_once('baseDataPipe.php');
include_once('ProjectFileDataPipe.php');
include_once('UsersDataPipe.php');

// Any query doing basic CRUD will fall through to the default and use the BaseDataPipe.
// These queries do one table and one record at a time.
//  If multiple records are to be returned, the queryType will have a switched name.  The
//  query will also be a select.
function dataPipeFactory($mapManager, $dataManager) {

    $dataPipe = "";
    switch ( $_REQUEST['pipe'] ) {

    case "projectfiles" :
        $dataPipe = new ProjectFilesDataPipe($mapManager, $dataManager);
        break;

    case "users" :
        $dataPipe = new UsersDataPipe($mapManager, $dataManager);
        break;

    default:
        $dataPipe = new BaseDataPipe($mapManager, $dataManager);
    }

    return $dataPipe;
}

