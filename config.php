<?php
    $PW2_CONFIG = array(
        'db_scheme' => 'MySQL',
        'db_info' => array(
            'host' => '',
            'user' => '',
            'pass' => '',
            'db' => ''
        ),
        'path' => dirname(__FILE__),
    );

    define('PW2_VERSION', '_cn 0.1 by 2.0.4');
    define('PW2_PATH', $PW2_CONFIG['path']);

    #mail_type sendmail || client
    define('MAIL_TYPE','sendmail');
    if(MAIL_TYPE == 'client'){
        define('DEFAULT_EMAIL_NAME','');
        define('DEFAULT_EMAIL_ADDR','admin@domin.com');
        define('EMAIL_SENDTYPE','smtp');
        define('EMAIL_HOST','smtp.domain.com');
        define('EMAIL_PORT','465');
        define('EMAIL_SSL',true);
        define('EMAIL_ACCOUNT','service@domain.com');
        define('EMAIL_PASSWORD','password');
    }

?>