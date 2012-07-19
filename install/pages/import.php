<?php
    require_once(PW2_PATH . '/src/db_schemes/' . $PW2_CONFIG['db_scheme'] . '.php');
    if(($f = file_get_contents('dump.sql')) === false)
    {
?>
    <div class="section">
        <h1>警告</h1>
        安装程序无法读取<tt>install/dump.sql</tt>.  请确保此文件存在并且有读权限.
        刷新页面重试.
    </div>
<?php
    }
    else
    {
        $GLOBALS['PW_DB'] = new $PW2_CONFIG['db_scheme']($PW2_CONFIG['db_info']['host'], $PW2_CONFIG['db_info']['db'], $PW2_CONFIG['db_info']['user'], $PW2_CONFIG['db_info']['pass']);
        if($GLOBALS['PW_DB']->connect() === false)
        {
?>
    <div class="section">
        <h1>警告</h1>
        安装程序无法连接到数据库.  请确保您填写的数据库信息正确.
    </div>
<?php
        }
        else
        {
            $cmds = explode(";\n", $f);
            $errors = false;
            foreach($cmds as $c)
            {
                if(strlen($c) > 0 && $GLOBALS['PW_DB']->query($c) == false)
                {
                    $errors = true;
                    echo mysql_error();
                }
            }
            if($errors)
            {
?>
    <div class="section">
        <h1>警告</h1>
        安装程序不能执行数据库操作.  请确保您所填写的用户具有该数据库的 SELECT, INSERT, UPDATE, DELETE, 和 CREATE 权限.
    </div>
<?php
            }
            else
            {
?>
    <div class="section">
        <h1>恭喜!</h1>
        安装成功!  请删除install目录并更改 配置文件权限<tt>config.php</tt>.  点击 <a href="../index.php">这里</a> 开始使用 phpWatch cn.
    </div>
<?php
            }
        }
    }
?>
