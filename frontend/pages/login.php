<?php
$changepass = isset($_GET['do']) && $_GET['do']=='changepass' ? true : false;
if(isset($_GET['do']) && $_GET['do']=='logout'){
	$_SESSION['ISLOGIN'] = 0;
	session_destroy();
}
if(FormHelpers::donePOST()){
	$user = new Users();
	if(!$changepass){
		$username = FormHelpers::sPost('username');
		$password = md5(FormHelpers::sPost('password'));
		$user->checkLogin($username,$password);	
	}else{
		if(isset($_SESSION['user_data']['uid'])){
			$uid = intval($_SESSION['user_data']['uid']);
			$password = md5(FormHelpers::sPost('password'));
			$password2 = md5(FormHelpers::sPost('password2'));
			if($password2 === $password){
				$change = $user->changePass($uid,$password);
				if($change){
					echo "<script type=\"text/javascript\">alert('修改成功！');window.location.href=\"index.php?page=monitors\";</script>";
					exit();
				}else{
					echo "<script type=\"text/javascript\">alert('修改失败！');</script>";
				}
			}else{
				echo "<script type=\"text/javascript\">alert('两次密码不一致！');</script>";
				exit();
			}
		}
	}
}
if(!$changepass){
	if(isset($_SESSION['ISLOGIN']) && $_SESSION['ISLOGIN']){
		echo "<script type=\"text/javascript\">window.location.href=\"index.php?page=monitors\";</script>";
		exit();
	}
}
?>
<style>
.login-box{margin-top: 30px;}
.field{margin:10px auto 0px auto;width: 300px;text-align: center;}
.field .username,.field .password,.field .password2{width:180px;margin-left: 10px;}
</style>

<div class="form-field">
	<?php if(!$changepass):?>
	<div class="login-box">
		<?php FormHelpers::startForm('POST', '?page=login', 'name="login"'); ?>
		<div class="field">账户: <?php FormHelpers::createText('username','','class="username"');?></div>
		<div class="field">密码: <?php FormHelpers::createPass('password','','class="password"');?></div>
		<div class="field"><?php FormHelpers::createSubmit('登 陆','','class="login-sub"');?></div>
		<?php FormHelpers::endForm();?>
	</div>
	<?php else:?>
	<?php if(isset($_SESSION['ISLOGIN']) && $_SESSION['ISLOGIN']):?>
	<div class="login-box">
		<?php FormHelpers::startForm('POST', '?page=login&do=changepass', 'name="login" onsubmit="return checkChange();"'); ?>
		<div class="field">密码: <?php FormHelpers::createPass('password','','class="password" id="password1"');?></div>
		<div class="field">确认: <?php FormHelpers::createPass('password2','','class="password2" id="password2"');?></div>
		<div class="field"><?php FormHelpers::createSubmit('修 改','','class="login-sub"');?></div>
		<?php FormHelpers::endForm();?>
		<script type="text/javascript">
			function checkChange(){
				var password1 = document.getElementById('password1').value;
				var password2 = document.getElementById('password2').value;
				if(password1==''||password2==''){
					alert('请完整输入两次密码！');
					return false;
				}else if(password1!=password2){
					alert('两次密码不一致！');
					return false;
				}
				return true;
			}
		</script>
	</div>
	<?php endif;?>
	<?php endif;?>
</div>