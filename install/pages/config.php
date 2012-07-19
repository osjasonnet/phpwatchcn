<?php
    $errors = false;

    $template = 
'<?php
    $PW2_CONFIG = array(
        \'db_scheme\' => \'MySQL\',
        \'db_info\' => array(
            \'host\' => \'' . $_POST['hostname'] . '\',
            \'user\' => \'' . $_POST['db_user'] . '\',
            \'pass\' => \'' . $_POST['db_pass'] . '\',
            \'db\' => \'' . $_POST['db_name'] . '\'
        ),
        \'path\' => dirname(__FILE__),
    );

    define(\'PW2_VERSION\', \'' . PW2_VERSION . '\');
    define(\'PW2_PATH\', $PW2_CONFIG[\'path\']);

    #mail_type sendmail || client
    define(\'MAIL_TYPE\',\'sendmail\');
    if(MAIL_TYPE == \'client\'){
        define(\'DEFAULT_EMAIL_NAME\',\'\');
        define(\'DEFAULT_EMAIL_ADDR\',\'admin@domin.com\');
        define(\'EMAIL_SENDTYPE\',\'smtp\');
        define(\'EMAIL_HOST\',\'smtp.domain.com\');
        define(\'EMAIL_PORT\',\'465\');
        define(\'EMAIL_SSL\',true);
        define(\'EMAIL_ACCOUNT\',\'service@domain.com\');
        define(\'EMAIL_PASSWORD\',\'password\');
    }

?>';
        $fh = fopen('../config.php', 'w');
        if($fh === false)
        {
?>
        <div class="section">
            <h1>警告</h1>
            安装程序无法打开 <tt>config.php</tt> 文件.  请确保对此文件的读写权限.  刷新页面重试.
        </div>
<?php
            $errors = true;
        }
        else
        {
            if(fwrite($fh, $template) === false)
            {
?>
        <div class="section">
            <h1>警告</h1>
            安装程序无法写入 <tt>config.php</tt> 文件.  请确保对此文件的读写权限.  刷新页面重试.
        </div>
<?php
                $errors = true;
            }
        }

        if(!$errors)
        {
            $conn = mysql_connect("{$_POST['hostname']}","{$_POST['db_user']}","{$_POST['db_pass']}");
            if($conn){
                mysql_query("CREATE DATABASE IF NOT EXISTS `{$_POST['db_name']}`");
            }
?>
<div class="section">
    <h1>恭喜!</h1>
    安装程序写入 <tt>config.php</tt> 成功，请点击 <tt>继续</tt> 完成导入数据库操作.
</div>
<div class="form-field">
    <?php FormHelpers::startForm('POST', './index.php'); ?>
    <?php FormHelpers::createHidden('page', 'import'); ?>
    <center><?php FormHelpers::createSubmit('继 续'); ?></center>
    <?php FormHelpers::endForm(); ?>
</div>
<?php
        }
?>
