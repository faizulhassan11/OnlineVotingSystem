<?php

session_start();
require_once('../admin/inc/config.php');

if($_SESSION['key'] != 'VotersKey'){
    header('location:../admin/logout.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voterspanel - Online Voting System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>


    <div class="countainer-fluid">
        <div class="row bg-black text-white">
            <div class="col-1">
                <img src="../assets/images/logo.gif" width="80px" alt="">
            </div>
            <div class="col-11 my-auto">
                <h3> ONLINE VOTING SYSTEM - <small>Welcome <?= $_SESSION['username'];?> </small></h3>
            </div>
        </div>