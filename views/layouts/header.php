<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title></title> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="index.php">Bicycle Theft Management System</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href=<?php if ($_SESSION['role'] == 'public') echo "../users/dashboard.php"; else if($_SESSION['role'] == 'police') echo "../police/dashboard.php"; else echo "../admin/dashboard.php";?>>Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../users/logout.php">Logout</a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../users/login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../users/register.php">Register</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>