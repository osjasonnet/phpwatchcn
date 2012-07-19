<div class="type-descr">短信息格式.  参考<a href="http://php.net/manual/en/function.sprintf.php" target="_new">sprintf</a>.</div>
<div class="form-field">
    <strong>标题格式:</strong>
    <div class="descr">短消息标题格式定义.</div>
    <?php
        if($channel->getSubjectFormat())
            $subj = $channel->getSubjectFormat();
        else
            $subj = '服务离线';
        FormHelpers::createText('subject', $subj);
    ?>
    <div class="error"><?php FormHelpers::checkError('subject', $errors); ?></div>
    </div>
<div class="form-field">
    <strong>内容格式:</strong>
    <div class="descr">发送内容的格式定义.</div>
    <?php
        if($channel->getMessageFormat())
            $msg = $channel->getMessageFormat();
        else
            $msg = '%s:%d (%s) 离线.';
        FormHelpers::createTextArea('message', $msg, 'rows="5" cols="100"');
    ?>
    <div class="error"><?php FormHelpers::checkError('message', $errors); ?></div>
</div>
<div class="form-field">
    <strong>手机号码:</strong>
    <div class="descr">手机号码,不加区域号码.</div>
    <?php FormHelpers::createText('number', $channel->getNumber()); ?>
    <div class="error"><?php FormHelpers::checkError('number', $errors); ?></div>
</div>
<div class="form-field">
    <strong>运行商:</strong>
    <div class="descr">移动联通电信.</div>
    <?php
        $options = array();
        foreach(array_keys(SmsChannel::$carriers) as $c)
            $options[] = FormHelpers::getOption($c, $c, ($channel->getCarrier() == $c ? 'selected="selected"' : null));
        FormHelpers::createSelect('carrier', $options);
    ?>
    <div class="error"><?php FormHelpers::checkError('number', $errors); ?></div>
</div>
