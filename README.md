phpwatchcn
==========

phpwatch cn chinese



===============================
  phpWatch 2.x.x Beta Release
===============================

Thank you for your interest in phpWatch!  After installation, please read the user-guide in the "docs" directory.  If
you find phpWatch helpful, please consider donating at:

   http://phpwatch.net/donate 

===============================

NOTES :
    This is a release of phpWatch 2.  As such, it is not compatible with any phpWatch 1.x.x and must be installed in a
    clean directory, free of any phpWatch 1.x.x files.  Further, it is not currently possible to import settings,
    monitors, nor contact information from phpWatch 1.x.x into a 2.x.x released.

UPDATING :
    Updating from an existing phpWatch 2.x.x installation is done by copying the new files, excluding config.php and the
    /install directory, into your existing phpWatch directory.  Alternatively, all files including these exclusions can
    be copied but the install process will be re-run although no database changes will be made.

EASY INSTALL :
    1) Change the permissions on config.php within the root directory to allow for writing.
    2) Navigate to the install directory from a web browser and follow the instructions.
    3) Delete the install directory and change the permissions of config.php to disallow writing.

MANUAL INSTALL :
    If you prefer a manual installation:
    1) Fill in the database host, user, password, and name in config.php.
    2) Import install/dump.sql into the specified database.
    3) Navigate to the root directory of phpWatch and verify there are no errors.
    4) Delete the install directory.

CRONJOB SETUP :
    To allow phpWatch to query services at a specific interval without human interaction, a cronjob (or scheduled task
    in Windows) must be setup to run cron.php at the desired frequency.  Keep in mind, a full path should be used.
    
    For example, to setup a cronjob that runs every 5 minutes, run "crontab -e" and add the following line to the end of
    the file:

        */5 * * * * php /path/to/phpwatch/root/directory/cron.php
中国版用户认证：
    中国版 增加用户登陆机制，不登陆不允许管理监控查看详情；
    默认用户名：phpwatchcn
    默认密  码：phpwatchcn
    
邮件客户端模式：
    中国版 增加客户端模式，不用管理员设置服务器的邮件环境 利用smtp 就可以发送邮件给接收者
    详见config.php 里关于client的配置
    
已知bug
    未完整的 汉化
    如果联系方式 channel 在用，删除channel后 导致 monitor 报错

===============================
  Contact
===============================

Please report all errors to the developer at:

    http://sourceforge.net/projects/phpwatch/

    - or -

    developers@phpwatch.net

Feature requests are also welcomed.
