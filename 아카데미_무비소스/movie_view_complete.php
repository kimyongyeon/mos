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
  /*
  $connect=dbConn();
  $member=member_info();
  if($member[level] > 9)
  {
  	Error("제한된 기능입니다.");
  } 
  */ 
  // 사용자 ID
	// $user_id=$member[user_id];
	$user_id = $p_user_id;
  
  // 자기가 관리한 반만 볼 수 있도록 제한
  
  // call pear init & call
  call_pear_init();
  require_once("DB.php");
  require_once("HTML/Template/IT.php");
  
  // Template
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/templates");
  if(!$tpl->loadTemplatefile("movie_view_complete.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB 접속
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // 암호풀기    
  $movie_sch_seq = (int)call_decrypt($user_id,$p_movie_sch_seq); 
  
  // 조회
  $sql = "SELECT r.VIEW_START, r.VIEW_END, (now()-r.VIEW_START)/60, m.TIME, m.TITLE, s.PLAN_ILSI "
        ."  FROM TB_MOVIE_REC r, TB_MOVIE_SCH s, TB_MOVIE m "
        ." WHERE r.MOVIE_SCH_SEQ = s.SEQ          "
        ."   AND s.MOVIE_SEQ     = m.SEQ          "
        ."   AND r.MOVIE_SCH_SEQ = $movie_sch_seq "
        ."   AND r.USER_ID       = '$p_user_id'   ";
  //echo($sql);     
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }  
  
  // 편집
  $iSeq=0;
  while ($res->fetchInto($row)) {
  	$iSeq++;
  	$view_start = $row[0];
  	$view_end   = $row[1];
  	$view_time  = $row[2];
  	$time       = $row[3];
  	$title      = $row[4];
  	$plan_ilsi  = $row[5];
  }
    
  // 검사
  if ($iSeq != 1) Error("기록할 동영상 정보를 찾지 못했습니다.");
  
  // 동영상 시간보다 짧게 봄
  if ($view_time < $time) 
  {  	  
  		Error("동영상 시간보다 짧게 보았습니다<br>수강시간( $view_time 분) < 동영상 시간($time 분)");
  } 
    
	// 갱신  
  $sth = $db->prepare("UPDATE TB_MOVIE_REC SET VIEW_END = ? WHERE MOVIE_SCH_SEQ = ? AND USER_ID = ? AND IP = ?");
  $view_end = date("Y:m:d H:i:s");
  $data = array($view_end, $movie_sch_seq, $user_id, $HTTP_SERVER_VARS["REMOTE_ADDR"]);
  $db->execute($sth, $data );  
  
  if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");            
  $tpl->setVariable("TITLE"     , $title);
  $tpl->setVariable("PLAN_ILSI" , $plan_ilsi);
  $tpl->setVariable("VIEW_START", $view_start);
  $tpl->setVariable("VIEW_END"  , $view_end);
  $tpl->setVariable("MSG", "위와 같이 강의를 수강하였습니다.");
  $tpl->parseCurrentBlock("row");    
  // parse outter block
  if (!$tpl->parse("row")) Error("parseCurrentBlock");
      
  // print the output
  $tpl->show();
?>