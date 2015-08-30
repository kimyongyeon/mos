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
    $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/apps/exam/templates");
    if(!$tpl->loadTemplatefile("exam_rec_by_student.tpl.htm", true, true)) Error("loadTemplatefile");

    // DB 접속
    $db =& DB::connect(call_pear_db_dsn());
    if (PEAR::isError($db)) {
        die($db->getMessage());
    }

    // 전체 횟수 구하기
    $sql = "SELECT r.USER_ID, count(e.BOOK_ID) "
        ."  FROM   TB_EXAM_SCH s, TB_EXAM e, TB_EXAM_REC r "
        ." WHERE   s.EXAM_SEQ = e.SEQ "
        ."   AND   r.EXAM_SCH_SEQ = s.SEQ "
      ."GROUP BY   USER_ID ";

    $res = $db->query($sql);
    if (PEAR::isError($db)) {
        die($db->getMessage());
    }

    while ($res->fetchInto($row)) {
        $t_userid[] = $row[0]; // 사용자 아뒤 저장
        $t_cnt[]    = $row[1]; // 횟수
        $tCount++;
    }

    // 합격 횟수 구하기
    $sql = "SELECT r.USER_ID, count(e.BOOK_ID) "
          ."  FROM TB_EXAM_SCH s, TB_EXAM e, TB_EXAM_REC r "
          ." WHERE s.EXAM_SEQ = e.SEQ "
          ."   AND r.EXAM_SCH_SEQ = s.SEQ "
          ."   AND r.EXAM_PASS = '합격' "
        ."GROUP BY USER_ID ";

    $res = $db->query($sql);
    if (PEAR::isError($db)) {
        die($db->getMessage());
    }

    while ($res->fetchInto($row)) {
        $p_userid[] = $row[0]; // 사용자 아뒤 저장
        $p_cnt[]    = $row[1]; // 횟수
        $pCount++;
    }

    // 조회
    $sql = "SELECT r.EXAM_PASS, z.name, r.USER_ID "
            ."FROM TB_EXAM_REC r, TB_EXAM_SCH s, TB_EXAM e, zetyx_member_table z "
           ."WHERE e.SEQ = s.EXAM_SEQ "
             ."AND s.SEQ = r.EXAM_SCH_SEQ "
             ."AND s.CLASS_ID  = '$p_class_id' "
             ."AND r.USER_ID = z.USER_ID ";

    $res = $db->query($sql);
    if (PEAR::isError($db)) {
        die($db->getMessage());
    }

    // 편집
    $iSeq=0;
    while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");

    $tpl->setVariable("SEQ"        , ++$iSeq); // NO
    $tpl->setVariable("USER_NAME" , $row[1]);  // 이름

    for ($i=0; $i<$tCount; $i++) {
        if ($t_userid[$i] == $row[2]) {
            $tpl->setVariable("EXAM_NO"   , $t_cnt[$i]);  // 총횟수
        }
        else {
            $tpl->setVariable("EXAM_NO"   , 0);           // 총횟수
        }
    }

    for ($i=0; $i<$pCount; $i++) {
      if ($p_userid[$i] == $row[2]) {
        $tpl->setVariable("PASS_NO"   , $p_cnt[$i]);  // 합격횟수
      }
      else {
        $tpl->setVariable("PASS_NO"   , 0);           // 합격횟수
      }
    }

    //    for ($i=0; $i<$tCount; $i++)
    //    {
    //      $p_ave = $t_userid[0][$i] / $p_userid[0][$i];
    //      if ($p_ave == 0)
    //      {
    //        $tpl->setVariable("AVE_PASS"   , 0);
    //      }
    //      else
    //      {
    //        $tpl->setVariable("AVE_PASS"   , $t_userid[0][$i] / $p_userid[0][$i]); // 합격평균
    //      }
    //    }

    $tpl->parseCurrentBlock("row");

    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
    }
    // print the output
    $tpl->show();
?>