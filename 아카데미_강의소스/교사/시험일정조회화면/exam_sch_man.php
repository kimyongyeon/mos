<table width="750" border="0" align="center" cellpadding="1" cellspacing="5">
<?      
	$_zb_url = "/bbs/";
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";   	
	include $_zb_path."../commonLib.php";	
	
  include "cb_header.php";
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
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/templates");
  if(!$tpl->loadTemplatefile("exam_sch_man.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB ����
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // ��ȸ
  $sql = "SELECT e.EXAM_ID, e.EXAM_TITLE, s.PLAN_ILSI, s.SEQ, e.SEQ "
      ."  FROM TB_EXAM e"
      ."  LEFT JOIN TB_EXAM_SCH s ON s.EXAM_SEQ = e.SEQ"
      ."   AND s.CLASS_ID = '$p_class_id'";
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // ����
  $iSeq=0;
  while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");
    $tpl->setVariable("SEQ"            , ++$iSeq); // ������ �ѹ�
    $tpl->setVariable("EXAM_ID"        , $row[0]); // ����ID
    $tpl->setVariable("EXAM_TITLE"	   , $row[1]); // ���� ����
    $tpl->setVariable("PLAN_ILSI"	   , $row[2]); // ���� ����
	$tpl->setVariable("EXAM_NO"		   , $row[3]); // ���� ȸ��
    $tpl->setVariable("SCRIPT_UPDATE","/movie_sch_update.php?p_seq=$row[3]");    // ����
    $tpl->setVariable("SCRIPT_DELETE","/movie_sch_delete_ok.php?p_seq=$row[3]"); // ����
    $tpl->parseCurrentBlock("row");
    
    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
  }

  // print the output
  $tpl->show();
	
?>