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
        $query = 'SELECT pre_base, first_st_suff, second_st_suff, cat_suff, part_suff, flex FROM words 
            WHERE id = ' . $this->_word_id;
        $transWord = $this->_db->PDO_FetchRow($query);

        $query = 'SELECT * FROM rules r JOIN links l on r.id = l.rule_id 
            WHERE l.word_id = ' . $this->_word_id . ' ORDER BY l.priority';
        $rules = $this->_db->PDO_FetchAll($query);

        foreach ($rules as $values) {
            foreach ($values as $rule_column => $item) {
                if ($item != null)
                    switch ($values['type']) {
                        case 'pre_base':
                            $transWord['pre_base'] = $values['output'];
                            break;
                        case 'first_st_suff':
                            $transWord['first_st_suff'] = $values['output'];
                            break;
                        case 'second_st_suff':
                            $transWord['second_st_suff'] = $values['output'];
                            break;
                        case 'cat_suff':
                            $transWord['cat_suff'] = $values['output'];
                            break;
                        case 'part_suff':
                            $transWord['part_suff'] = $values['output'];
                            break;
                        case 'flex':
                            $transWord['flex'] = $values['output'];
                    }
            }
        }
        return implode($transWord);
    }

    function getResult($word)
    {
        $this->_word_id = $word;
        return $this->transform();
    }
}