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
  
  
  // �Է°� üũ 
  if (!$p_seq)
  {
  	Error("�ڷḦ ������ �� �����ϴ�.");
	}
  
  // call pear init & call
  call_pear_init();
  require_once("DB.php");  
  
  // DB ����
  $db =& DB::connect(call_pear_db_dsn());
  if (PEAR::isError($db)) {
    die($db->getMessage());
  }
  
  // ��ȸ : �̹� ������ ������ �ֳ�?
  $sql = "SELECT r.USER_ID, m.MOVIE_ID, r.VIEW_START, r.VIEW_END"
        ."  FROM TB_MOVIE_REC r, TB_MOVIE_SCH s, TB_MOVIE m"
        ."  WHERE r.MOVIE_SCH_SEQ = s.SEQ"
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
  
  // ����
  $sth = $db->prepare("DELETE FROM TB_MOVIE_SCH WHERE SEQ = ?");
  $data = array($p_seq);
  $db->execute($sth, $data );
  
  // �����̷�Ʈ
  header("HTTP/1.1 301 Moved Permanently");
	header("Location: $HTTP_REFERER");
?>