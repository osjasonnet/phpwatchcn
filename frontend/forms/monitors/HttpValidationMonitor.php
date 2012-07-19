<div class="form-field">
    <strong>超时时间:</strong>
    <div class="descr">超时时间,单位 秒.</div>
    <?php FormHelpers::createText('timeout', $monitor->getTimeout(), 'size="3"'); ?>
    <div class="error"><?php FormHelpers::checkError('timeout', $errors); ?></div>
</div>
<div class="form-field">
    <strong>模式:</strong>
    <div class="descr">检测响应.</div>
    <?php FormHelpers::createText('match_str', $monitor->getMatchString(), 'size="50"'); ?>
    <div class="error"><?php FormHelpers::checkError('match_str', $errors); ?></div>
</div>
<div class="form-field">
    <strong>匹配方法:</strong>
    <div class="descr">检测匹配方式</div>
    <ul class="options">
    <li><?php FormHelpers::createRadio('match_method', HttpValidationMonitor::$MATCH_FIND, $monitor->getMatchMethod() ==
    HttpValidationMonitor::$MATCH_FIND ? 'checked="checked"' : ''); ?>基本匹配(200)</li>
    <li><?php FormHelpers::createRadio('match_method', HttpValidationMonitor::$MATCH_REGEX, $monitor->getMatchMethod()
    == HttpValidationMonitor::$MATCH_REGEX ? 'checked="checked"' : ''); ?>使用正则表达式</li>
    </ul>
    <div class="error"><?php FormHelpers::checkError('match_method', $errors); ?></div>
</div
><div class="form-field">
    <strong>条件:</strong>
    <div class="descr">是否必须在线</div>
    <ul class="options">
    <li><?php FormHelpers::createRadio('mode', HttpValidationMonitor::$MODE_DOES_CONTAIN, $monitor->getMode() ==
    HttpValidationMonitor::$MODE_DOES_CONTAIN ? 'checked="checked"' : ''); ?> 必须匹配时在线.</li>
    <li><?php FormHelpers::createRadio('mode', HttpValidationMonitor::$MODE_DOESNT_CONTAIN, $monitor->getMode() ==
    HttpValidationMonitor::$MODE_DOESNT_CONTAIN ? 'checked="checked"' : ''); ?> 必须不匹配时在线.</li>
    </ul>
    <div class="error"><?php FormHelpers::checkError('mode', $errors); ?></div>
</div>
