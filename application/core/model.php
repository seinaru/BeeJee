<?php

class Model
{
    public function get_data()
    {
    }

    public static $sqlDatabaseHost = 'localhost';
    public static $sqlDatabaseName = 'beejee';
    public static $sqlDatabaseUser = 'root';
    public static $sqlDatabasePassword = '';
    public static $pdo;

    public function pdoConnect() {
        try {
            $dsn = 'mysql:host='.self::$sqlDatabaseHost.';dbname='.self::$sqlDatabaseName.';charset=utf8';
            $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            self::$pdo = new PDO($dsn, self::$sqlDatabaseUser, self::$sqlDatabasePassword, $opt);
            self::$pdo->exec("SET NAMES 'utf8'");
            self::$pdo->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            echo 'db error';
            exit;
        }
    }

    public static function goodLook ($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
    public static function sqlQuery($sql, $data = false, $minimal = false, $type = false) {
        if ($minimal && $data) {  // готовим текст запроса
            foreach ($data as $key => $val) {
                if ( $key != 'where' ) {
                    $sql = $sql.' '.$key.' = :'.$key.',';  // переносим массив в строку
                }
            }
            if (substr($sql, -1) == ',') {
                $sql = substr($sql, 0, -1); // WTFuck*!  убераем последнею запятую. костыль, но пока так
            }

            if (isset($data['where'])) {     // проверочка введеного массива на условие
                $i = 0;
                foreach ($data['where'] as $key => $value) {
                    if ($i == 0) {
                        $sql .= ' WHERE '.$key.' = :'.$key.'';
                    } else if ($key != 'etc') {
                        $sql .= ' AND '.$key.' = :'.$key.'';
                    }
                    $i++;
                }
                if (isset($data['where']['etc'])) {
                    $sql .= ' '.$data['where']['etc'];
                }
            }
        }

        try {
            //var_dump($sql); exit;
            $query = Model::$pdo->prepare($sql);   // готовим запрос. текст запроса в условии выше
            if ($data) {
                foreach ($data as $key => $val) {
                    if ( $key == 'where' ) {
                        foreach ($data['where'] as $k => $v) {
                            if ($k != 'etc') {
                                $query->bindParam(":$k", $data['where'][$k], PDO::PARAM_STR);
                            }
                        }
                    } else {
                        $query->bindParam(":$key", $data[$key], PDO::PARAM_STR);
                    }
                }
            }

            try {
                $query->execute();

                if ($type == 'fetchObject') {

                    return $query->fetchObject();
                } else if ($type == 'fetchColumn') {

                } else if ($type == 'fetchAll') {
                    $var = $query->fetchAll();
                    return !empty($var) ? $var : [false];
                } else {
                    return ['lastInsertId' => Model::$pdo->lastInsertId()];
                }
            } catch (Exception $e) {
                //self::saveError($e, 'sqlQuery', false);
                print_r($e);
                return false;
            }


        } catch (Exception $e) {
            //self::saveError($e, 'sqlQuery', false);
            return false;
        }
    }

}