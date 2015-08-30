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
  if(!$tpl->loadTemplatefile("movie_list_student.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB 접속
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // 조회
  $sql = "SELECT m.MOVIE_ID, m.TITLE, s.PLAN_ILSI, r.VIEW_START, r.VIEW_END , s.MOVIE_SEQ, s.SEQ "
        ."  FROM TB_MOVIE m, TB_MOVIE_SCH s                     "
        ."  LEFT JOIN TB_MOVIE_REC r ON s.SEQ = r.MOVIE_SCH_SEQ "
        ."   AND r.USER_ID   = '$user_id'                       "
        ." WHERE s.MOVIE_SEQ = m.SEQ              "
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
    
    $movie_seq = call_encrypt($user_id,$row[5]);
    $movie_sch_seq = call_encrypt($user_id,$row[6]);
    if (!$row[3]) $row[3] = "<a href='/index.php?html=movie_view&p_movie_seq=$movie_seq&p_movie_sch_seq=$movie_sch_seq'>강의 보기 시작";
    if (!$row[4]) $row[4] = "<a href='/index.php?html=movie_view&p_movie_seq=$movie_seq&p_movie_sch_seq=$movie_sch_seq'>강의 끝까지 보기";
    $tpl->setVariable("SEQ"        , ++$iSeq);
    $tpl->setVariable("TITLE"      , "<a href='/index.php?html=movie_view&p_movie_seq=$movie_seq&p_movie_sch_seq=$movie_sch_seq'>".$row[1]);
    $tpl->setVariable("PLAN_ILSI"  , $row[2]);
    $tpl->setVariable("VIEW_START" , $row[3]);
    $tpl->setVariable("VIEW_END"   , $row[4]);
    $tpl->parseCurrentBlock("row");
    
    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
  }
    // print the output
  $tpl->show();
?>