<div class="form-field">
    <strong>超时时间:</strong>
    <div class="descr">超时时间,单位 秒.</div>
    <?php FormHelpers::createText('timeout', $monitor->getTimeout(), 'size="3"'); ?>
    <div class="error"><?php FormHelpers::checkError('timeout', $errors); ?></div>
</div>
