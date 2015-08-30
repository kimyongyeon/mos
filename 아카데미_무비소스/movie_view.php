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
  if(!$tpl->loadTemplatefile("movie_view.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB 접속
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }

  // 암호풀기  
  $movie_seq = (int)call_decrypt($user_id,$p_movie_seq);
  $movie_sch_seq = (int)call_decrypt($user_id,$p_movie_sch_seq);

  // 조회
  $sql = "SELECT m.MOVIE_ID, m.TITLE, s.PLAN_ILSI, m.URL "
        ."  FROM TB_MOVIE m, TB_MOVIE_SCH s              "
        ." WHERE s.MOVIE_SEQ = m.SEQ                     "
        ."   AND s.MOVIE_SEQ = $movie_seq                "
        ."   AND s.CLASS_ID  = '$_SESSION[ss_class_id]'  ";        
  
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // 편집
  $iSeq=0;
  while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");            
    $tpl->setVariable("TITLE"    , $row[1]);
    $tpl->setVariable("PLAN_ILSI", $row[2]);
    $tpl->parseCurrentBlock("row");    
    // parse outter block
    if (!$tpl->parse("row")) Error("parseCurrentBlock");
    
    // 2007.09.28 : SCS
    if (strstr($row[3],".swf"))
    	$tpl->setVariable("EMBED_TAG", 
    		"<script type='text/javascript'>".chr(13).
    		"//<![CDATA[".chr(13).
    		"swf(800,655,'$row[3]','Player');".chr(13).
    		"//]]>".chr(13).
    		"</script>".chr(13).
    		"<INPUT type='image' src='/images/movie_play.gif' NAME='BtnPlay' VALUE='Play' OnClick='Player.play()'>".chr(13).
    		"<INPUT type='image' src='/images/movie_pause.gif' NAME='BtnPlay' VALUE='Play' OnClick='Player.stop()'>".chr(13).
    		"<INPUT type='image' src='/images/movie_rewind.gif' NAME='BtnStop' VALUE='Play' OnClick='Player.rewind()'>");
    else 
    	$tpl->setVariable("EMBED_TAG", 
    		"<embed src='$row[3]'>".chr(13).
    		"<INPUT type='image' src='/images/movie_play.gif' NAME='BtnPlay' VALUE='Play' OnClick='Player.controls.play()'>".chr(13).
    		"<INPUT type='image' src='/images/movie_stop.gif' NAME='BtnStop' VALUE='Play' OnClick='Player.controls.stop()'>");

    
  }
  $tpl->setVariable("COMPLETE_URL"    , "/index.php?html=movie_view_complete&p_movie_sch_seq=$p_movie_sch_seq&p_user_id=$user_id");
  
	$sth = $db->prepare("INSERT INTO TB_MOVIE_REC (MOVIE_SCH_SEQ, USER_ID, VIEW_START, IP) VALUES (?,?,?,?)");
  $data = array($movie_sch_seq, $user_id, date("Y:m:d H:i:s"), $HTTP_SERVER_VARS["REMOTE_ADDR"]);
  $db->execute($sth, $data );  
  
  $sth = $db->prepare("UPDATE TB_MOVIE_REC SET VIEW_START = ? WHERE MOVIE_SCH_SEQ = ? AND USER_ID = ? AND IP = ?");
  $data = array(date("Y:m:d H:i:s"), $movie_sch_seq, $user_id, $HTTP_SERVER_VARS["REMOTE_ADDR"]);
  $db->execute($sth, $data );  
  // print the output
  $tpl->show();
  
	
?>