<?php
/**
 * Created by PhpStorm.
 * User: batis
 * Date: 02.10.2018
 * Time: 22:46
 */
require_once "inc/header.php";
require_once "inc/Parser.php";
require_once "inc/Pdo_Helper.php";

$db = Pdo_Helper::singleton();
$pars = new Parser();

if (isset($_GET['button_id']) && isset($_GET['source_word'])) {
    $rulesForWord = $pars->getRulesForWord($_GET['button_id']);
} else {
    echo 'Произошла ошибка';
    exit();
}
//print_r($_POST);
?>
    <h4>Правила для <label class="text-success">&laquo;<?= $_GET['source_word'] ?>&raquo;</label></h4>
    <button type="button" onclick="location.href = '<?= $_SERVER['HTTP_REFERER'] ?>'" class="btn btn-outline-primary btn-sm"><span class="oi oi-arrow-thick-left" title="arrow-thick-left" aria-hidden="true"></span>&nbsp; К списку слов</button>
    <br>
    <br>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#linksModal" id="add_rule_button"><span class="oi oi-plus" title="plus" aria-hidden="true"></span>&nbsp;&nbsp;Добавить</button>
    <br>
    <br>
    <table class="table table-hover table-bordered fixtable">
        <thead class="thead-inverse">
        <tr>
            <th>Тип</th>
            <th>Предусловие</th>
            <th>Постусловие</th>
            <th>Вход</th>
            <th>Выход</th>
            <th>Приоритет</th>
            <th>Изменить / Удалить</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($rulesForWord as $items) {
            echo '<tr>';
            foreach ($items as $key => $value) {
                if ($key != 'id')
                    echo '<td>' . $value . '</td>';
            }
            echo '<td><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#linksModal" id="' . $items['id'] . '"><span class="oi oi-pencil" aria-hidden="true"></span></button>&nbsp;&nbsp; <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#ruleModal" id="' . $items['id'] . '"><span class="oi oi-x" aria-hidden="true"></span></button></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>

    <!-- Модальное окно добавления/изменения правила  -->
    <div class="modal fade" id="linksModal" tabindex="-1" role="dialog" aria-labelledby="ruleModalLabel" aria-hidden="true" data-backdrop="static">
        <form class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Новое правило</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body edit-content">
                    <form>
                        <div class="form-group row">
                            <label for="rule_type" class="col-sm-3 col-form-label">Тип:</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="rule_type">
                                    <option>ПредСтОснова</option>
                                    <option>СтСуф1</option>
                                    <option>СтСуф2</option>
                                    <option>КатСуф</option>
                                    <option>ПричСуф</option>
                                    <option>ПричСуф</option>
                                    <option>Флекс</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="precondition" class="col-sm-3 col-form-label">Предусловие:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="precondition">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postcondition" class="col-sm-3 col-form-label">Постусловие:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="postcondition">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_field" class="col-sm-3 col-form-label">Вход:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="input_field">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="output_field" class="col-sm-3 col-form-label">Выход:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="output_field">
                            </div>
                        </div>
                    </form>
                <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </form>
        </div>
    </div>

<?php require_once ("inc/footer.php");