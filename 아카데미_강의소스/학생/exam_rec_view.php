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
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/templates");
  if(!$tpl->loadTemplatefile("exam_rec_view.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB ����
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // ��ȣǮ��  
  $movie_seq = (int)call_decrypt($user_id,$p_movie_seq);
  $movie_sch_seq = (int)call_decrypt($user_id,$p_movie_sch_seq);

  // ��ȸ
//  $sql = "SELECT m.MOVIE_ID, m.TITLE, s.PLAN_ILSI, m.URL "
//        ."  FROM TB_MOVIE m, TB_MOVIE_SCH s              "
//        ." WHERE s.MOVIE_SEQ = m.SEQ                     "
//        ."   AND s.MOVIE_SEQ = $movie_seq                "
//        ."   AND s.CLASS_ID  = '$_SESSION[ss_class_id]'  ";   

	$sql = "SELECT e.EXAM_ID, e.EXAM_TITLE, s.PLAN_ILSI, r.EXAM_END , s.EXAM_SEQ, s.SEQ "
	  ."  FROM TB_EXAM e, TB_EXAM_SCH s                     "
	  ."  LEFT JOIN TB_EXAM_REC r ON s.SEQ = r.EXAM_SCH_SEQ "
	  ."   AND r.USER_ID   = '$user_id'                       "
	  ." WHERE s.EXAM_SEQ = e.SEQ              "
	  ."   AND s.CLASS_ID  = '$p_class_id'      "
	  ." ORDER BY  s.PLAN_ILSI                  ";
  
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // ����
  $iSeq=0;
  while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");
    
    $exam_seq = call_encrypt($user_id,$row[5]);
    $exam_sch_seq = call_encrypt($user_id,$row[6]);

    $tpl->setVariable("PLAN_ILSI"  , $row[1]); // ��ȹ�Ͻ�
    $tpl->setVariable("TITLE"      , $row[2]); // ��������
    $tpl->setVariable("JUMSU"      , $row[3]); // ����
    $tpl->setVariable("EXAM_END"   , $row[4]); // ����Ϸ���
    $tpl->setVariable("EXAM_TIME"  , $row[5]); // ����ð�
    $tpl->setVariable("EXAM_PASS"  , $row[6]); // �հ�����

	$tpl->setVariable("QST01"      , $row[1]); // ����1
	$tpl->setVariable("QST02"      , $row[1]); // ����2
	$tpl->setVariable("QST03"      , $row[1]); // ����3
	$tpl->setVariable("QST04"      , $row[1]); // ����4
	$tpl->setVariable("QST05"      , $row[1]); // ����5
	$tpl->setVariable("QST06"      , $row[1]); // ����6
	$tpl->setVariable("QST07"      , $row[1]); // ����7
	$tpl->setVariable("QST08"      , $row[1]); // ����8
	$tpl->setVariable("QST09"      , $row[1]); // ����9
	$tpl->setVariable("QST10"      , $row[1]); // ����10
	$tpl->setVariable("QST11"      , $row[1]); // ����11
	$tpl->setVariable("QST12"      , $row[1]); // ����12
	$tpl->setVariable("QST13"      , $row[1]); // ����13
	$tpl->setVariable("QST14"      , $row[1]); // ����14
	$tpl->setVariable("QST15"      , $row[1]); // ����15
	$tpl->setVariable("QST16"      , $row[1]); // ����16
	$tpl->setVariable("QST17"      , $row[1]); // ����17
	$tpl->setVariable("QST18"      , $row[1]); // ����18
	$tpl->setVariable("QST19"      , $row[1]); // ����19
	$tpl->setVariable("QST20"      , $row[1]); // ����20


    $tpl->parseCurrentBlock("row");


    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
  }
    // print the output
  $tpl->show();
	
?>