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
  // ����� ID
	$user_id=$member[user_id];
	
	
  // �ڱⰡ ������ �ݸ� �� �� �ֵ��� ����
  
  // call pear init & call
  call_pear_init();
  require_once("DB.php");
  require_once("HTML/Template/IT.php");
  
  // Template
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/templates");
  if(!$tpl->loadTemplatefile("member_list.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB ����
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // ��ȸ
  $sql = "SELECT t.name, r.USER_ID, t.icq, t.handphone, r.REG_ILSI "
        ."  FROM TB_REG1 r, zetyx_member_table t "
        ." WHERE r.USER_ID = t.user_id "
        ."   AND r.CLASS_ID = '$p_class_id'"
        ." ORDER by t.icq ";
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // ����
  $iSeq=0;
  while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");    
    if (!$row[2]) $row[2] = "���Է�";
    if (!$row[3]) $row[3] = "���Է�";
    if (!$row[4]) $row[4] = "���Է�";
    $tpl->setVariable("SEQ", ++$iSeq);
    $tpl->setVariable("NAME", $row[0]);
    $tpl->setVariable("USER_ID", $row[1]);
    $tpl->setVariable("HAKBUN", $row[2]);
    $tpl->setVariable("HANDPHONE", $row[3]);
    $tpl->setVariable("REG_ILSI", $row[4]);
    $tpl->parseCurrentBlock("row");
    
    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
  }

  // print the output
  $tpl->show();
  
	
?>