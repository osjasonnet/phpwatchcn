<?php
    $show_form = true;
    if(is_numeric($_GET['id']))
    {
        $channel = Channel::fetch(intval($_GET['id']));
    }
    else
    {
        $channel = new $_GET['type']();
        $channel->setOwner(intval($_GET['contact_id']));
    }

    $errors = array();

    if(FormHelpers::donePOST())
    {
        $errors = $channel->processAddEdit($_POST);
        if(sizeof($errors) == 0)
        {
            $channel->saveToDb();
            $show_form = false;
?>
<div class="message">
    此联系方式将被保存<br />
    <a href="?page=contact&id=<?php p($channel->getOwner()); ?>">返回联系方式</a>
</div>
<?php
        }
    }
    
    if($show_form)
    {
?>
<div class="section">
    <h1><?php p($channel->getId() > 0 ? '编辑' : '添加'); ?>通知渠道</h1>
    <h2>基本信息</h2>
    <div class="form-field"><strong>联系名称:</strong> <?php $c = new Contact($channel->getOwner());
    p($c->getName()); ?></div>
    <div class="form-field"><strong>渠道类型: </strong><?php p($channel->getName()); ?>
    <div class="form-field"><strong>描述: </strong><?php p($channel->getDescription()); ?></div>
    </div>

    <h2>配置</h2>
    <?php
        if($channel->getId() != null)
        {
            FormHelpers::startForm('POST', '?page=channel&id=' . $channel->getId());
        }
        else
        {
            FormHelpers::startForm('POST', '?page=channel&contact_id=' . $channel->getOwner() . '&type=' . $_GET['type']);
        }
        require_once(PW2_PATH . '/frontend/forms/channels/' . get_class($channel) . '.php');
    ?>
    <div class="form-field"><center><?php FormHelpers::createSubmit('Submit'); ?></center></div>
    <?php FormHelpers::endForm(); ?>
</div>
<?php
    }
?>
