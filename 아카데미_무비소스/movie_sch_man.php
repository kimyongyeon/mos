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
  
  // 권한 검사
  $connect=dbConn();
  $member=member_info();
  if($member[level] > 5)
  {
  	Error("제한된 기능입니다.");
  }  
  
  // 자기가 관리한 반만 볼 수 있도록 제한
  
  // call pear init & call
  call_pear_init();
  require_once("DB.php");
  require_once("HTML/Template/IT.php");
  
  // Template
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/templates");
  if(!$tpl->loadTemplatefile("movie_sch_man.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB 접속
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // 조회
  $sql = "SELECT m.MOVIE_ID, m.TITLE, s.PLAN_ILSI, s.SEQ, m.SEQ "
      ."  FROM TB_MOVIE m"
      ."  LEFT JOIN TB_MOVIE_SCH s ON s.MOVIE_SEQ = m.SEQ"
      ."   AND s.CLASS_ID = '$p_class_id'";
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // 편집
  $iSeq=0;
  while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");
    //if (!$row[2]) $row[2] = "미입력";
    $tpl->setVariable("SEQ", ++$iSeq);
    $tpl->setVariable("MOVIE_ID", $row[0]);
    $tpl->setVariable("TITLE", $row[1]);
    $tpl->setVariable("PLAN_ILSI", $row[2]);
    //$tpl->setVariable("SCRIPT_UPDATE","/movie_sch_update.php?p_seq=$row[3]");    
    $tpl->setVariable("SCRIPT_DELETE","/movie_sch_delete_ok.php?p_seq=$row[3]");
    $tpl->setVariable("P_SEQ",$row[3]);
    $tpl->setVariable("P_MOVIE_SEQ", $row[4]);
    $tpl->parseCurrentBlock("row");
    
    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
  }

  // print the output
  $tpl->show();
	
?>