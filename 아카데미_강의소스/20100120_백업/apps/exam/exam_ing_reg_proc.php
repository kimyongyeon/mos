<?php
	// =======================================================
	// 프로그램 코드명 : exam_ing_reg_proc.php
	// 작성자          : 김용연
	// 프로그램 설명   : 현재 진행중인 경과시간을 저장한다.
    // ================================================================
	// Global 전역변수 선언 및 Input 데이터
	// ================================================================
    // $p_bookid;     // 북 아이디 (예 : 2010_M3PC1)
    // $p_examid;     // 시험 아이디 (예: 
    // $p_examseq;    // TB_EXAM_SCH.EXAM_SEQ
    // $p_userid;     // TB_EXAM_REC.USER_ID
    // $p_examschseq; // TB_EXAM_REC.EXAM_SCH_SEQ
	// $p_elapsedtime; // 경과시간
	// http://www.academysoft.kr/apps/exam/exam_ing_reg_proc.php?p_bookid=2010_M3PC1&p_examid=E1&p_userid=toyongyeon&p_examlgubun=POWERPOINT2003&p_examsgubun=CORE&p_elapsedtime=220
	// ================================================================
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";   
	include $_zb_path."../commonLib.php";	

	func_reg_ing($p_bookid, $p_examid, $p_userid, $p_examlgubun, $p_examsgubun, $p_elapsedtime);
	
	function func_reg_ing($bookid, $examid, $userid, $examlgubun, $examsgubun, $elapsedtime)
	{
		// 권한 검사
		$connect=dbConn();
		$member=member_info();

		call_pear_init();
		require_once("DB.php");  

		// DB 접속
		$db =& DB::connect(call_pear_db_dsn());
		if (PEAR::isError($db)) {
			die($db->getMessage());
		}

		//******************************
		// CLASS_ID 찾기
		$sql = "SELECT TB_REG1.CLASS_ID "
		 ." FROM TB_CLASS, TB_REG1 "
		 ." WHERE TB_REG1.USER_ID = '$userid' "
		 ." AND BOOK_ID = '$bookid' "
		 ." AND TB_REG1.CLASS_ID = TB_CLASS.CLASS_ID";

		$res = $db->query($sql);
		if (PEAR::isError($db)) {
		die($db->getMessage());
		}
		
		while ($res->fetchInto($row)) {
			$class_id = $row[0];
		}
        //******************************
		// TB_EXAM.SEQ 찾기
		$sql = "SELECT SEQ "
		 ." FROM TB_EXAM "
		 ." WHERE BOOK_ID = '$bookid' "
		 ." AND EXAM_ID = '$examid' ";

		$res = $db->query($sql);
		if (PEAR::isError($db)) {
		die($db->getMessage());
		}
		
		while ($res->fetchInto($row)) {
			$exam_seq = $row[0];
		}
        //******************************
		// TB_EXAM_SCH.SEQ 찾기
		$sql = "SELECT SEQ "
		 ." FROM TB_EXAM_SCH "
		 ." WHERE CLASS_ID = '$class_id' "
		 ." AND EXAM_SEQ = '$exam_seq' ";

		$res = $db->query($sql);
		if (PEAR::isError($db)) {
		die($db->getMessage());
		}
		
		while ($res->fetchInto($row)) {
			$exam_sch_seq = $row[0];
		}

		// select 문제번호를 불러온다.
		$sql = "SELECT SEQ "
             ." FROM TB_EXAM_REC "
			 ." WHERE USER_ID = '$userid' "
			 ." AND EXAM_SCH_SEQ = '$exam_sch_seq' ";
echo $sql;
		$res = $db->query($sql);
		if (PEAR::isError($db)) {
		die($db->getMessage());
		}

		while ($res->fetchInto($row)) {
			$r_seq = $row[0];
		}

		// TB_EXAM_REC RECORD UPDATE
		$sth = $db->prepare("UPDATE TB_EXAM_REC SET ELAPSED_TIME = ? WHERE SEQ = ?");
		$data = array($elapsedtime, $r_seq);
		$db->execute($sth, $data );  

		echo "update complete : ";
		echo $elapsedtime;
	} // end function func_reg_ing
?>