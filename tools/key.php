<?php

function make_session_key($len=100){
    $corpus = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_";
    // corpus is 64 chars -> 6 bits of entropy per char

    $key = "";
    for($i = 0; $i < $len; $i++)
        $key .= $corpus[rand(0, strlen($corpus)-1)];

    return $key;
}

?>
