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
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/apps/exam/templates");
  if(!$tpl->loadTemplatefile("exam_list_student.tpl.htm", true, true)) Error("loadTemplatefile");

  // DB 접속
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  $sql = " SELECT TOTAL_SCORE FROM TB_EXAM_REC WHERE USER_ID = '$user_id' ";
  
  $res =& $db->query($sql);
    if (PEAR::isError($db)) {
      die($db->getMessage());
    }
  
  while ($res->fetchInto($row)) {
    $totalscore = $row[0];
  }

  // 조회
  $sql = "SELECT r.REG_ILSI, b.BOOK_NAME, r.EXAM_END, r.ELAPSED_TIME, r.EXAM_PASS, (SELECT name FROM zetyx_member_table z WHERE z.user_id = '$user_id'), e.EXAM_ID "
		." FROM TB_EXAM e, TB_EXAM_SCH s, TB_EXAM_REC r, TB_BOOK b "
		." WHERE s.SEQ = r.EXAM_SCH_SEQ  "
		." AND e.SEQ = s.EXAM_SEQ "
		." AND r.USER_ID   = '$user_id'  "
		." AND s.CLASS_ID  = '$p_class_id' "
		." AND e.BOOK_ID = b.BOOK_ID ";

  $res = $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  $ress = mysql_query($sql);  // 레코드 체크

  if ($ress != 0)
  {
	  // 편집
	  while ($res->fetchInto($row)) {
		if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");

		$tpl->setVariable("NAME"       , $row[5]); // 이름
		$tpl->setVariable("PLAN_ILSI"  , $row[0]); // 계획일시
    $exam_id = $row[6];
		$tpl->setVariable("TITLE"      , "<a href='/index.php?html=apps/exam/exam_rec_view&p_exam_id=$exam_id'>".$row[1]); // 시험제목
		$tpl->setVariable("JUMSU"      , $totalscore); // 점수
		$tpl->setVariable("EXAM_END"   , $row[2]); // 시험완료일
		$tpl->setVariable("EXAM_TIME"  , $row[3]); // 시험시간
		$tpl->setVariable("EXAM_PASS"  , $row[4]); // 합격유무
		$tpl->parseCurrentBlock("row");

		// parse outter block
		if (!$tpl->parse("row")) Error("parseCurrentBlock");
	  }
		// print the output
	  $tpl->show();
  }
?>
