<?php
session_start();

function isLoggedIn(){
    if(!empty($_SESSION) && $_SESSION['is_logged_in'] === TRUE)
        return true;
    else
        return false;
}

function redirect($location){
    return header('Location: ' . $location);
}