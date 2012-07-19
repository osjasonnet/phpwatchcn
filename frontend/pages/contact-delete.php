<?php
    $contact = new Contact(intval($_GET['id']));
    if(FormHelpers::donePOST())
    {
        $contact->processDelete($_GET);
        ?>
<div class="message">
    此通知方式将被删除. <br />
    <a href="?page=contacts">返回通知</a>
</div>
        <?php
    }
    else
    {
?>
<div class="form-field">
</div>
<?php FormHelpers::startForm('POST', '?page=contact-delete&id=' . $contact->getId()); ?>
<?php FormHelpers::createHidden('confirmed', '1'); ?>
<center>
    您确定要删除此通知方式？<br />
    <?php FormHelpers::createSubmit('是的'); ?>
</center>
<?php FormHelpers::endForm(); ?>
<?php
    }
?>
