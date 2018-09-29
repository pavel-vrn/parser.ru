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

    //private $_result;

    public function __construct()
    {
        $this->_db = Pdo_Helper::singleton();
    }

    public function getWords() {
        $query = <<<SQL
SELECT id, example, pre_base, first_st_suff, second_st_suff, cat_suff, part_suff, flex FROM words
SQL;
        $result = $this->_db->PDO_FetchAll($query);
        return $result;
    }

    public function getRules() {
        $query = <<<SQL
SELECT type, precondition, postcondition, input, output FROM rules
SQL;
        $result = $this->_db->PDO_FetchAll($query);
        return $result;
    }

    /**
     * @return string
     */
    public function transform()
    {
        //получаем транскрипцию проверямого слова и записываем её в массив
        $query = <<<SQL
SELECT pre_base, first_st_suff, second_st_suff, cat_suff, part_suff, flex FROM words WHERE id = $this->_word_id
SQL;

        $transWord = $this->_db->PDO_FetchRow($query);

        // получаем список правил для проверяемого слова и сортируем их по приоритету
        $query = <<<SQL
SELECT * FROM rules r JOIN links l on r.id = l.rule_id WHERE l.word_id = $this->_word_id ORDER BY l.priority
SQL;

        $rules = $this->_db->PDO_FetchAll($query);

        //применяем по порядку все правила для слова
        foreach ($rules as $value) {
            switch ($value['type']) {
                case 'ПредСтОснова':
                    if ($value['postcondition'] != null) {
                        if ($value['postcondition'] == $transWord['first_st_suff']) {
                            $transWord['pre_base'] = $value['output'];
                        }
                    } else
                        $transWord['pre_base'] = $value['output'];
                    break;
                case 'СтСуф1':
                    if ($value['precondition'] != null && $value['postcondition'] != null) {
                        if ($value['precondition'] == $transWord['pre_base'] && $value['postcondition'] == $transWord['second_st_suff']) {
                            $transWord['first_st_suff'] = $value['output'];
                        }
                    } elseif ($value['precondition'] != null && $value['postcondition'] == null) {
                        if ($value['precondition'] == $transWord['pre_base']) {
                            $transWord['first_st_suff'] = $value['output'];
                        }
                        } elseif ($value['precondition'] == null && $value['postcondition'] != null) {
                            if ($value['postcondition'] == $transWord['second_st_suff']) {
                                $transWord['first_st_suff'] = $value['output'];
                        }
                    } else
                            $transWord['first_st_suff'] = $value['output'];
                    break;
                case 'СтСуф2':
                    if ($value['precondition'] != null && $value['postcondition'] != null) {
                        if ($value['precondition'] == $transWord['first_st_suff'] && $value['postcondition'] == $transWord['cat_suff']) {
                            $transWord['second_st_suff'] = $value['output'];
                        }
                    } elseif ($value['precondition'] != null && $value['postcondition'] == null) {
                        if ($value['precondition'] == $transWord['first_st_suff']) {
                            $transWord['second_st_suff'] = $value['output'];
                        }
                        } elseif ($value['precondition'] == null && $value['postcondition'] != null)
                            if ($value['postcondition'] == $transWord['cat_suff']) {
                                $transWord['second_st_suff'] = $value['output'];
                            } else
                                $transWord['second_st_suff'] = $value['output'];
                    break;
                case 'КатСуф':
                    if ($value['precondition'] != null && $value['postcondition'] != null) {
                        if ($value['precondition'] == $transWord['second_st_suff'] && $value['postcondition'] == $transWord['part_suff']) {
                            $transWord['cat_suff'] = $value['output'];
                        }
                    } elseif ($value['precondition'] != null && $value['postcondition'] == null) {
                        if ($value['precondition'] == $transWord['second_suff']) {
                            $transWord['[cat_suff'] = $value['output'];
                        }
                        } elseif ($value['precondition'] == null && $value['postcondition'] != null) {
                            if ($value['postcondition'] == $transWord['part_suff']) {
                                $transWord['cat_suff'] = $value['output'];
                            }
                            } else
                                $transWord['cat_suff'] = $value['output'];
                    break;
                case 'ПричСуф':
                    if ($value['precondition'] != null && $value['postcondition'] != null) {
                        if ($value['precondition'] == $transWord['cat_suff'] && $value['postcondition'] == $transWord['flex'])
                            $transWord['part_suff'] = $value['output'];
                    } elseif ($value['precondition'] != null && $value['postcondition'] == null)
                        if ($value['precondition'] == $transWord['cat_suff']) {
                            $transWord['part_suff'] = $value['output'];
                        } elseif ($value['precondition'] == null && $value['postcondition'] != null)
                            if ($value['postcondition'] == $transWord['flex']) {
                                $transWord['part_suff'] = $value['output'];
                            } else
                                $transWord['part_suff'] = $value['output'];
                    break;
                case 'Флекс':
                    if ($value['precondition'] != null) {
                        if ($value['precondition'] == $transWord['part_suff']) {
                            $transWord['flex'] = $value['output'];
                        }
                    } else
                        $transWord['flex'] = $value['output'];
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