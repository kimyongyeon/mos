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
  if(!$tpl->loadTemplatefile("movie_rec.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB 접속
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // 조회 : 대상 동영상
  $sql = "SELECT m.MOVIE_ID, m.TITLE, s.PLAN_ILSI, s.SEQ, m.SEQ "
      ."    FROM TB_MOVIE m"
      ."    LEFT JOIN TB_MOVIE_SCH s ON s.MOVIE_SEQ = m.SEQ"
      ."     AND s.CLASS_ID = '$p_class_id'"
      ."   WHERE s.PLAN_ILSI > '0000-00-01'";
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }  
  
  // 편집 
  $iCol=0;
  $sColHeader=array();
  while ($res->fetchInto($row)) {
    if (!$tpl->setCurrentBlock("col_header")) Error("setCurrentBlock");
    $tpl->setVariable("COL_HEADER", $row[0]);
    $tpl->parseCurrentBlock("col_header");    
    // parse outter block
    if (!$tpl->parse("col_header")) Error("parseCurrentBlock");
    $sColHeader[$iCol++] = $row[0];    
  }
  
  // 점검
  /*
  echo("<br>");
  foreach( $sColHeader as $ccc)
  {
  	echo($ccc.":");
  }      
  echo("<br>");
  */
    
  // 조회 : 수강한 동영상
  $sql = "SELECT z.name, z.icq, r.USER_ID, m.MOVIE_ID, r.VIEW_START, r.VIEW_END"
        ."  FROM TB_MOVIE_REC r, zetyx_member_table z, TB_MOVIE_SCH s, TB_MOVIE m"
        ."  WHERE r.USER_ID = z.user_id"
        ."    AND r.MOVIE_SCH_SEQ = s.SEQ"
        ."    AND s.MOVIE_SEQ = m.SEQ"
        ."    AND s.CLASS_ID = '$p_class_id'"
        ."  ORDER BY z.ICQ, m.MOVIE_ID";
  //echo($sql);        
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }  
  
  $iRow=0;
  $preHakbun="";  // 학번만 체크해도 돼는 데, 학번 입력 안한 사람 때문에
  $preName="";;
  while ($res->fetchInto($row)) {
  	if ($preName != $row[0] || $preHakbun != $row[1]) $iRow++;
  	$preName = $row[0];
  	$preHakbun = $row[1];
    $sColData["name"][$iRow] = $row[0];   // 이름
    $sColData["icq"][$iRow] = $row[1];    // 학번
    $sColData[$row[3]][$iRow] = $row[4]."-".$row[5];  // 수강일
    //echo($iRow.":".$row[0].":".$row[1].":".$row[2].":".$row[3].":".$row[4]."<br>");
  }
  
  // 편집
  for ($y=1; $y <= $iRow; $y++)
  {  	
  	// set seq, name, hakbun
  	$tpl->setVariable("SEQ", $y);
  	$tpl->setVariable("NAME", $sColData[name][$y]);
  	$tpl->setVariable("HAKBUN", $sColData[icq][$y]);
  	
  	// set 일자
    foreach( $sColHeader as $ccc)
    {
    	if (!$tpl->setCurrentBlock("col")) Error("setCurrentBlock2");          	
    	if ($sColData[$ccc][$y]) $tpl->setVariable("COL", $sColData[$ccc][$y]);
    	else  									 $tpl->setVariable("COL", "미수강");    	
    	$tpl->parseCurrentBlock("col");
    }
        
    // parse
    $tpl->parse("row");
  }
  
  // print the output
  $tpl->show();
	
?>