<?
  $_zb_url = "/bbs/";
  $_zb_path = "/home/hosting_users/academysoft/www/bbs/";
  include $_zb_path."outlogin.php";   

  // include Common Library
  include $_zb_path."../commonLib.php";	
  
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
  
  // DB ����
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // ��ȸ 
//  $sql = "SELECT SEQ, PLAN_ILSI"
//        ."  FROM TB_EXAM_SCH s, TB_EXAM e"
//        ."  WHERE '$p_seq' = s.SEQ"
//        ."    AND s.EXAM_SEQ     = e.SEQ"
//        ."    AND r.EXAM_SCH_SEQ = '$p_seq'";
//
//  $res =& $db->query($sql);
//  if (PEAR::isError($db)) {
//    die($db->getMessage());
//  }  
//  
//  $iRow=0;
//  if ($res->fetchInto($row)) 
//  {  	
//  	Error("���� ����� �����Ƿ� ������ �� �����ϴ�.");
//  } 
//     
//  if (PEAR::isError($db)) {
//    die($db->getMessage());
//  } 
  // ����
  $sth = $db->prepare("INSERT INTO TB_EXAM_SCH (CLASS_ID, EXAM_SEQ, PLAN_ILSI) values (?,?,?)");
  $data = array($_SESSION["ss_class_id"], $p_exam_seq, $p_plan_ilsi);
  $db->execute($sth, $data );  
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  // ����
  $sth = $db->prepare("UPDATE TB_EXAM_SCH SET PLAN_ILSI = ? WHERE SEQ = ?");
  $data = array($p_plan_ilsi, $p_seq);
  $db->execute($sth, $data );   

  // �����̷�Ʈ
  header("HTTP/1.1 301 Moved Permanently");
    header("Location: $HTTP_REFERER");
?>