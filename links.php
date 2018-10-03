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

if (isset($_POST['button_id'])) {
    $rulesForWord = $pars->getRulesForWord($_POST['button_id']);
} else {
    echo 'Произошла ошибка';
    exit();
}
//print_r($_POST);
var_dump($_SERVER);
?>
    <h4>Правила для &laquo;стлать&raquo;</h4>
<form action="<?= $_SERVER['HTTP_REFERER'] ?>">
    <button type="submit" class="btn btn-outline-primary" data-toggle="modal" data-target="#linksModal" value="test"><span class="oi oi-arrow-thick-left" title="arrow-thick-left" aria-hidden="true"></span>&nbsp; К списку слов</button>
</form>
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
            echo '<td><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#linksModal" id="' . $items['id'] . '" value="test"><span class="oi oi-pencil" title="pencil" aria-hidden="true"></span></button></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>

<?php require ("inc/footer.php");