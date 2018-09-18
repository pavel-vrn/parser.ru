<?php
/**
 * Created by PhpStorm.
 * User: batis
 * Date: 13.09.2018
 * Time: 20:34
 */

/*str_replace — Заменяет все вхождения строки поиска на строку замены
stripos — Возвращает позицию первого вхождения подстроки без учета регистра
stristr — Регистронезависимый вариант функции strstr()
strstr — Находит первое вхождение подстроки
strtolower — Преобразует строку в нижний регистр
strtoupper — Преобразует строку в верхний регистр
substr_replace — Заменяет часть строки
substr — Возвращает подстроку
preg_replace — Выполняет поиск и замену по регулярному выражению
array_keys — Возвращает все или некоторое подмножество ключей массива
array_values — Выбирает все значения массива*/

class Parser
{
    /**
     * @var Pdo_Helper
     * Объект для работы с базой данных
     */
    protected $_db;

    private $_word_id;

    private $_result;

    public function __construct()
    {
        $this->_db = Pdo_Helper::singleton();
    }

    function transform()
    {
        $transWord = array();
        $query = "SELECT r.id FROM rules r JOIN links l on r.id = l.rule_id WHERE l.word_id = ". $this->_word_id;
        $rules = $this->_db->PDO_FetchAll($query);

        return $rules;

    }

    function getResult($word)
    {
        $this->_word_id = $word;
        return $this->transform();
    }
}