<?php
    $show_form = true;
    if(is_numeric($_GET['id']))
    {
        $monitor = Monitor::fetch(intval($_GET['id']));
    }
    else
    {
        $monitor = new $_GET['type']();
    }

    $errors = array();

    if(FormHelpers::donePOST())
    {
        $errors = $monitor->processAddEdit($_POST);
        if(sizeof($errors) == 0)
        {
            $monitor->saveToDb();
            $show_form = false;
?>
<div class="message">
    此监控将被保存. <br />
    <a href="?page=monitors">返回 监控</a>
</div>
<?php
        }
    }

    if($show_form)
    {
?>
<div class="section">
    <h1><?php p($monitor->getId() > 0 ? '编辑' : '添加'); ?> 监控</h1>
    <h2>常规设置</h2>
    <?php 
        if($monitor->getId() != 0)
            FormHelpers::startForm('POST', '?page=monitor&id=' . $monitor->getId());
        else
            FormHelpers::startForm('POST', '?page=monitor&type=' . $_GET['type']);
    ?>
    <div class="form-field">
        <strong>主机:</strong>
        <div class="descr">主机名(domain)或者ip地址.(不加"http://")</div>
        <?php FormHelpers::createText('hostname', $monitor->getHostname(), 'size="30"'); ?>
        <div class="error"><?php FormHelpers::checkError('hostname', $errors); ?></div>
    </div>

    <div class="form-field">
        <strong>端口:</strong>
        <div class="descr">被监控的端口号.</div>
        <?php FormHelpers::createText('port', $monitor->getPort(), 'size="5"'); ?>
        <div class="error"><?php FormHelpers::checkError('port', $errors); ?></div>
    </div>

    <div class="form-field">
        <strong>别名:</strong>
        <div class="descr">此监控的显示别名.</div>
        <?php FormHelpers::createText('alias', $monitor->getAlias()); ?>
        <div class="error"><?php FormHelpers::checkError('alias', $errors); ?></div>
    </div>

    <div class="form-field">
        <strong>失败阈值:</strong>
        <div class="descr">失败多少次将发送通知.</div>
        <?php FormHelpers::createText('fail_threshold', $monitor->getFailThreshold(), 'size="3"'); ?>
        <div class="error"><?php FormHelpers::checkError('fail_threshold', $errors); ?></div>
    </div>
    <h2>状态</h2>
    <div class="form-field">
        <ul class="options">
            <li><?php FormHelpers::createRadio('status', STATUS_UNPOLLED, $monitor->getStatus() == STATUS_ONLINE ||
            $monitor->getStatus() == STATUS_OFFLINE || $monitor->getStatus() == STATUS_UNPOLLED ? 'checked="checked"' :
            ''); ?> 运行
            <div class="descr">检测,更新日志,发送通知.</div>
            </li>
            <li><?php FormHelpers::createRadio('status', STATUS_PAUSED, $monitor->getStatus() == STATUS_PAUSED ?
            'checked="checked"' : ''); ?> 暂停</li>
            <div class="descr">不进行 检测,更新日志,发送通知.</div>
            <li>
            <?php FormHelpers::createRadio('status', STATUS_DOWNTIME, $monitor->getStatus() == STATUS_DOWNTIME ?
            'checked="checked"' : ''); ?> 设定时间 - 开始于
            <?php 
                list($start_h, $start_m) = GuiHelpers::getHoursMinutes($monitor->getDowntimeStart());
                list($end_h, $end_m) = GuiHelpers::getHoursMinutes($monitor->getDowntimeEnd());
                FormHelpers::createText('downtime_start_hours', $start_h, 'size="2"');
                p(' 小时, ');
                FormHelpers::createText('downtime_start_minutes', $start_m, 'size="2"');
                p(' 分钟, 持续 ');
                FormHelpers::createText('downtime_end_hours', $end_h, 'size="2"');
                p(' 小时, ');
                FormHelpers::createText('downtime_end_minutes', $end_m, 'size="2"');
                p(' 分钟.');
            ?>
            <div class="error"><?php FormHelpers::checkError('interval', $errors); ?></div>
            <div class="descr">停机时间内不进行 检测,更新日志,发送通知.</div>
            </li>
        </ul>
    </div>

    <h2>"<?php p($monitor->getName()); ?>" 自定义设置</h2>
    <strong>描述:</strong>
    <div class="type-descr"><?php p($monitor->getDescription()); ?></div>
    <?php require_once(PW2_PATH . '/frontend/forms/monitors/' . get_class($monitor) . '.php'); ?>

    <h2>通知信息</h2>
    <div class="type-descr">这种类型的监控试图建立一个连接到一个web服务运行在HTTP和验证,返回的信息。
        例如,可以看看该短语“错误”是出现在输出来确定服务离线,即使连接成功。</div>
    <div class="form-field">
    <?php
        foreach(GuiHelpers::getAllChannels() as $id => $info) : 
            $channels = $info['channels'];
            if(sizeof($channels) > 0) :
                $c = new Contact($id);
    ?>
    <strong><?php p($c->getName()); ?></strong>
    <ul class="options">
        <?php
            foreach($channels as $chan) :
                $chandle = Channel::fetch(intval($chan['id']));
                if(array_search($chandle->getId(), $monitor->getChanIds()) !== false)
                    $checked = true;
                else
                    $checked = false;
        ?>
            <li><?php
                FormHelpers::createCheckbox('notification_channels[]', $chandle->getId(), $checked ? 'checked="checked"'
                : '');
                p('<strong>' . $chandle->getName() . ':</strong> ' . $chandle); ?></li>
        <?php endforeach; ?>
    </ul>
    <?php
            endif;
        endforeach;
    ?>
    </div>
    <div class="form-field"><center><?php FormHelpers::createSubmit('保 存'); ?></center></div>
    <?php FormHelpers::endForm(); ?>
</div>
<?php
    }
?>
