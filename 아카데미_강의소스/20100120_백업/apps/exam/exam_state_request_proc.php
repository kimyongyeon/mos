<?php
	// =======================================================
	// 프로그램 코드명 : exam_state_request_proc.php
	// 작성자          : 김용연
	// 프로그램 설명   : 현재 등록정보를 화면에 보여준다. 
    // $p_bookid;     // 북 아이디 (예 : 2010_M3PC1)
    // $p_examid;     // 시험 아이디 (예: 
    // $p_examseq;    // TB_EXAM_SCH.EXAM_SEQ
    // $p_userid;     // TB_EXAM_REC.USER_ID
    // $p_examschseq; // TB_EXAM_REC.EXAM_SCH_SEQ
	// http://www.academysoft.kr/apps/exam/exam_state_request_proc.php?p_bookid=2010_M3PC1&p_examid=E1&p_userid=toyongyeon&p_examlgubun=POWERPOINT2003&p_examsgubun=CORE
	// =======================================================
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";  
	include $_zb_path."../commonLib.php";	

	func_state_request($p_bookid, $p_examid, $p_userid, $p_examlgubun, $p_examsgubun);

	function func_state_request($bookid, $examid, $userid, $examlgubun, $examsgubun)
	{
		echo $elapsedtime;
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
		      ."  FROM TB_EXAM_SCH "
		      ." WHERE CLASS_ID = '$class_id' "
	          ."   AND EXAM_SEQ = '$exam_seq' ";

		$res = $db->query($sql);
		if (PEAR::isError($db)) {
		die($db->getMessage());
		}
		
		while ($res->fetchInto($row)) {
			$exam_sch_seq = $row[0];
		}

        $sql = "SELECT r.EXAM_START, r.EXAM_END, r.CUR_QST_SEQ, r.ELAPSED_TIME, r.RETAKE_CNT, r.SKIP_NO "
			  ."  FROM TB_EXAM_SCH s, TB_EXAM e, TB_EXAM_REC r "
			  ." WHERE e.EXAM_ID = '$examid' "
			  ."   AND r.USER_ID = '$userid' "
			  ."   AND e.BOOK_ID = '$bookid' "
			  ."   AND r.EXAM_SCH_SEQ = '$exam_sch_seq' ";

		$res =& $db->query($sql);
		if (PEAR::isError($db)) {
			die($db->getMessage());
		}
		while ($res->fetchInto($row)) 
		{
			$r_examstart = $row[0];
			$r_examend = $row[1];
			$r_curqstseq = $row[2];
			$r_elapsedtime = $row[3];
			$r_retakecnt = $row[4];
			$r_skipno = $row[5];
		}

		$arr = array($r_examstart, $r_examend, $r_curqstseq, $r_elapsedtime, $r_retakecnt, $r_skipno);
    	$rtn = implode(",", $arr);
		echo $rtn;
	} 
?>