<?php
require_once(PW2_PATH . '/src/DbObject.php');
class Users implements DbObject{

	public function loadById($id){

	}

    public function loadByRow($db_row){

    }

    public function saveToDb(){

    }

    public function checkLogin($username,$md5pass){
    	$md5pass = md5($md5pass . '_PHPWATCHCN');
    	$user = $GLOBALS['PW_DB']->executeSelectOne('*', 'users', "WHERE username='{$username}' AND password='{$md5pass}'");
        if(isset($user['uid']) && $user['uid']>0){
    		$_SESSION['ISLOGIN'] = true;
    		$_SESSION['user_data'] = $user;
    	}
    }

    public function changePass($uid,$md5pass){
    	$md5pass = md5($md5pass . '_PHPWATCHCN');
    	return $GLOBALS['PW_DB']->executeUpdate(array('password'=>$md5pass),'users',"WHERE uid='{$uid}'");
    }
}

?>