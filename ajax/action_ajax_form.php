<?php
/**
 * Created by PhpStorm.
 * User: batis
 * Date: 30.09.2018
 * Time: 11:53
 */
if (isset($_POST["name"]) ) {

    // ��������� ������ ��� JSON ������
    $result = array(
        'name' => $_POST["name"],
        'phonenumber' => "test"
    );

    // ��������� ������ � JSON
    echo json_encode($result);
}