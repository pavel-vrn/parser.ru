<?php
/**
 * Created by PhpStorm.
 * User: batis
 * Date: 30.09.2018
 * Time: 11:53
 */
//header('Content-type: application/json');

if (isset($_POST["rule_id"]) ) {

    // Формируем массив для JSON ответа
    $result = array(
        'rule_id' => $_POST["rule_id"],
        'phonenumber' => "test"
    );

    // Переводим массив в JSON
    echo json_encode($result);
}
if (isset($_GET["word_id"])) {
    //$db = Pdo_Helper::singleton();
    //$pars->getRulesForWord($_POST["word_id"]);
    // Формируем массив для JSON ответа
    $result = array(
        'word_id' => $_GET["word_id"],
        'phonenumber' => "test"
    );
    echo json_encode($result);
}