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

	if(!$user_id) Error("아이디를 입력하여 주십시요");
	if(!$password) Error("비밀번호를 입력하여 주십시요");

// 회원 로그인 체크
	$result = mysql_query("select * from $member_table where user_id='$user_id' and password=old_password('$password')") or error(mysql_error());
	$member_data = mysql_fetch_array($result);

// 회원로그인이 성공하였을 경우 세션을 생성하고 페이지를 이동함
	if($member_data[no]) {
	  $success = "return:ok";
	  echo $success;
	  return $success;
// 회원로그인이 실패하였을 경우 에러 표시
	} else {
	  $error = "return:error";
	  echo $error;
	  return $error;
	}

	@mysql_close($connect);
?>
