<?php
// Keeps a smorgasbord of utilties for my coaching web site.

// Create a random object id of the form xxxxx-xxxxx-xxxxx-xxxxx.
function getObjectID()
{
    $objectID = "";

    for ( $i=1; $i<21; $i++ )
    {
        $objectID .= chr(mt_rand(97,122));
        if ( $i < 20 && ( $i%5 ) == 0 )
            $objectID .= "-";
    }

    return $objectID;

}



// Check the masterID table to see if an id is present,  If so, return the table the id is located in.  If not, return false.
function lookUpInMaster( $oid ) {
}

?>
