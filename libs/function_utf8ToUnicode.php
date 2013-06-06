<?php

function utf8ToUnicode($str){
    $unicode = array();
    $values = array();
    $lookingFor = 1;

    for ($i = 0; $i < strlen($str); $i++){
        $thisValue = ord($str[ $i ]);

        if ($thisValue < 128) $unicode[] = $thisValue;
        else{
            if (count($values) == 0) $lookingFor = ($thisValue < 224) ? 2 : 3;

            $values[] = $thisValue;

            if (count($values) == $lookingFor){
                $number = ($lookingFor == 3) ?
                (($values[0] % 16) * 4096) + (($values[1] % 64) * 64) + ($values[2] % 64):
                (($values[0] % 32) * 64) + ($values[1] % 64);

                $unicode[] = $number;
                $values = array();
                $lookingFor = 1;
            } // if
        } // if
    } // for
    return $unicode;
} // utf8_to_unicode

?>