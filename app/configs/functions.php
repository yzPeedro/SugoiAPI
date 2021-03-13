<?php

function dd($pre = [], $die = true)
{
    echo "<pre>";
    return $pre;
    echo "</pre>";
    if($die) die;
}