<?
	$_zb_url = "/bbs/";
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";   

	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("���������� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�.");
	if(!eregi("serial_reg_02.php",$HTTP_REFERER)) Error("���������� �ۼ��Ͽ� �ֽñ� �ٶ��ϴ�","");
	if(getenv("REQUEST_METHOD") == 'GET' ) Error("���������� ���� ���ñ� �ٶ��ϴ�","");

// DB ����
	if(!$connect) $connect=dbConn();

// ��� ���� ���ؿ���;;; ����� ������
	$member=member_info();	
	if(!$member[no]) Error("�α��� �Ͻ� �� �ٽ� �Ͻʽÿ�");	
	
// �ߺ� �ø��� ��ȣ �˻�	
	$p_book_sno = str_replace("��","",$p_book_sno);	
	$p_book_sno=trim($p_book_sno);
	if(isBlank($p_book_sno)) Error("�ø����ȣ�� �Է��ϼž� �մϴ�","");
	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from TB_REG1 where BOOK_SNO='$p_book_sno'",$connect));
	if($check[0]>0) Error("�̹� ��ϵǾ� �ִ� �ø����Դϴ�","");	
	
// �ߺ� �ø��� ��ȣ �˻�	
	$p_book_sno = str_replace("��","",$p_book_sno);	
	$p_book_sno=trim($p_book_sno);
	if(isBlank($p_book_sno)) Error("�ø����ȣ�� �Է��ϼž� �մϴ�","");
	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from TB_REG2 where BOOK_SNO='$p_book_sno'",$connect));
	if($check[0]>0) Error("�̹� ��ϵǾ� �ִ� �ø����Դϴ�","");		
	
// ��ǰ �ø��� ��ȣ �˻�	
	$p_book_sno = str_replace("��","",$p_book_sno);	
	$p_book_sno=trim($p_book_sno);
	if(isBlank($p_book_sno)) Error("�ø����ȣ�� �Է��ϼž� �մϴ�","");
	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from TB_BOOK_SNO where BOOK_SNO='$p_book_sno'",$connect));
	if($check[0]<1) Error("�߸��� �ø����Դϴ�","");	
	

// ������ID �˻�	
	$p_class_id = str_replace("��","",$p_class_id);	
	$p_class_id=trim($p_class_id);
	if(isBlank($p_class_id)) Error("������ID�� �Է��ϼž� �մϴ�","");
	unset($check);
	$check=mysql_fetch_array(mysql_query("select count(*) from TB_CLASS where CLASS_ID='$p_class_id'",$connect));
	if($check[0]<1) Error("��ϵǾ� �ִ� ���� ������ID �Դϴ�","");

// ����� ID
	$user_id=$member[user_id];
	
// ���� ����	
	$reg_ilsi=date("Y:m:d H:i:s");
	$remote_addr = $HTTP_SERVER_VARS['REMOTE_ADDR'];
	$remote_host = $HTTP_SERVER_VARS['REMOTE_HOST'];
	echo($remote_host);

// ���� ���� ����
	mysql_query("insert into TB_REG2 (CLASS_ID, USER_ID, BOOK_SNO, REG_ILSI, IP, HOST) values ('$p_class_id','$user_id','$p_book_sno','$reg_ilsi', '$remote_addr','$remote_host' )");

// DB CLOSE	
	mysql_close($connect);
?>

<script>
	alert("�÷��� ����� ���������� ó�� �Ǿ����ϴ�\n\n���� ��û�� �Ǿ����ϴ�.");
	opener.window.history.go(0);
	window.close();
</script>