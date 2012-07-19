<?php FormHelpers::startForm('POST', './index.php'); ?>
<?php FormHelpers::createHidden('page', 'config'); ?>
<div class="section">
    <div class="invalid">这是一个全新的版本。请确保您的数据中数据没有价值 或者 为空。</div>
    <h1>数据库信息</h1>
    <div class="form-field">
        <strong>主机/IP:</strong>
        <div class="descr">数据库服务器 主机名 或 IP.</div>
        <?php FormHelpers::createText('hostname', 'localhost'); ?>
    </div>
    <div class="form-field">
        <strong>数据库名:</strong>
        <div class="descr">填写数据库名.</div>
        <?php FormHelpers::createText('db_name', ''); ?>
    </div>
    <div class="form-field">
        <strong>数据库用户名:</strong>
        <div class="descr">用户权限应具备对上述数据库的SELECT, INSERT, UPDATE, DELETE, CREATE 权限.</div>
        <?php FormHelpers::createText('db_user', ''); ?>
    </div>
    <div class="form-field">
        <strong>数据库密码:</strong>
        <div class="descr">以上填写用户的密码.</div>
        <?php FormHelpers::createText('db_pass', ''); ?>
    </div>
    <div class="form-field"><center><?php FormHelpers::createSubmit('继 续'); ?></center></div>
    <?php FormHelpers::endForm(); ?>
</div>
