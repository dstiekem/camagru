<?php
    function randPic(){
        $bg = array('graphics/underline1.png', 'graphics/underline2.png', 'graphics/underline3.png', 'graphics/underline4.png', 'graphics/underline5.png', 'graphics/underline6.png'); // array of filenames

        $i = rand(0, count($bg)-1); // generate random number size of the array
        $selectedBg = $bg[$i]; // set variable equal to which random filename was chosen
        return($selectedBg);
    }
?>