<?php
    $monitor = Monitor::fetch(intval($_GET['id']));
    if(FormHelpers::donePOST())
    {
        $monitor->processDelete($_GET);
        ?>
<div class="message">
    此 监控 将被删除. <br />
    <a href="?page=monitors">返回 监控</a>
</div>
        <?php
    }
    else
    {
?>
<div class="form-field">
</div>
<?php FormHelpers::startForm('POST', '?page=monitor-delete&id=' . $monitor->getId()); ?>
<?php FormHelpers::createHidden('confirmed', '1'); ?>
<center>
    您确定要删除此监控吗?<br />
    <?php FormHelpers::createSubmit('是的'); ?>
</center>
<?php FormHelpers::endForm(); ?>
<?php
    }
?>
