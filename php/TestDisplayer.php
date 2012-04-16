<?php

class TestDisplayer {

    static public function createTable($arrayOfTests) {
        $html = '<table><tr><th>Entry Date</th>'.
            '<th>Description</th><th>Success</th></tr>';

        for ($i = 0; $i < count($arrayOfTests); $i++) {
            $html .= self::rowWrap($arrayOfTests[$i]);
        }
        $html .= "</table>";
        return $html;
    }

    static public function rowWrap($row) {
         $html = '<tr>'.
             '<td>'.$row['entryDate'].'</td>'.
             '<td>'.$row['description'].'</td>'.
             '<td>'.$row['success'].'</td>'.
             '</tr>';
         return $html;
     }
}
