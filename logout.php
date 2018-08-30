<?php
session_start();

if (isset($_SESSION['userID'])) {
    unset($_SESSION['userID']);
    header("Location:login.php");
} else {
    header("Location:login.php");
}

