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
  if($member[level] > 5)
  {
  	Error("���ѵ� ����Դϴ�.");
  }  
  
  // �ڱⰡ ������ �ݸ� �� �� �ֵ��� ����
  
  // call pear init & call
  call_pear_init();
  require_once("DB.php");
  require_once("HTML/Template/IT.php");
  
  // Template
  $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/templates");
  if(!$tpl->loadTemplatefile("movie_rec.tpl.htm", true, true)) Error("loadTemplatefile");
  
  // DB ����
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // ��ȸ : ��� ������
  $sql = "SELECT m.MOVIE_ID, m.TITLE, s.PLAN_ILSI, s.SEQ, m.SEQ "
      ."    FROM TB_MOVIE m"
      ."    LEFT JOIN TB_MOVIE_SCH s ON s.MOVIE_SEQ = m.SEQ"
      ."     AND s.CLASS_ID = '$p_class_id'"
      ."   WHERE s.PLAN_ILSI > '0000-00-01'";
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }  
  
  // ���� 
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
  
  // ����
  /*
  echo("<br>");
  foreach( $sColHeader as $ccc)
  {
  	echo($ccc.":");
  }      
  echo("<br>");
  */
    
  // ��ȸ : ������ ������
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
  $preHakbun="";  // �й��� üũ�ص� �Ŵ� ��, �й� �Է� ���� ��� ������
  $preName="";;
  while ($res->fetchInto($row)) {
  	if ($preName != $row[0] || $preHakbun != $row[1]) $iRow++;
  	$preName = $row[0];
  	$preHakbun = $row[1];
    $sColData["name"][$iRow] = $row[0];   // �̸�
    $sColData["icq"][$iRow] = $row[1];    // �й�
    $sColData[$row[3]][$iRow] = $row[4]."-".$row[5];  // ������
    //echo($iRow.":".$row[0].":".$row[1].":".$row[2].":".$row[3].":".$row[4]."<br>");
  }
  
  // ����
  for ($y=1; $y <= $iRow; $y++)
  {  	
  	// set seq, name, hakbun
  	$tpl->setVariable("SEQ", $y);
  	$tpl->setVariable("NAME", $sColData[name][$y]);
  	$tpl->setVariable("HAKBUN", $sColData[icq][$y]);
  	
  	// set ����
    foreach( $sColHeader as $ccc)
    {
    	if (!$tpl->setCurrentBlock("col")) Error("setCurrentBlock2");          	
    	if ($sColData[$ccc][$y]) $tpl->setVariable("COL", $sColData[$ccc][$y]);
    	else  									 $tpl->setVariable("COL", "�̼���");    	
    	$tpl->parseCurrentBlock("col");
    }
        
    // parse
    $tpl->parse("row");
  }
  
  // print the output
  $tpl->show();
	
?>