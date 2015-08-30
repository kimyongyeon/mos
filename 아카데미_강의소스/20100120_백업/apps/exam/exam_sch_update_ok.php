<?
  $_zb_url = "/bbs/";
  $_zb_path = "/home/hosting_users/academysoft/www/bbs/";
  include $_zb_path."outlogin.php";   

  // include Common Library
  include $_zb_path."../commonLib.php";	
  
  // 권한 검사
  $connect=dbConn();
  $member=member_info();
  if($member[level] > 5)
  {
  	Error("제한된 기능입니다.");
  }  
  // 사용자 ID
	$user_id=$member[user_id];
  
  // 자기가 관리한 반만 볼 수 있도록 제한
  
  // call pear init & call
  call_pear_init();
  require_once("DB.php");  
  
  // DB 접속
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // 조회 
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
//  	Error("수강 기록이 있으므로 삭제할 수 없습니다.");
//  } 
//     
//  if (PEAR::isError($db)) {
//    die($db->getMessage());
//  } 
  // 삽입
  $sth = $db->prepare("INSERT INTO TB_EXAM_SCH (CLASS_ID, EXAM_SEQ, PLAN_ILSI) values (?,?,?)");
  $data = array($_SESSION["ss_class_id"], $p_exam_seq, $p_plan_ilsi);
  $db->execute($sth, $data );  
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  // 수정
  $sth = $db->prepare("UPDATE TB_EXAM_SCH SET PLAN_ILSI = ? WHERE SEQ = ?");
  $data = array($p_plan_ilsi, $p_seq);
  $db->execute($sth, $data );   

  // 리다이렉트
  header("HTTP/1.1 301 Moved Permanently");
    header("Location: $HTTP_REFERER");
?>