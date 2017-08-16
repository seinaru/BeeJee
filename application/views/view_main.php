<?php
    Model_Main::admin();
    Model_Main::dataCheck();
    $params = Model_Main::getParams();
?>
<script src="/js/preview.js"></script>

<div class="container">
    <form class="form-inline" action="/" method="post">
        <div class="form-group">
            <input type="hidden" name="form" value="auth">
            <label name="form" class="sr-only" for="exampleInputEmail3">Email address</label>
            <input name="login" type="text" class="form-control" id="exampleInputEmail3" placeholder="login">
        </div>
        <div class="form-group">
            <label class="sr-only" for="exampleInputPassword3">Password</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox"> Remember me
            </label>
        </div>
        <button type="submit" class="btn btn-default">Sign in</button>
    </form>

            <!--    Форма для добавления задачи    -->

    <div>
        <h2>Добавить новую задачу:</h2>
        <form class="form-horizontal" action="/" method="post" id="commentform" enctype="multipart/form-data" name="post">
            <input type="hidden" name="form" value="newPost">
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3" >
                <label for="author">Name</label>
                <input type="text" name="author" class="form-control" id="author" placeholder="Введите имя">
            </div>
            <div class="form-group col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Введите Email">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <textarea name="comment" id="comment" class="form-control col-lg-5 col-md-5 col-sm-5 col-xs-5" rows="5"></textarea>
            </div>


            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                <input name="userfile" type="file" multiple accept="image/png,image/jpg,image/jpeg">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input type="button" value="Проверить" onclick="Show()">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="comment-preview-block" style="display: none">

            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-default ">Отправить задачу</button>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        function Sorter()
        {
            document.getElementById('go').submit();
        }
    </script>

</div>
<div class="container">
    <form class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" action="/" method="get" name="go" >
        <p><select size="1"  name="hero[]" onchange="this.form.submit()">
                <option selected disabled>Выберите тип сортировки</option>
                <option value="id_A">Снять сортировку</option>
                <option value="name_A">Сортировать по имени от А до Я</option>
                <option value="name_Z">Сортировать по имени от Я до А</option>
                <option value="email_A">Сортировать по Email от А до Я</option>
                <option value="email_Z">Сортировать по Email от Я до А</option>
                <option value="progress_A">Показать сначала выполненые задачи</option>
                <option value="progress_Z">Показать сначала не выполненые задачи</option>
            </select></p>
    </form>


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="container" style="padding: 2vh 0 ;">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <span>Image</span>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <span>Login</span>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <span>Email</span>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <span>Post</span>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <span>Task</span>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <span>Progress</span>
        </div>
            </div>
        <?php
        /****** вывод постов *****/
        foreach ($params['posts'] as $value)
        {
        ?>
            <div class="container" style="padding: 2vh 0 ;">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <img src="<?php
            if ($value['image']!== '')
                echo '../../images/'.$value['image'];
            else
                echo '../../images/images.png';
            ?>" width="100%">
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <span><?php print_r($value['name']); ?></span>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <span><?php print_r($value['email']);?></span>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <span><?php print_r($value['id']);?></span>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <span><?php print_r($value['message']);?></span>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <img src="<?php if ($value['progress']=='done')
    echo'../../images/done.png'; else echo '../../images/work-in-progress.png'; ?>
            " width="100%">

        </div>
            </div>

<?php } ?>
    </div>





<?php

/****** навигация по страницам ******/
    Model_Main::pageNav($params['pageSort'], $params['pageNum']);
?>

<script type="text/javascript">
    function Sorter()
    {
        document.getElementById('go').submit();
    }
</script>

<form action="/" method="get" name="go" >
    <p><select size="1"  name="hero[]" onchange="this.form.submit()">
            <option selected disabled>Выберите тип сортировки</option>
            <option value="id_A">Снять сортировку</option>
            <option value="name_A">Сортировать по имени от А до Я</option>
            <option value="name_Z">Сортировать по имени от Я до А</option>
            <option value="email_A">Сортировать по Email от А до Я</option>
            <option value="email_Z">Сортировать по Email от Я до А</option>
            <option value="progress_A">Показать сначала выполненые задачи</option>
            <option value="progress_Z">Показать сначала не выполненые задачи</option>
        </select></p>
</form>

</div>
</div>