<table width="750" border="0" align="center" cellpadding="1" cellspacing="5">
<?      
	$_zb_url = "/bbs/";
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";   	
	include $_zb_path."../commonLib.php";
	
    include $_zb_path."../cb_header.php";
?>
</table>
<?
	// ȸ��
	if($dept_no == "dp01" || $p_exam_id == "E1") {
		$dept = 1;
		$p_exam_id = "E1";
	}
  else
	if($dept_no == "dp02" || $p_exam_id == "E2") {
		$dept = 2;
		$p_exam_id = "E2";
	}
  else
	if($dept_no == "dp03" || $p_exam_id == "E3") {
		$dept = 3;
		$p_exam_id = "E3";
	}
  else
	if($dept_no == "dp04" || $p_exam_id == "G1") {
		$dept = 4;
		$p_exam_id = "G1";
	}
  else
	if($dept_no == "dp05" || $p_exam_id == "G2") {
		$dept = 5;
		$p_exam_id = "G2";
	}
  else {
    $p_exam_id = "E1";
		$dept = 1;
  }

	$_zb_url = "/bbs/";
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";   

	// ���� �˻�
	$connect=dbConn();
	$member=member_info();
	if($member[level] > 9)
	{
	Error("���ѵ� ����Դϴ�.");
	}  
	// ����� ID
	$user_id=$member[user_id];

	// �ڱⰡ ������ �ݸ� �� �� �ֵ��� ����

	// call pear init & call
	call_pear_init();
	require_once("DB.php");
	require_once("HTML/Template/IT.php");

	// Template
	$tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/apps/exam/templates");
	if(!$tpl->loadTemplatefile("exam_rec_by_no.tpl.htm", true, true)) Error("loadTemplatefile");

	// DB ����
	$db =& DB::connect(call_pear_db_dsn());
	if (PEAR::isError($db)) {
	die($db->getMessage());
	}

	// ��ȸ
	$sql = "SELECT r.EXAM_PASS, z.name, r.TOTAL_SCORE, r.USER_ID "
		      ."FROM TB_EXAM_REC r, TB_EXAM_SCH s, TB_EXAM e, zetyx_member_table z "
		     ."WHERE e.SEQ = s.EXAM_SEQ "
		       ."AND s.CLASS_ID  = '$p_class_id' "
		       ."AND e.EXAM_ID = '$p_exam_id' "
           ."AND s.SEQ = r.EXAM_SCH_SEQ "
		       ."AND r.USER_ID = z.USER_ID ";

	$res = $db->query($sql);
	if (PEAR::isError($db)) {
	die($db->getMessage());
	}

	// ����
	$ress = mysql_query($sql);  // ���ڵ� üũ

	$iSeq=0;
	while ($res->fetchInto($row)) {
		if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");

		$tpl->setVariable("SEQ"        , ++$iSeq);  // NO
    $userid = $row[3];
		$tpl->setVariable("USER_NAME" , $row[1]);   // �л��̸�
		$tpl->setVariable("EXAM_JUMSU"  ,$row[2]);      // ����
		$tpl->setVariable("EXAM_PASS"   , $row[0]);     // �հ�����
		$tpl->setVariable("EXAM_NO"   , $dept);         // ȸ��
		$tpl->setVariable("CLASS_ID"   , $p_class_id);  // �й�

		$tpl->parseCurrentBlock("row");

		// parse outter block
		if (!$tpl->parse("row")) Error("parseCurrentBlock");
	}
	// print the output
	$tpl->show();

	$res = $db->query($sql);
	if (PEAR::isError($db)) {
	die($db->getMessage());
	}
	
	
?>
