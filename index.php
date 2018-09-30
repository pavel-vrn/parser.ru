<html>
<head>
    <link rel='stylesheet' href='assets/css/bootstrap.css'>
    <link rel='stylesheet' href='assets/css/main.css'>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</head>

<body>
<!--РАЗОБРАТЬСЯ, ЧТО ПРОИСХОДИТ С БАРОМ ПРИ СУЖЕНИИ СТРАНИЦЫ-->
<!--РАЗОБРАТЬСЯ, ЧТО ПРОИСХОДИТ С БАРОМ ПРИ СУЖЕНИИ СТРАНИЦЫ-->
<!--РАЗОБРАТЬСЯ, ЧТО ПРОИСХОДИТ С БАРОМ ПРИ СУЖЕНИИ СТРАНИЦЫ-->
<!--РАЗОБРАТЬСЯ, ЧТО ПРОИСХОДИТ С БАРОМ ПРИ СУЖЕНИИ СТРАНИЦЫ-->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="collapse navbar-collapse" id="navbarColor03">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/index.php">Слова <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="rules.php">Правила</a>
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

<?php
//к времени PhpStorm накинуть 6-8 часов времени
error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);
require "inc/Parser.php";
require "inc/Pdo_Helper.php";

$db = Pdo_Helper::singleton();

$pars = new Parser();
$result = $pars->getresult(1);
//$words = $pars->getWords();
$rules = $pars->getRules();
?>

<div>
    <h1>Слова</h1>
    <?php
    // количество записей, выводимых на странице
    $per_page = 100;
    // получаем номер страницы
    if (isset($_GET['page-words'])) {
        $page = ($_GET['page-words'] - 1);
    } else
        $page=0;
    // вычисляем первый оператор для LIMIT
    $start = abs($page * $per_page);
    // составляем запрос и выводим записи
    // переменную $start используем, как нумератор записей.
    $query = "SELECT * FROM words LIMIT $start, $per_page";
    $res = $db->PDO_FetchAll($query);
    $query = "SELECT count(*) FROM words";
    $result = $db->PDO_FetchRow($query);
    $total_rows = implode($result);
    $num_pages = ceil($total_rows / $per_page);
    ?>
    Страницы:
    <?php
    for($i = 1;$i <= $num_pages; $i++) {
        if ($i - 1 == $page) {
            echo $i . " ";
        } else {
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?page-words=' . $i . '">' . $i . "</a> ";
        }
    }
    ?>

    <table class="table table-hover table-bordered fixtable">
        <thead class="thead-inverse">
        <tr>
            <th>Пример</th>
            <th>ПредСтОснова</th>
            <th>СтСуф1</th>
            <th>СтСуф2</th>
            <th>КатСуф</th>
            <th>ПричСуф</th>
            <th>Флекс</th>
            <th>Результат</th>
            <th>Правила</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($res as $items) {
            echo '<tr>';
            foreach ($items as $key => $value) {
                if ($key != 'id')
                    echo '<td>' . $value . '</td>';
            }
            echo '<td>' . $pars->getresult($items["id"]) . '</td>';
            echo '<td><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">изменить</button></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    Страницы:
    <?php
    for($i = 1;$i <= $num_pages; $i++) {
        if ($i - 1 == $page) {
            echo $i . " ";
        } else {
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?page-words=' . $i . '">' . $i . "</a> ";
        }
    }
    ?>
</div>

<!-- Модальное окно -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Правила для «Требуем»</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                Содержимое модального окна

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info">Любая кнопка</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>