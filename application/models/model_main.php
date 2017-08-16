<?php

class Model_Main extends Model
{
    function __construct() {
        self::pdoConnect();
    }

    public static function addMessage()
    {
       if (!empty($_POST['author']) && !empty($_POST['email']) && !empty($_POST['comment'])) {
           $dataArray = array(
               'name' => $_POST['author'],
               'email' => $_POST['email'],
               'message' => $_POST['comment'],
               'image' => $_FILES['userfile']['name']
           );

           self::sqlQuery("INSERT INTO post SET", $dataArray, true);
       } else {
           echo 'Не удалось добавить заметку. Не все поля были заполнены.';
       }

    }
    // Функция изменения размера
    public static function resize($file)
    {
        // Ограничение по ширине в пикселях
        $max_height_size = 240;
        $max_width_size = 320;

        // Cоздаём исходное изображение на основе исходного файла
        if ($file['type'] == 'image/jpeg')
            $source = imagecreatefromjpeg($file['tmp_name']);
        elseif ($file['type'] == 'image/png')
            $source = imagecreatefrompng($file['tmp_name']);
        elseif ($file['type'] == 'image/jpg')
            $source = imagecreatefromgif($file['tmp_name']);
        else
            return false;

        // Определяем ширину и высоту изображения
        $w_src = imagesx($source);
        $h_src = imagesy($source);

        // Если размер больше заданной
        if ($w_src > $max_width_size or $h_src > $max_height_size)
        {
            // Вычисление пропорций
            if ($w_src > $max_width_size)
            {
                $ratio = $w_src/$max_width_size;
            } else {
                $ratio = $h_src/$max_height_size;
            }

            $w_dest = round($w_src/$ratio);
            $h_dest = round($h_src/$ratio);

            // Создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest);
            $image = imagecreatefromjpeg('images/' . $_FILES['userfile']['name']);
            imagecopyresampled($dest, $image, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

            // Вывод картинки и очистка памяти
            imagejpeg($dest, 'images/' . $_FILES['userfile']['name']);
            imagedestroy($dest);
            imagedestroy($source);

            return $file['name'];
        }
        else
        {
            // Вывод картинки и очистка памяти
            imagejpeg($source, 'images/' . $_FILES['userfile']['name']);   ////////////////////
            imagedestroy($source);

            return $file['name'];
        }
    }
    public static function pageNav ($pageSort, $pageNum) {
        $query = "SELECT COUNT(*) FROM post";  //считае количество записей для подсчета страниц
        $result = Model::$pdo->prepare($query);
        $result->execute();
        $rs = $result->fetchAll(PDO::FETCH_ASSOC);

        $timeVar = $rs [0]['COUNT(*)'];
        $timeVar = ceil($timeVar/3); // общее количество страниц
        echo 'Страница:';
        for ($i = 1; $i<=$timeVar; $i++)
        {
            if ($i == $timeVar) {
                $nummberOfPage = '<a href= /main?page&'. ($i) .''.$pageSort .' class="pageNavigation">'. ($i) .'</a>';
            } else {
                $nummberOfPage = '<a  href= /main?page&'. ($i) .''.$pageSort.' class="pageNavigation">'. ($i) .'</a> | ';
            }

            if ($pageNum == $i)
            {
                echo '<b>'.$nummberOfPage.'</b>';
            } else {
                echo $nummberOfPage;
            }
        }
    }
    public static function dataCheck() {
        if (!empty($_POST)) if ($_POST['form']=='newPost')
        {
            $uploaddir = '/images/';

            if ($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_POST['author']) )
            {
                if (!@copy($_FILES['userfile']['tmp_name'], 'images/' . $_FILES['userfile']['name']))
                    echo 'Что-то пошло не так';
                else
                    echo 'Загрузка удачна';
            }

            // Массив допустимых значений типа файла
            $types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');
            // Максимальный размер файла
            $size = 1024000;

            // Обработка запроса
            if ($_SERVER['REQUEST_METHOD'] == 'POST' )
            {
                if (!empty($_FILES['userfile']['name']))
                {
                    // Проверяем тип файла
                    if (!in_array($_FILES['userfile']['type'], $types))
                    {
                        print_r("$_FILES:".$_FILES['userfile']['type']);
                        die('<p>Запрещённый тип файла. <a href="/">Попробовать другой файл?</a></p>');
                    }

                    // Проверяем размер файла
                    if ($_FILES['userfile']['size'] > $size)
                        die('<p>Слишком большой размер файла. <a href="/">Попробовать другой файл?</a></p>');

                    Model_Main::resize($_FILES['userfile']);
                }
                Model_Main::addMessage();
                header("location: /");
                exit;
            }
        }
    }
    public static function getParams () {
        $page = explode('=',$_SERVER['REQUEST_URI']);
        /***** выбераем параметры сортировки *****/
        if (count($page)>1)
        {
            if ($page[1]!=="") $pageSort = '='.$page[1];
        } else {
            $pageSort = '';
        }
        /***** выбераем номер страницы *****/
        $page = explode('?',$_SERVER['REQUEST_URI']);

        foreach ($page as $value)
        {
            if (strripos($value, 'age') == 1) {
                $pageNum = explode('&',$value);
                $pageNum = explode('=',$pageNum[1]);
                $pageNum = $pageNum[0];
            } else {
                $pageNum = 1;
            }
        }

        $shift = $pageNum-1;
        $count = 3; // количество выводимых товаров+

        if ($pageSort !== '') {
            $queryParams = mb_substr($pageSort, 1);
            $queryParams = explode('_',$queryParams);
            if ($queryParams[1] == 'A') {
                $queryParams = 'ORDER BY '.$queryParams[0]." ";
            } else {
                $queryParams = 'ORDER BY '.$queryParams[0].' DESC ';
            }
        } else {
            $queryParams = '';
        }

        $query = "SELECT * FROM post ".$queryParams."LIMIT ".$shift*$count.", ".$count;// Делаем выборку $count записей, начиная с $shift + 1.
        $result = Model::$pdo->prepare($query);
        $result->execute();
        $posts = $result->fetchAll(PDO::FETCH_ASSOC);
        $params = array (
            'posts'=>$posts,
            'pageNum'=>$pageNum,
            'pageSort'=>$pageSort,
        );
        return $params;
    }
    public static function admin ()
    {
        if (session_status() == PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        if (!empty($_POST)) if ($_POST['form']=='auth' )
        {
            if ($_POST['login']=="admin" & $_POST['password']=="123")
            {

                echo '<span style="margin: 0 5% 5%;">hello admin!</span>';
                echo '<a href="/admin_panel">перейти в админку </a>';
                //Стартуем сессию:
                //Пишем в сессию информацию о том, что мы авторизовались:
                $_SESSION['auth'] = true;
                $_SESSION['login'] = $_POST['login'];
                //Пишем в сессию статус пользователя (приоритет):
                $_SESSION['status'] = 10;
            }
        }
    }
}
