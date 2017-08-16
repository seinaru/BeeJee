<?php
    $post= Model_Admin_Panel::displayPosts();
?>
<div class="container adminTable">
<table style="width: 100%">
    <caption>Список задач пользователей</caption>
    <tr>
        <th>Post ID</th><th>author</th>
        <th>Email</th><th>Message</th>
        <th>Status</th><th>Rewrite</th>
    </tr>
    <?php
        foreach ($post as $value)
        {
            ?><tr style="font-weight: 300px">
            <form action="/admin_panel" method="post">
                <th><input type="hidden" name="id" value="<?php print_r($value['id']);?>"><?php print_r($value['id']);?></th>
                <th><?php print_r($value['name']);?></th>
                <th><?php print_r($value['email']);?></th>
                <th><input type="text" name="message" value="<?php print_r($value['message']); ?>" style="width: 95%; padding: 0px 2%;"></th>
                <th><input type="checkbox"
                           <?php if ($value['progress']=='done') echo'checked="checked"'?> name="check">Выполнено</th>
                <th><input type="submit" name="rewritePost" value="Редактировать" ></th>
            </form>

            </tr><?php
        }
    ?>
</table>
    <a href="/">Вернуться на главную страницу</a>
</div>

