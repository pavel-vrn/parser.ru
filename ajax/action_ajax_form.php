<?php
/**
 * Created by PhpStorm.
 * User: batis
 * Date: 30.09.2018
 * Time: 11:53
 */
if (isset($_POST["name"]) ) {

    // Формируем массив для JSON ответа
    $result = array(
        'name' => $_POST["name"],
        'phonenumber' => "test"
    );

    // Переводим массив в JSON
    echo json_encode($result);
}