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
  if($member[level] > 9)
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
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/apps/exam/templates");
  if(!$tpl->loadTemplatefile("exam_rec_view.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB ����
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

  // ��ȸ
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

  // ����
  $iSeq=0;
  while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");

    $tpl->setVariable("PLAN_ILSI"  , $row[0]); // ��ȹ�Ͻ�
    $tpl->setVariable("NAME"       , $name);     // �̸�

    if ($p_exam_id == "E1") {
      $examid = "���ǰ�� 1ȸ";
    $tpl->setVariable("EXAM_ID"    , $examid);     // �̸�
    }
    else
    if ($p_exam_id == "E2") {
      $examid = "������� 1ȸ";
    $tpl->setVariable("EXAM_ID"    , $examid);     // �̸�
    }
    
    $tpl->setVariable("TITLE"      , $bookname); // ��������
    $tpl->setVariable("JUMSU"      , $totalscore); // ����
    $tpl->setVariable("EXAM_END"   , $row[1]); // ����Ϸ���
    $tpl->setVariable("EXAM_TIME"  , $row[2]); // ����ð�
    $tpl->setVariable("EXAM_PASS"  , $row[3]); // �հ�����
    $tpl->setVariable("QST01"      , $row[4]); // ����1
    $tpl->setVariable("QST02"      , $row[5]); // ����2
    $tpl->setVariable("QST03"      , $row[6]); // ����3
    $tpl->setVariable("QST04"      , $row[7]); // ����4
    $tpl->setVariable("QST05"      , $row[8]); // ����5
    $tpl->setVariable("QST06"      , $row[9]); // ����6
    $tpl->setVariable("QST07"      , $row[10]); // ����7
    $tpl->setVariable("QST08"      , $row[11]); // ����8
    $tpl->setVariable("QST09"      , $row[12]); // ����9
    $tpl->setVariable("QST10"      , $row[13]); // ����10
    $tpl->setVariable("QST11"      , $row[14]); // ����11
    $tpl->setVariable("QST12"      , $row[15]); // ����12
    $tpl->setVariable("QST13"      , $row[16]); // ����13
    $tpl->setVariable("QST14"      , $row[17]); // ����14
    $tpl->setVariable("QST15"      , $row[18]); // ����15
    $tpl->setVariable("QST16"      , $row[19]); // ����16
    $tpl->setVariable("QST17"      , $row[20]); // ����17
    $tpl->setVariable("QST18"      , $row[21]); // ����18
    $tpl->setVariable("QST19"      , $row[22]); // ����19
    $tpl->setVariable("QST20"      , $row[23]); // ����20

    $tpl->parseCurrentBlock("row");
    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
  }
    // print the output
  $tpl->show();
	
?>