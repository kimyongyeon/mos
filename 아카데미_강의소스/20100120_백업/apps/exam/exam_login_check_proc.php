<?
	$_zb_url = "/bbs/";
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";

	include $_zb_path."outlogin.php";
	include $_zb_path."../commonLib.php";


	$connect=dbconn();

	$user_id = trim($user_id);
	$password = trim($password);

        if(!get_magic_quotes_gpc()) {
          $user_id = addslashes($user_id);
          $password = addslashes($password);
        }

	if(!$user_id) Error("���̵� �Է��Ͽ� �ֽʽÿ�");
	if(!$password) Error("��й�ȣ�� �Է��Ͽ� �ֽʽÿ�");

// ȸ�� �α��� üũ
	$result = mysql_query("select * from $member_table where user_id='$user_id' and password=old_password('$password')") or error(mysql_error());
	$member_data = mysql_fetch_array($result);

// ȸ���α����� �����Ͽ��� ��� ������ �����ϰ� �������� �̵���
	if($member_data[no]) {
	  $success = "return:ok";
	  echo $success;
	  return $success;
// ȸ���α����� �����Ͽ��� ��� ���� ǥ��
	} else {
	  $error = "return:error";
	  echo $error;
	  return $error;
	}

	@mysql_close($connect);
?>
