<?php 
    if(intval($_GET['query']))
    {
        $m = Monitor::fetch(intval($_GET['query']));
        $m->poll();
        $m->saveToDb();
    }
?>
<div class="menu">
    <ul class="page-menu">
        <li>
            <?php
                FormHelpers::startForm('GET', '?page=monitor');
                FormHelpers::createHidden('page', 'monitor');
            ?>
            <?php
                $options = array();
                foreach($GLOBALS['monitor_types'] as $type)
                {
                    $o = new $type();
                    $options[] = FormHelpers::getOption($o->getName(), $type);
                }
                FormHelpers::createSelect('type', $options);
                FormHelpers::createSubmit('新建监控');
            ?>
            <?php FormHelpers::endForm(); ?>
        </li>
    </ul>
        显示: <a href="?page=monitors">展开</a> - <a href="?page=monitors&expand=none">合并</a>
</div>
<div class="section">
    <h1>监控列表</h1>
    <?php foreach(GuiHelpers::getMonitors() as $monitor) : ?>
    <?php
        switch($monitor->getStatus())
        {
            case STATUS_ONLINE :
                p('<h2 class="online">在线</h2>');
                break;
            case STATUS_OFFLINE :
                p('<h2 class="offline">离线</h2>');
                break;
            case STATUS_PAUSED :
                p('<h2 class="waiting">暂停</h2>');
                break;
            case STATUS_DOWNTIME :
                p('<h2 class="waiting">定时监控</h2>');
                break;
            case STATUS_UNPOLLED :
                p('<h2 class="waiting">未开始检测</h2>');
                break;
        }
    ?>
    <div class="info">
        <div class="right">
            <a href="?page=monitor&id=<?php p($monitor->getId()); ?>">编辑</a> -
            <a href="?page=monitor-delete&id=<?php p($monitor->getId()); ?>">删除</a> - 
            <a href="?page=monitors&query=<?php p($monitor->getId()); ?>">刷新</a>
            <?php
                if(!GuiHelpers::isExpanded($monitor->getId())) :
            ?>
                - <a href="?page=monitors&expand=<?php p($monitor->getId()); ?>">展开</a>
            <?php
                endif;
            ?>
        </div>
        <?php $monitor->getAlias() ? p('<strong>' . $monitor->getAlias() . '</strong> - ') : ''; ?><?php p($monitor->getHostname()); ?>:<?php p($monitor->getPort()); ?>
    </div>
    <?php
            if(GuiHelpers::isExpanded($monitor->getId())) :
    ?>
    <ul class="information">
        <li><strong>通知:</strong>
        <?php
            $contacts = GuiHelpers::getContactsByMonitor($monitor);
            if(is_array($contacts)) :
                foreach($contacts as $i => $c) :
                    if($i > 0) : p(', '); endif;
                    p('<a href="?page=contact&id=' . $c['id'] . '">' . $c['name'] . '</a>');
                endforeach;
            else :
                p('无');
            endif;
        ?>
        <li><strong>最后检测:</strong>
        <?php 
            if($monitor->getStatus() == STATUS_UNPOLLED)
                p('N/A');
            else
                p(GuiHelpers::formatDateLong($monitor->getLastQuery()));
        ?>
        </li>
        <?php
            list($total, $week, $day) = Statistics::get('monitor' . $monitor->getId())
        ?>
        <li>
            <strong>运行时间 (天):</strong> <?php p($day['total'] > 0 ? round(100 * $day['online'] / $day['total'], 2) . '% (' .
            $day['online'] . ' of ' . $day['total'] . ')' : 'N/A'); ?>
        </li>
        <li>
            <strong>运行时间 (周):</strong> <?php p($week['total'] > 0 ? round(100 * $week['online'] / $week['total'], 2) . '% (' .
            $week['online'] . ' of ' . $week['total'] . ')' : 'N/A'); ?>
        </li>
        <li>
            <strong>运行时间 (全):</strong> <?php p($total['total'] > 0 ? round(100 * $total['online'] / $total['total'], 2) . '% (' .
            $total['online'] . ' of ' . $total['total'] . ')' : 'N/A'); ?>
        </li>
    </ul>
    <?php
            endif;
        endforeach;
    ?>
</div>
<script type="text/javascript">
    setInterval(function(){window.location.href = window.location.href;},1000*60*3);    
</script>
