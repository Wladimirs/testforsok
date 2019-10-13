<?php

// Output array for debug
function debug($arr)
{
    echo '<pre>';
    echo print_r($arr);
    echo '</pre>';
}

// Method for escaping html entities (tags), including single quotes (ENT_QUOTES)
// protection against XSS attacks
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

// Method for reloading the page by the user
function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        //if there is an address where the user came from, then we send him there
        // otherwise send him to the main page
        $redirect = $_SERVER['HTTP_REFERER'] ?? PATH;
    }
    header("Location: $redirect");
    exit();
}