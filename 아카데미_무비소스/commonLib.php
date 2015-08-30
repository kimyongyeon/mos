<?        
	
  // 게시판 Call
	function call_board($board) {
		echo("<a href=/bbs/zboard.php?id=$board>");
	} 
	
	function call_cb_pgm($board) {		
		
		//$ss_job = $HTTP_SESSION_VARS['ss_job'];
		$ss_job = $_SESSION['ss_job'];
		if (!$ss_job)
			error("비정상적인 접근 방법입니다.(call_cb_board_check1)");
		
		//$ss_class_id = $HTTP_SESSION_VARS['ss_class_id'];
		$ss_class_id = $_SESSION['ss_class_id'];
		if (!$ss_class_id)
			error("비정상적인 접근 방법입니다.(call_cb_board_check2)");
			
		call_pear_init();			
		
		$enc_cb_pgm = call_encrypt($_SESSION["ss_user_id"],$ss_class_id);	
		if ($board == "movie")
		{
			echo("<a href=/index.php?html=movie_list_student&p_class_id=".$ss_class_id.">");
		}		
		else
		if ($board == "member_list")
		{
			echo("<a href=/index.php?html=member_list&p_class_id=".$ss_class_id.">");
		}		
		else		
		if ($board == "movie_sch_man")
		{
			echo("<a href=/index.php?html=movie_sch_man&p_class_id=".$ss_class_id.">");
		}						
		else		
		if ($board == "movie_rec")
		{
			echo("<a href=/index.php?html=movie_rec&p_class_id=".$ss_class_id.">");
		}			
		else		
		if ($board == "class_id_list")
		{
			echo($_SESSION['ss_class_id_list']);
		}										
		else		
		if ($board == "exam_list_student")
		{
			echo("<a href=/index.php?html=apps/exam/exam_list_student&p_class_id=".$ss_class_id.">");
		}										
		else		
		if ($board == "exam_sch_man")
		{
			echo("<a href=/index.php?html=apps/exam/exam_sch_man&p_class_id=".$ss_class_id.">");
		}										
	    else		
		if ($board == "rec_no")
		{
			echo("<a href=/index.php?html=apps/exam/exam_rec_by_no&p_class_id=".$ss_class_id.">");
		}										
    	else		
		if ($board == "rec_student")
		{
			echo("<a href=/index.php?html=apps/exam/exam_rec_by_student&p_class_id=".$ss_class_id.">");
		}			

	}	
	
	function call_cb_board($board) {		
		
		//$ss_job = $HTTP_SESSION_VARS['ss_job'];
		$ss_job = $_SESSION['ss_job'];
		if (!$ss_job)
			error("비정상적인 접근 방법입니다.(call_cb_board_check1)");
		
		//$ss_class_id = $HTTP_SESSION_VARS['ss_class_id'];
		$ss_class_id = $_SESSION['ss_class_id'];
		if (!$ss_class_id)
			error("비정상적인 접근 방법입니다.(call_cb_board_check2)");
		
		$cb_board = "";	
		if ($board == "bbs")
			$cb_board = "cb_".$ss_class_id."_bbs";			
		else
		if ($board == "pds")
			$cb_board = "cb_".$ss_class_id."_pds";
		else
			echo("<a href=#>");	
			
		echo("<a href=/bbs/zboard.php?id=$cb_board>");
	}		
	
	// PEAR Framework 사용
	function call_pear_init() {
		ini_set('include_path','/home/hosting_users/academysoft/www/pkg/PEAR/PEAR/:'.ini_get('include_path'));	
	}	
	
	// PEAR Framework DB 사용
	function call_pear_db_dsn() {
		$dsn = array(
		 'phptype'  => 'mysql',
		 'hostspec' => 'localhost',
		 'database' => 'academysoft',
		 'username' => 'academysoft',
		 'password' => 'dkzkepal'
		);
		return($dsn);
	}		
	
	// 암호화하기
	function call_encrypt($key, $plain_text) {
		// call pear init & call
	  //call_pear_init();
	  require_once ('Crypt/Blowfish.php');
	
		// Create the Crypt_Blowfish object using a secret key. The key must be
		//protected at all costs. The key is like a password to access the data.
		$blowfish = new Crypt_Blowfish($key);
		
		// This is the text we will encrypt
		$encrypted = $blowfish->encrypt($plain_text);
		$encrypted = bin2hex($encrypted);
		return($encrypted);
	}
	
	// 암호풀기
	function call_decrypt($key, $encrypted_text) {
		// call pear init & call
	  //call_pear_init();
	  require_once ('Crypt/Blowfish.php');
	
		// Create the Crypt_Blowfish object using a secret key. The key must be
		//protected at all costs. The key is like a password to access the data.
		$blowfish = new Crypt_Blowfish($key);
		
		// This is the text we will encrypt
		$d = pack("H*", $encrypted_text);
		$decrypted = $blowfish->decrypt($d);
		
		return($decrypted);
	}	
	
	// redirect
	function redirect($to)
	{
		$schema = $_SERVER['SERVER_PORT'] == '443' ? 'https' : 'http';
		$host = strlen($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME'];
		if (headers_sent()) return false;
		else
		{
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: $schema://$host$to");
			exit();
		}
}	
?>