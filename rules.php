<?php
require_once "inc/header.php";
require_once "inc/Parser.php";
require_once "inc/Pdo_Helper.php";

$db = Pdo_Helper::singleton();

$pars = new Parser();
$result = $pars->getresult(1);
//$words = $pars->getWords();
//$rules = $pars->getRules();
?>
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

<?php require ("inc/footer.php");