<html>
<head>
    <link rel='stylesheet' href='assets/css/bootstrap.css'>
    <link rel='stylesheet' href='assets/open-iconic-master/font/css/open-iconic-bootstrap.css'>
    <link rel='stylesheet' href='assets/css/main.css'>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
</head>

<body>

<?php
//к времени PhpStorm накинуть 6-8 часов времени
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
require "inc/Parser.php";
require "inc/Pdo_Helper.php";

$db = Pdo_Helper::singleton();

$pars = new Parser();
$result = $pars->getresult(1);
//$words = $pars->getWords();
//$rules = $pars->getRules();
?>

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

<div>
    <h1>Правила</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" id="add_rule_button">Добавить правило</button>
    <br>
    <?php
    // количество записей, выводимых на странице
    $per_page = 5;
    // получаем номер страницы
    if (isset($_GET['page-rules'])) {
        $page = ($_GET['page-rules'] - 1);
    } else
        $page=0;
    // вычисляем первый оператор для LIMIT
    $start = abs($page * $per_page);
    // составляем запрос и выводим записи
    // переменную $start используем, как нумератор записей.
    $query = "SELECT * FROM rules LIMIT $start, $per_page";
    $res = $db->PDO_FetchAll($query);

    $query = "SELECT count(*) FROM rules";
    $result = $db->PDO_FetchRow($query);
    $total_rows = implode($result);
    $num_pages=ceil($total_rows / $per_page);
    ?>
    Страницы:
    <?php
    for($i = 1;$i <= $num_pages; $i++) {
    if ($i - 1 == $page) {
    echo $i . " ";
    } else {
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?page-rules=' . $i . '">' . $i . "</a> ";
    }
    }
    ?>
    <table class="table table-hover table-bordered">
        <thead class="thead-inverse">
        <tr>
            <th>Тип</th>
            <th>Предусловие</th>
            <th>Постусловие</th>
            <th>Вход</th>
            <th>Выход</th>
            <th>Изменить / Удалить</th>
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
            echo '<td><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#ruleModal" id="' . $items['id'] . '"><span class="oi oi-pencil" title="pencil" aria-hidden="true"></span></button>&nbsp;&nbsp; <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#ruleModal" id="' . $items['id'] . '"><span class="oi oi-x" title="x" aria-hidden="true"></span></button></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    Страницы:
    <?php
    for($i = 1; $i <= $num_pages; $i++) {
        if ($i - 1 == $page) {
            echo $i . " ";
        } else {
            echo '<a href="' . $_SERVER['PHP_SELF'] . '?page-rules=' . $i . '">' . $i . "</a> ";
        }
    }
    ?>
</div>

<!-- Модальное окно добавления/изменения правила  -->
<div class="modal fade" id="ruleModal" tabindex="-1" role="dialog" aria-labelledby="ruleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Правила для «Требуем»</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body edit-content">
                <div class="form-group">
                    <label class="font-weight-bold" for="sel1">Тип правила:</label>
                    <select class="form-control" id="sel1">
                        <option>ПредСтОснова</option>
                        <option>СтСуф1</option>
                        <option>СтСуф2</option>
                        <option>КатСуф</option>
                        <option>ПричСуф</option>
                        <option>ПричСуф</option>
                        <option>Флекс</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="precondition">Предусловие:</label>
                    <input type="text" class="form-control" id="precondition">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="postcondition">Постусловие:</label>
                    <input type="password" class="form-control" id="postcondition">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="inpit">Вход:</label>
                    <input type="password" class="form-control" id="inpit">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="output">Выход:</label>
                    <input type="password" class="form-control" id="output">
                </div>

                <form method="post" id="ajax_form" action="" >
                    <input type="hidden" id="rule_id_input" name="rule_id" value="0"><br>
                </form>
                <div id="result_form"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Сохранить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#ruleModal').on('show.bs.modal', function(e) {
        var $modal = $(this),
            ruleId = e.relatedTarget.id;
        $modal.find("#rule_id_input").val(ruleId);
        sendAjaxRules('result_form', 'ajax_form', 'ajax/action_ajax_form.php');
    })
</script>

</body>
</html>