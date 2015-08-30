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
  if(!$tpl->loadTemplatefile("exam_rec_view.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB 접속
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  $sql = "SELECT name FROM zetyx_member_table z WHERE z.user_id = '$user_id'";
  
  $res =& $db->query($sql);
    if (PEAR::isError($db)) {
      die($db->getMessage());
    }
  
  while ($res->fetchInto($row)) {
    $name = $row[0];
  }

  $sql = " SELECT b.BOOK_NAME FROM TB_EXAM e, TB_BOOK b, TB_EXAM_SCH s 
            WHERE e.BOOK_ID = b.BOOK_ID 
              and s.EXAM_SEQ = e.SEQ 
         group by b.BOOK_NAME";

  $res =& $db->query($sql);

    if (PEAR::isError($db)) {
      die($db->getMessage());
    }
  
  while ($res->fetchInto($row)) {
    $bookname = $row[0];
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
  $sql = "SELECT r.REG_ILSI, r.EXAM_END, r.ELAPSED_TIME, r.EXAM_PASS, "
		."r.QST01, r.QST02, r.QST03, r.QST04, r.QST05, r.QST06, r.QST07, r.QST08, r.QST09, r.QST10, "
		."r.QST11, r.QST12, r.QST13, r.QST14, r.QST15, r.QST16, r.QST17, r.QST18, r.QST19, r.QST20 "
		."      FROM TB_EXAM_REC r, TB_EXAM_SCH s, TB_EXAM e   "
		."     WHERE r.USER_ID   = '$user_id'      "
		."       AND e.SEQ       = s.EXAM_SEQ "
    ."       AND s.SEQ       = r.EXAM_SCH_SEQ  "
    ."       AND e.EXAM_ID   = '$p_exam_id '  "  
    ."  group by r.USER_ID ";

  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // 편집
  $iSeq=0;
  while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");

    $tpl->setVariable("PLAN_ILSI"  , $row[0]); // 계획일시
    $tpl->setVariable("NAME"       , $name);     // 이름

    if ($p_exam_id == "E1") {
      $examid = "모의고사 1회";
    $tpl->setVariable("EXAM_ID"    , $examid);     // 이름
    }
    else
    if ($p_exam_id == "E2") {
      $examid = "최종고사 1회";
    $tpl->setVariable("EXAM_ID"    , $examid);     // 이름
    }
    
    $tpl->setVariable("TITLE"      , $bookname); // 시험제목
    $tpl->setVariable("JUMSU"      , $totalscore); // 점수
    $tpl->setVariable("EXAM_END"   , $row[1]); // 시험완료일
    $tpl->setVariable("EXAM_TIME"  , $row[2]); // 시험시간
    $tpl->setVariable("EXAM_PASS"  , $row[3]); // 합격유무
    $tpl->setVariable("QST01"      , $row[4]); // 정답1
    $tpl->setVariable("QST02"      , $row[5]); // 정답2
    $tpl->setVariable("QST03"      , $row[6]); // 정답3
    $tpl->setVariable("QST04"      , $row[7]); // 정답4
    $tpl->setVariable("QST05"      , $row[8]); // 정답5
    $tpl->setVariable("QST06"      , $row[9]); // 정답6
    $tpl->setVariable("QST07"      , $row[10]); // 정답7
    $tpl->setVariable("QST08"      , $row[11]); // 정답8
    $tpl->setVariable("QST09"      , $row[12]); // 정답9
    $tpl->setVariable("QST10"      , $row[13]); // 정답10
    $tpl->setVariable("QST11"      , $row[14]); // 정답11
    $tpl->setVariable("QST12"      , $row[15]); // 정답12
    $tpl->setVariable("QST13"      , $row[16]); // 정답13
    $tpl->setVariable("QST14"      , $row[17]); // 정답14
    $tpl->setVariable("QST15"      , $row[18]); // 정답15
    $tpl->setVariable("QST16"      , $row[19]); // 정답16
    $tpl->setVariable("QST17"      , $row[20]); // 정답17
    $tpl->setVariable("QST18"      , $row[21]); // 정답18
    $tpl->setVariable("QST19"      , $row[22]); // 정답19
    $tpl->setVariable("QST20"      , $row[23]); // 정답20

    $tpl->parseCurrentBlock("row");
    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
  }
    // print the output
  $tpl->show();
	
?>