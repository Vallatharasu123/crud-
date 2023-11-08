<?php
$csrfToken = bin2hex(random_bytes(32)); // Generate a 64-character token
session_start();
$_SESSION['csrf_token'] = $csrfToken;

include 'config.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>People Data</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="m-0">
        <div class="topbar p-1 d-flex align-items-center">
            <span class="ms-3 hamburger px-2  py-1 rounded"> <i class="bx bx-menu"></i></span>
        </div>
        <div class="clo-12 d-flex p-0 m-0">
            <div class="sidebar open ">
                <ul class="list-unstyled px-1 py-1 non-tooltip open">
                    <li><a href="index.php"><i class="bx bx-home mx-2"></i> <span class="menu-text">Home</span></a></li>
                    <li><a href="#"><i class="bx bx-info-circle mx-2"></i> <span class="menu-text">About</span></a></li>
                    <li><a href="#"><i class="bx bx-cog mx-2"></i> <span class="menu-text">Services</span></a></li>
                    <li><a href="#"><i class="bx bx-image mx-2"></i> <span class="menu-text">Portfolio</span></a></li>
                    <li><a href="#"><i class="bx bx-envelope mx-2"></i> <span class="menu-text">Contact</span></a></li>
                </ul>


            </div>

            <div class="main-area open p-2">