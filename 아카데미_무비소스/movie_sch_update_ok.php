<?
  $_zb_url = "/bbs/";
  $_zb_path = "/home/hosting_users/academysoft/www/bbs/";
  include $_zb_path."outlogin.php";   

  // include Common Library
  include $_zb_path."../commonLib.php";	
  
  // ���� �˻�
  $connect=dbConn();
  $member=member_info();
  if($member[level] > 5)
  {
  	Error("���ѵ� ����Դϴ�.");
  }  
  // ����� ID
	$user_id=$member[user_id];
  
  // �ڱⰡ ������ �ݸ� �� �� �ֵ��� ����
  
  // call pear init & call
  call_pear_init();
  require_once("DB.php");  
  
  // DB ����
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  /*
  // ��ȸ 
  $sql = "SELECT SEQ"
        ."  FROM TB_MOVIE_SCH"
        ."  WHERE SEQ = s.SEQ"
        ."    AND s.MOVIE_SEQ     = m.SEQ"
        ."    AND r.MOVIE_SCH_SEQ = $p_seq";
  //echo($sql);        
  $res =& $db->query($sql);
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }  
  
  $iRow=0;
  if ($res->fetchInto($row)) 
  {  	
  	Error("���� ����� �����Ƿ� ������ �� �����ϴ�.");
  } 
  */  


  /*
  if (PEAR::isError($db)) {
    die($db->getMessage());
  } 
  */
  
  // ����
  $sth = $db->prepare("INSERT INTO TB_MOVIE_SCH (CLASS_ID, MOVIE_SEQ, PLAN_ILSI) values (?,?,?)");
  $data = array($_SESSION["ss_class_id"], $p_movie_seq, $p_plan_ilsi);
  $db->execute($sth, $data );  
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // ����
  $sth = $db->prepare("UPDATE TB_MOVIE_SCH SET PLAN_ILSI = ? WHERE SEQ = ?");
  $data = array($p_plan_ilsi, $p_seq);
  $db->execute($sth, $data );   
  
  // �����̷�Ʈ
  header("HTTP/1.1 301 Moved Permanently");
	header("Location: $HTTP_REFERER");
?>