<?php
    $show_form = true;
    if(is_numeric($_GET['id']))
    {
        $contact = new Contact(intval($_GET['id']));
    }
    else
    {
        $contact = new Contact();
    }

    $errors = array();

    if(FormHelpers::donePOST())
    {
        $errors = $contact->processAddEdit($_POST);
        if(sizeof($errors) == 0)
        {
            $contact->saveToDb();
            $show_form = false;
?>
<div class="message">
    此通知信息将被保存. <br />
    <a href="?page=contact&id=<?php p($contact->getId()); ?>">返回 "<?php p($contact->getName()); ?>"</a> | 
    <a href="?page=contacts">返回通知列表</a>
</div>
<?php
        }
    }
    
    if($show_form)
    {
?>
<div class="section">
    <h1><?php p($contact->getId() > 0 ? '编辑' : '添加'); ?>通知方式</h1>
    <h2>常规设置</h2>
    <?php 
        FormHelpers::startForm('POST', '?page=contact&id=' . $contact->getId(), 'name="general"');
    ?>
        <div class="form-field">
            <strong>名称:</strong>
            <div class="descr">通知信息名称.</div>
            <?php FormHelpers::createText('name', $contact->getName(), 'size="30"'); ?>
            <div class="error"><?php FormHelpers::checkError('name', $errors); ?></div>
        </div>
    <div class="form-field"><center><?php FormHelpers::createButton('保 存', 'onClick="document.general.submit()"'); ?></center></div>
    <?php
        FormHelpers::endForm();
        if($contact->getId() != null) :
    ?>
    <h2>通知渠道</h2>
    <strong>描述:</strong>
    <div class="type-descr">添加、删除和修改的通道将被自动保存。.</div>
    <?php
        if($contact->getId() != null)
        {
            $existing = GuiHelpers::getAllChannels($contact->getId());
            $existing = $existing[$contact->getId()]['channels'];
            foreach($existing as $e) :
                $chandle = Channel::fetch(intval($e['id']));
                ?>
                    <div class="info">
                        <?php p($chandle->getName()); ?> 
                        <div class="right">
                            <a href="?page=channel&id=<?php p($e['id']); ?>">编辑</a> -
                            <a href="?page=channel-delete&id=<?php p($e['id']); ?>">删除</a>
                        </div>
                        <div class="descr"><?php p($chandle); ?></div>
                    </div>
                <?php
            endforeach;
        }
    ?>
    <div class="form-field">
    <?php
        FormHelpers::startForm('GET', '?page=channel', 'name="newchan"');
        FormHelpers::createHidden('page', 'channel');
        FormHelpers::createHidden('contact_id', $contact->getId());
        $options = array();
        foreach($GLOBALS['channel_types'] as $type)
        {
            $o = new $type();
            $options[] = FormHelpers::getOption($o->getName(), $type);
        }
        FormHelpers::createSelect('type', $options);
        FormHelpers::createSubmit('添加通知渠道');
        FormHelpers::endForm();
    ?>
    </div>
    <?php endif; ?>
</div>
<?php
    }
?>
