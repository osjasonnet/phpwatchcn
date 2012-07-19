<?php
    $errors = false;
?>
<div class="section">
    <h1>phpWatch cn 安装</h1>
    <p>感谢您选择<strong>phpWatch cn</strong> 请您按操作提示进行安装:</p>
    <ul>
        <li>配置数据库.</li>
        <li>config.php 可写:
        <?php
            if(is_writable('../config.php'))
            {
                p('<div class="valid">是的</div>');
            }
            else
            {
                $errors = true;
                p('<div class="invalid">不可以</div>');
            }
        ?>
        </li>
    </ul>
    <?php FormHelpers::startForm('POST', './index.php'); ?>
    <?php FormHelpers::createHidden('page', 'database'); ?>
    <center><?php FormHelpers::createSubmit('继 续', ($errors ? 'disabled="disabled"' : null)); ?></center>
    <?php FormHelpers::endForm(); ?>
</div>
