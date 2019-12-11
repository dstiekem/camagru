<?php
function convdt($datetime){
    $arrmonths = array('Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    $dtarr = explode('-', substr($datetime, 0, 10), 10);
    $month = $dtarr[1];
    $wdmonth = $arrmonths[$month - 1];
    $year = $dtarr[0];
    $day = $dtarr[2];
    $wddate = substr_replace($datetime, $day . " " . $wdmonth . " " . $year, 0, 10);
    return($wddate);
}
?>