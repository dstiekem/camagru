<?php
    function modal($string1, $string2)
    {
        if($string1 === "success")
        {
            echo '<div style="width: 100%;"><div class="noties" id="success">'. $string2 .'</div></div>';
        }
        else if($string1 === "error")
        {
            echo '<style="width: 100%;"><div class="noties" id="alerties">'. $string2 .'</div></div>';
        }
    }
?>