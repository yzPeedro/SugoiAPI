<?php

function dd($pre = [], $die = true)
{
    echo "<pre>";
    print_r($pre);
    echo "</pre>";
    if($die) die;
}