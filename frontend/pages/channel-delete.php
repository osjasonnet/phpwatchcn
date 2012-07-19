<?php
    $channel = Channel::fetch(intval($_GET['id']));
    $owner = $channel->getOwner();
    if(FormHelpers::donePOST())
    {
        $channel->processDelete($_GET);
        ?>
<div class="message">
    此渠道将被删除 <br />
    <a href="?page=contact&id=<?php p($owner); ?>">返回联系方式</a>
</div>
        <?
    }
    else
    {
?>
<div class="form-field">
</div>
<?php FormHelpers::startForm('POST', '?page=channel-delete&id=' . $channel->getId()); ?>
<?php FormHelpers::createHidden('confirmed', '1'); ?>
<center>
    您确定要删除此联系方式吗?<br />
    <?php FormHelpers::createSubmit('是的'); ?>
</center>
<?php FormHelpers::endForm(); ?>
<?php
    }
?>
