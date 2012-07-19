<?php
    require_once(dirname(__FILE__) . '/../common.php');
    require_once(PW2_PATH . '/frontend/GuiHelpers.php');
    require_once(PW2_PATH . '/frontend/FormHelpers.php');
    if(isset($_SESSION['ISLOGIN']) && $_SESSION['ISLOGIN'] || $_GET['page'] == 'login'){
        
    }else{
        header("Location: index.php?page=login");
        exit();
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="content-language" content="en">
		<title>phpWatch :: 开源服务器监控 中文版</title>
		<link rel="stylesheet" type="text/css" href="screen.css">
	</head>
	<body>
		<div id="content">
			<div id="left-column">				
				<div id="subheader">
					<img src="images/logo.jpg" />
					<p><?php p(GuiHelpers::getPage($_GET['page'])); ?></p>
					<p class="right-side">安装版本: v<?php p(PW2_VERSION); ?></p>
				</div>
                <div class="menu">
                <ul>
                    <li><a href="?page=monitors">监控</a></li>
                    <li><a href="?page=contacts">通知</a></li>
                    <?php if(isset($_SESSION['ISLOGIN']) && $_SESSION['ISLOGIN']):?>
                    <li><a href="?page=login&do=changepass">修改管理密码</a></li>
                    <li><a href="?page=login&do=logout">退出</a></li>
                    <?php endif;?>
                </ul>
                </div>
                <?php require('./pages/' . GuiHelpers::getPage($_GET['page']) . '.php'); ?>
			</div>
            <div class="right-block">
                <div>
                    <p class="side-title">监控统计:</p>
                    <p><?php p(GuiHelpers::getStatistic('monitor_count')); ?></p>
                    <p class="side-title">通知统计:</p>
                    <p><?php p(GuiHelpers::getStatistic('contact_count')); ?></p>
                    <p class="side-title">日志统计:</p>
                    <p><?php p(GuiHelpers::getStatistic('log_count')); ?></p>
                    <p class="side-title">最后的离线:</p>
                    <p><?php p(GuiHelpers::formatDateLong(GuiHelpers::getStatistic('last_offline'))); ?></li>
                </div>
            </div>
		</div>
	</body>
</html>
