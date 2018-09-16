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
preg_replace — Выполняет поиск и замену по регулярному выражению*/

class Parser
{
    private $_inputWord;

    function transform()
    {
        $input = strtolower($this->_inputWord);
        foreach ($this->_rules as $key => $value) {
            if ($input == strtolower($key)) {
              return $value;
            }
        }
        return "Ошибка";
    }

    function getResult()
    {
        //$this->_inputWord = $word;
        //return $this->transform();
    }
}