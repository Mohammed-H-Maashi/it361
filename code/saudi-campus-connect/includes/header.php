<?php
$pageTitle = $pageTitle ?? 'Saudi Campus Connect';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | Saudi Campus Connect</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <header class="site-header">
        <div class="header-line"></div>
        <div class="container header-layout">
            <a class="brand" href="index.php" aria-label="Saudi Campus Connect home">
                <span class="logo-mark">SCC</span>
                <span>
                    <strong>Saudi Campus Connect</strong>
                    <small>Learn, Participate, and Make an Impact</small>
                </span>
            </a>
            <nav aria-label="Main navigation">
                <ul class="nav-list">
                    <li><a class="<?= $currentPage === 'index.php' ? 'active' : '' ?>" href="index.php">Home</a></li>
                    <li><a class="<?= in_array($currentPage, ['activities.php', 'activity.php'], true) ? 'active' : '' ?>" href="activities.php">Activities</a></li>
                    <li><a class="<?= $currentPage === 'join.php' ? 'active' : '' ?>" href="join.php">Join an Activity</a></li>
                    <li><a class="<?= $currentPage === 'participants.php' ? 'active' : '' ?>" href="participants.php">Participants</a></li>
                    <li><a class="<?= $currentPage === 'about.php' ? 'active' : '' ?>" href="about.php">About</a></li>
                    <li><a class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>