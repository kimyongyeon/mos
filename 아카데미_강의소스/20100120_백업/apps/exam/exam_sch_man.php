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
  
  // ���� �˻�
  $connect=dbConn();
  $member=member_info();
  if($member[level] > 5)
  {
  	Error("���ѵ� ����Դϴ�.");
  }  
  
  // �ڱⰡ ������ �ݸ� �� �� �ֵ��� ����
  
  // call pear init & call
  call_pear_init();
  require_once("DB.php");
  require_once("HTML/Template/IT.php");
  
  // Template
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/apps/exam/templates");
  if(!$tpl->loadTemplatefile("exam_sch_man.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB ����
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // ��ȸ
//  $sql = "SELECT e.EXAM_TITLE, s.PLAN_ILSI, s.SEQ, e.SEQ "
//		."FROM TB_EXAM e "
//		."LEFT JOIN TB_EXAM_SCH s ON s.EXAM_SEQ = e.SEQ "
//		."AND s.CLASS_ID = '$p_class_id' ";

$sql =  " SELECT e.EXAM_TITLE, s.PLAN_ILSI, s.SEQ, e.SEQ, e.EXAM_ID "
       ."   FROM TB_EXAM e, TB_EXAM_SCH s, TB_EXAM_REC r "
       ."  WHERE s.CLASS_ID = '$p_class_id' "
       ."    AND s.SEQ = r.EXAM_SCH_SEQ  "
       ."    AND e.SEQ = s.EXAM_SEQ "
       ."  group by e.EXAM_ID ";

  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }


  // ����
  $iSeq=0;
  while ($res->fetchInto($row)) {
	if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");
	$tpl->setVariable("SEQ"            , ++$iSeq); // ������ �ѹ�
  $exam_id = $row[4];
	$tpl->setVariable("EXAM_TITLE"	   , "<a href='/index.php?html=apps/exam/exam_rec_by_no&p_exam_id=$exam_id&p_class_id=$p_class_id'>".$row[0]); // ���� ����
	$tpl->setVariable("PLAN_ILSI"	   , $row[1]); // ���� ����
//        $tpl->setVariable("SCRIPT_UPDATE","/apps/exam/exam_sch_update_ok.php?p_seq=$row[2]&p_exam_seq=$row[3]"); // ����
	$tpl->setVariable("SCRIPT_DELETE","/apps/exam/exam_sch_delete_ok.php?p_seq=$row[2]"); // ����
	$tpl->setVariable("P_SEQ"            , $row[2]);  
	$tpl->setVariable("P_EXAM_SEQ"       , $row[3]); 
	$tpl->parseCurrentBlock("row");
	
	// parse outter block
	if (!$tpl->parse("row")) Error("parseCurrentBlock");
  }
  // print the output
  $tpl->show();

?>
