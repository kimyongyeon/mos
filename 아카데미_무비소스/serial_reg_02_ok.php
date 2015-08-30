<?
	$_zb_url = "/bbs/";
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";   

	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("정상적으로 작성하여 주시기 바랍니다.");
	if(!eregi("serial_reg_02.php",$HTTP_REFERER)) Error("정상적으로 작성하여 주시기 바랍니다","");
	if(getenv("REQUEST_METHOD") == 'GET' ) Error("정상적으로 글을 쓰시기 바랍니다","");

// DB 연결
	if(!$connect) $connect=dbConn();

// 멤버 정보 구해오기;;; 멤버가 있을때
	$member=member_info();	
	if(!$member[no]) Error("로그인 하신 후 다시 하십시오");	
	
// 중복 시리얼 번호 검사	
	$p_book_sno = str_replace("ㅤ","",$p_book_sno);	
	$p_book_sno=trim($p_book_sno);
	if(isBlank($p_book_sno)) Error("시리얼번호를 입력하셔야 합니다","");
	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from TB_REG1 where BOOK_SNO='$p_book_sno'",$connect));
	if($check[0]>0) Error("이미 등록되어 있는 시리얼입니다","");	
	
// 중복 시리얼 번호 검사	
	$p_book_sno = str_replace("ㅤ","",$p_book_sno);	
	$p_book_sno=trim($p_book_sno);
	if(isBlank($p_book_sno)) Error("시리얼번호를 입력하셔야 합니다","");
	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from TB_REG2 where BOOK_SNO='$p_book_sno'",$connect));
	if($check[0]>0) Error("이미 등록되어 있는 시리얼입니다","");		
	
// 정품 시리얼 번호 검사	
	$p_book_sno = str_replace("ㅤ","",$p_book_sno);	
	$p_book_sno=trim($p_book_sno);
	if(isBlank($p_book_sno)) Error("시리얼번호를 입력하셔야 합니다","");
	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from TB_BOOK_SNO where BOOK_SNO='$p_book_sno'",$connect));
	if($check[0]<1) Error("잘못된 시리얼입니다","");	
	

// 수강반ID 검사	
	$p_class_id = str_replace("ㅤ","",$p_class_id);	
	$p_class_id=trim($p_class_id);
	if(isBlank($p_class_id)) Error("수강반ID를 입력하셔야 합니다","");
	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from TB_CLASS where CLASS_ID='$p_class_id'",$connect));
	if($check[0]<1) Error("등록되어 있는 않은 수강반ID 입니다","");

// 사용자 ID
	$user_id=$member[user_id];
	
// 각종 정보	
	$reg_ilsi=date("Y:m:d H:i:s");
	$remote_addr = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	$remote_host = $HTTP_SERVER_VARS['REMOTE_HOST'];
	echo($remote_host);

// 수강 정보 삽입
	mysql_query("insert into TB_REG2 (CLASS_ID, USER_ID, BOOK_SNO, REG_ILSI, IP, HOST) values ('$p_class_id','$user_id','$p_book_sno','$reg_ilsi', '$remote_addr','$remote_host' )");

// DB CLOSE	
	mysql_close($connect);
?>

<script>
	alert("시러얼 등록이 정상적으로 처리 되었습니다\n\n수강 신청이 되었습니다.");
	opener.window.history.go(0);
	window.close();
</script>