<html>
<head>
    <link rel='stylesheet' href='css/bootstrap.css'>
    <link rel='stylesheet' href='css/main.css'>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
</head>

<body>

<?php
//к времени PhpStorm накинуть 6 часов времени
error_reporting(-1);
require "inc/Parser.php";
require "inc/Pdo_Helper.php";

$db = Pdo_Helper::singleton();

$pars = new Parser();
$result = $pars->getresult(1);
$words = $pars->getWords();
$rules = $pars->getRules();
?>

<a href="<?php echo $_SERVER["REQUEST_URI"];?>">Обновить</a>

<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

    <li class="nav-item">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-verbs" role="tab" aria-controls="pills-verbs" aria-selected="true">Глаголы</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-rules" role="tab" aria-controls="pills-rules" aria-selected="false">Правила</a>
    </li>
    <li class="nav-item">
        <form class="form-inline my-2 my-lg-0 nav-link">
            <input class="form-control mr-sm-2" type="search" placeholder="Поиск" aria-label="Поиск">
            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Поиск</button>
        </form>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-verbs" role="tabpanel" aria-labelledby="pills-verbs-tab">
        <table class="table table-hover table-bordered">
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
            foreach ($words as $items) {
                echo '<tr>';
                foreach ($items as $key => $value) {
                    if ($key != 'id')
                        echo '<td>' . $value . '</td>';
                }
                echo '<td>' . $pars->getresult($items["id"]) . '</td>';
                echo '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">изменить</button></td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="pills-rules" role="tabpanel" aria-labelledby="pills-rules-tab">
        <table class="table table-hover table-bordered">
            <thead class="thead-inverse">
            <tr>
                <th>Тип</th>
                <th>Предусловие</th>
                <th>Постусловие</th>
                <th>Вход</th>
                <th>Выход</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($rules as $items) {
                echo '<tr>';
                foreach ($items as $value) {
                    echo '<td>' . $value . '</td>';
                }
                echo '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">изменить</button></td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
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