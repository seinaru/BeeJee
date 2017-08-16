<?php

class View
{
    function generate($content_view, $view_template, $data = null)
    {
        /*
        if(is_array($data)) {
            // преобразуем элементы массива в переменные
            extract($data);
        }
        */

        include 'application/views/'.$view_template;
    }
}