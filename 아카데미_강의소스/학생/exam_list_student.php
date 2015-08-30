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
  $_zb_url = "/bbs/";
  $_zb_path = "/home/hosting_users/academysoft/www/bbs/";
  include $_zb_path."outlogin.php";   
  
  // 권한 검사
  $connect=dbConn();
  $member=member_info();
  if($member[level] > 9)
  {
  	Error("제한된 기능입니다.");
  }  
  // 사용자 ID
	$user_id=$member[user_id];
  
  // 자기가 관리한 반만 볼 수 있도록 제한
  
  // call pear init & call
  call_pear_init();
  require_once("DB.php");
  require_once("HTML/Template/IT.php");
  
  // Template
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/templates");
  if(!$tpl->loadTemplatefile("exam_list_student.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB 접속
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // 조회
//  $sql = "SELECT m.MOVIE_ID, m.TITLE, s.PLAN_ILSI, r.VIEW_START, r.VIEW_END , s.MOVIE_SEQ, s.SEQ "
//        ."  FROM TB_MOVIE m, TB_MOVIE_SCH s                     "
//        ."  LEFT JOIN TB_MOVIE_REC r ON s.SEQ = r.MOVIE_SCH_SEQ "
//        ."   AND r.USER_ID   = '$user_id'                       "
//        ." WHERE s.MOVIE_SEQ = m.SEQ              "
//        ."   AND s.CLASS_ID  = '$p_class_id'      "
//        ." ORDER BY  s.PLAN_ILSI                  ";

$sql = "SELECT e.EXAM_ID, e.EXAM_TITLE, s.PLAN_ILSI, r.EXAM_END , s.EXAM_SEQ, s.SEQ "
      ."  FROM TB_EXAM e, TB_EXAM_SCH s                     "
	  ."  LEFT JOIN TB_EXAM_REC r ON s.SEQ = r.EXAM_SCH_SEQ "
	  ."   AND r.USER_ID   = '$user_id'                       "
	  ." WHERE s.EXAM_SEQ = e.SEQ              "
	  ."   AND s.CLASS_ID  = '$p_class_id'      "
	  ." ORDER BY  s.PLAN_ILSI                  ";

  $res = $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // 편집
  $iSeq=0;
  while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");
    
    $exam_seq = call_encrypt($user_id,$row[5]);
    $exam_sch_seq = call_encrypt($user_id,$row[6]);

    $tpl->setVariable("NAME"       , $row[0]); // 이름
    $tpl->setVariable("PLAN_ILSI"  , $row[1]); // 계획일시
    $tpl->setVariable("TITLE"      , $row[2]); // 시험제목
    $tpl->setVariable("JUMSU"      , $row[3]); // 점수
    $tpl->setVariable("EXAM_END"   , $row[4]); // 시험완료일
    $tpl->setVariable("EXAM_TIME"  , $row[5]); // 시험시간
    $tpl->setVariable("EXAM_PASS"  , $row[6]); // 합격유무
    $tpl->parseCurrentBlock("row");


    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
  }
    // print the output
  $tpl->show();
?>