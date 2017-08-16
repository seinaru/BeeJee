<?php

class Model_Admin_Panel extends Model
{
    function __construct()
    {
        self::pdoConnect();
    }
    public static function displayPosts ()
    {
        $posts = Model::sqlQuery("SELECT * FROM post",false, true, 'fetchAll');
        return $posts;
    }

    public static function rewritePost () {
        if (isset($_POST['rewritePost']))
        {
            if (isset($_POST['check'])){
                if ($_POST['check'] == 'on') {
                    $progress = 'done';
                }
            }else {
                $progress = 'in progress';
            }
            $query = 'UPDATE post SET `message`="'.$_POST['message'].'", progress="'.$progress.'" WHERE id='. $_POST['id'];
            Model::$pdo->exec($query);
            echo "<meta http-equiv='refresh' content='0; URL='/admin_panel'' />";

        }
    }
}