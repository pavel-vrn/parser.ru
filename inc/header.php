<?php
error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);
?>

<html>
<head>
    <link rel='stylesheet' href='../assets/css/bootstrap.css'>
    <link rel='stylesheet' href='../assets/open-iconic-master/font/css/open-iconic-bootstrap.css'>
    <link rel='stylesheet' href='../assets/css/main.css'>

    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/ajax.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-light" style="background-color: #e3f2fd;">
        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/index.php">Слова <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../rules.php">Правила</a>
                </li>
            </ul>
            <form class="form-inline">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" onclick="document.location.reload()">Обновить</button>
            </form>
            <p>&nbsp; &nbsp;</p>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Поиск..." aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Найти</button>
            </form>
        </div>
    </nav>
