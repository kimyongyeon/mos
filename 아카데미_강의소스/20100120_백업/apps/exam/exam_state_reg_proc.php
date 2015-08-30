<?php
	// ================================================================
	// ���α׷� �ڵ�� : exam_state_reg_proc.php
	// �ۼ���          : ��뿬
	// ���α׷� ����   : ���� ������� ����, �ǳʶٱ� �����͸� ó���Ѵ�.
	// �Ķ���� ���� :  //http://www.academysoft.kr/apps/exam/exam_state_reg_proc.php?p_command=start&p_bookid=2010_M3PC1&p_examid=E1&p_userid=toyongyeon&p_examlgubun=POWERPOINT2003&p_examsgubun=CORE : ����
	//http://www.academysoft.kr/apps/exam/exam_state_reg_proc.php?p_command=skip&p_bookid=2010_M3PC1&p_examid=E1&p_userid=toyongyeon&p_examlgubun=POWERPOINT2003&p_examsgubun=CORE&p_skipno=9&p_elapsedtime=121 : �ǳʶٱ�
	//http://www.academysoft.kr/apps/exam/exam_state_reg_proc.php?p_command=next&p_bookid=2010_M3PC1&p_examid=E1&p_userid=toyongyeon&p_examlgubun=POWERPOINT2003&p_examsgubun=CORE&p_curqstseq=9&p_examwrong=true&p_curjumsu=20&p_elapsedtime=121 : ����
	// ================================================================
	// ������ ������ �׸�
	//=================================================================
	// $p_command;    // ��ư �̺�Ʈ(�ǳʶٱ�, ����, ����) : skip, start, next
    // $p_bookid;     // �� ���̵� : 2010_M3PC1)
    // $p_examid;     // ���� ���̵� : E1, E2, G1
    // $p_userid;     // TB_EXAM_REC.USER_ID
    // $p_examlgubun; // �뱸�� : POWERPOINT2003
    // $p_examsgubun; // �ұ��� : CORE
	// ================================================================
    // ���� ������ �׸�
	// ================================================================
	// $p_skipno;     // SKIP ������ȣ : 1,2,3,1,2,3....
	// $p_curqstseq;  // ���繮�� ��ȣ : 1
	// $p_examwrong;  // Ʋ������ �ؼ� : " ", "���� ������ �����Ͻÿ�."
	// $p_curjumsu;   // ��������      : 20
	// $p_elapsedtime; // ����ð�
	// ================================================================
	// ���� ���� �׸�
	// ================================================================
	// $p_regilsi;      // ����Ͻ�(�������� ó��) : 20100116130000
	// $p_updateilsi;   // �����Ͻ�(�������� ó��) : 20100116130000
	// $p_starttime;    // ������۽ð�            : 20100116130000  
	// $p_endtime;      // ���۳��ð�              : 20100116130000
	// $p_retake;       // ����� Ƚ��             : 1
	// ================================================================
	// include Common Library
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";   	
	include $_zb_path."../commonLib.php";	

//	echo "receive data list <BR>";
//	$res = sprintf("%02d", 1);
//	$strqst = "QST".$res;
//	$rtndate = date('Y/m/d H:i:s');
//	echo $rtndate;

	if($p_command == "skip") // �ǳʶٱ� Ŭ����
	{
		func_reg_Skip($p_bookid, $p_examid, $p_userid, $p_examlgubun, $p_examsgubun, $p_skipno, $p_elapsedtime);
		echo "<br>skip update success...!";
	}
	else
	if($p_command == "next") // ���� Ŭ����
	{
		func_reg_Next($p_bookid, $p_examid, $p_userid, $p_examlgubun, $p_examsgubun, $p_curqstseq, $p_examwrong, $p_curjumsu, $p_elapsedtime);
    	echo "<br>next update success...!";
	}
	else
	if($p_command == "start") // ���� Ŭ����(�����)
	{
		func_reg_Start($p_bookid, $p_examid, $p_userid, $p_examlgubun, $p_examsgubun);
		echo "<br>start insert/update success...!";
	}

	function func_reg_Next($bookid, $examid, $userid, $examlgubun, $examsgubun, $curqstseq, $examwrong, $curjumsu, $elapsedtime)
	{
		// ���� �˻�
		$connect=dbConn();
		$member=member_info();

		call_pear_init();
		require_once("DB.php");  

		// DB ����
		$db =& DB::connect(call_pear_db_dsn());
		if (PEAR::isError($db)) {
			die($db->getMessage()); 
		}

		//******************************
		// CLASS_ID ã��
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
		// TB_EXAM.SEQ ã��
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
		// TB_EXAM_SCH.SEQ ã��
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
        //******************************

		// select ������ȣ�� �ҷ��´�.
		$sql = "SELECT r.SKIP_NO, r.QST01, r.QST02, r.QST03, r.QST04, r.QST05, r.QST06, r.QST07, r.QST08, r.QST09, r.QST10, r.QST11, r.QST12, r.QST13, r.QST14, r.QST15, r.QST16, r.QST17, r.QST18, r.QST19, r.QST20, e.EXAM_PASS_SCORE, e.EXAM_TOTAL_CNT, r.EXAM_START, s.EXAM_SEQ, s.SEQ, r.SEQ, r.EXAM_PASS "
			 ." FROM TB_EXAM_SCH s, TB_EXAM e, TB_EXAM_REC r "
			 ." WHERE s.SEQ = '$exam_sch_seq' "
			 ." AND s.EXAM_SEQ = e.SEQ "
			 ." AND r.USER_ID = '$userid' ";

		$res = $db->query($sql);
		if (PEAR::isError($db)) {
		die($db->getMessage());
		}

		while ($res->fetchInto($row)) {
			$r_skipno = $row[0]; // SKIP_NO
			$r_qst01  = $row[1]; // QST01
			$r_qst02  = $row[2]; // QST02
			$r_qst03  = $row[3]; // QST03
			$r_qst04  = $row[4]; // QST04
			$r_qst05  = $row[5]; // QST05
			$r_qst06  = $row[6]; // QST06
			$r_qst07  = $row[7]; // QST07
			$r_qst08  = $row[8]; // QST08
			$r_qst09  = $row[9]; // QST09
			$r_qst10  = $row[10]; // QST10
			$r_qst11  = $row[11]; // QST11
			$r_qst12  = $row[12]; // QST12
			$r_qst13  = $row[13]; // QST13
			$r_qst14  = $row[14]; // QST14
			$r_qst15  = $row[15]; // QST15
			$r_qst16  = $row[16]; // QST16
			$r_qst17  = $row[17]; // QST17
			$r_qst18  = $row[18]; // QST18
			$r_qst19  = $row[19]; // QST19
			$r_qst20  = $row[20]; // QST20
			$e_exam_pass_socre = $row[21]; // EXAM_PASS_SCORE
			$totalcnt = $row[22]; // EXAM_TOTAL_CNT
			$r_exam_start = $row[23]; // EXAM_START
			$s_examseq = $row[24]; // EXAM_SEQ
			$s_seq = $row[25]; // SEQ
			$r_seq = $row[26];
			$r_exam_pass = $row[27]; // ����ȣ�� �ٽ� ���͵� �ջ��� ���� ���ϰ� �ϱ�����...
		}

		$arry_skipno = explode("@", $r_skipno); // ������ȣ�� ������.
		
		for($i=0; $i<$totalcnt*2; $i++) {
			// SKIP_NO ����
			if ($curqstseq == $arry_skipno[$i]) {
				$arry_skipno[$i] = 0;
				$i = 0;
			}
		}

		$str_skipno = implode("@", $arry_skipno);
		echo " : ", $str_skipno;
    	$cur_skipno = $str_skipno;
echo $totalcnt, $curqstseq,$r_exam_pass;
		if ($totalcnt == $curqstseq) // �����ð�, ������, �հ�/���հ� üũ
		{	
      if ($r_exam_pass != "������")
        exit;

      $strbuff1 = sprintf("%02d", $curqstseq);
      $strqst = "QST".$strbuff1;
      $qst = $curjumsu; // �������� ����
    
      $strbuff2 = sprintf("%02d", $curqstseq);
      $strqct = "QCT".$strbuff2;
      $ewrong = $examwrong; // ���� ������ '0' �϶� Ʋ�� ���� ������ �ִ´�.

			// ������ ���Ѵ�.
			$total_score = $r_qst01 + $r_qst02 + $r_qst03 + $r_qst04 + $r_qst05 + $r_qst06 + $r_qst07 + $r_qst08 + $r_qst09 + $r_qst10 + $r_qst11 + $r_qst12 + $r_qst13 + $r_qst14 + $r_qst15 + $r_qst16 + $r_qst17 + $r_qst18 + $r_qst19 + $r_qst20+$qst;
			
			// �հ�, ���հ� üũ
			if ($total_score > $e_exam_pass_socre)
				$exam_pass = "�հ�";
			else
				$exam_pass = "���հ�";

			// ����
      $strupdate = "UPDATE TB_EXAM_REC SET ".$strqst." = ?,".$strqct." = ?,"."EXAM_END = now(), EXAM_PASS = ?, UPDATE_ILSI = now(), EXAM_WRONG = ?, CUR_QST_SEQ = ?, ELAPSED_TIME = ?, TOTAL_SCORE = ?, SKIP_NO = ? WHERE SEQ = ?";
      
			$sth = $db->prepare($strupdate);
			$data = array($qst, $ewrong, $exam_pass, $examwrong, $curqstseq, $elapsedtime, $total_score, $cur_skipno, $r_seq);
			$db->execute($sth, $data ); 
		}
		else
		{
			for ($i=1; $i<21; $i++)	{
				if ($curqstseq == $i)
				{
					$strbuff1 = sprintf("%02d", $i);
					$strqst = "QST".$strbuff1;
					$qst = $curjumsu; // �������� ����
				
					if ($curjumsu == 0)	{
						$strbuff2 = sprintf("%02d", $i);
						$strqct = "QCT".$strbuff2;
						$ewrong = $examwrong; // ���� ������ '0' �϶� Ʋ�� ���� ������ �ִ´�.
					}
					else
					{
						$strbuff2 = sprintf("%02d", $i);
						$strqct = "QCT".$strbuff2;
						$ewrong = "������"; // ���� ������ '0' �϶� Ʋ�� ���� ������ �ִ´�.
					}
				}
			}

			$exam_pass = "������";
      $curqstseq++;
			// ����
			$strupdate = "UPDATE TB_EXAM_REC SET ".$strqst." = ?,".$strqct." = ?,"."EXAM_PASS = ?, UPDATE_ILSI = now(), CUR_JUMSU = ? , EXAM_WRONG = ?, CUR_QST_SEQ = ?, ELAPSED_TIME = ?, SKIP_NO = ? WHERE SEQ = ?";
			$sth = $db->prepare($strupdate);
			$data = array($qst, $ewrong, $exam_pass, $curjumsu, $examwrong, $curqstseq, $elapsedtime, $cur_skipno, $r_seq);
			$db->execute($sth, $data );   
		}
	}

	function func_reg_Start($bookid, $examid, $userid, $examlgubun, $examsgubun)
	{
		// ���� �˻�
		$connect=dbConn();
		$member=member_info();

		call_pear_init();
		require_once("DB.php");  

		// DB ����
		$db =& DB::connect(call_pear_db_dsn());
		if (PEAR::isError($db)) {
			die($db->getMessage()); 
		}

		//******************************
		// rowcont ã��
		$sql = "SELECT r.USER_ID, r.RETAKE_CNT "
		 ." FROM TB_EXAM_REC r "
		 ." WHERE r.USER_ID = '$userid' ";

		$res = $db->query($sql);
		if (PEAR::isError($db)) {
		die($db->getMessage());
		}
		
		$rowcount = 0;
		while ($res->fetchInto($row)) {
			$rowcount++;
			$r_retakecnt = $row[1];
		}
        //******************************
		// CLASS_ID ã��
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
		// TB_EXAM.SEQ ã��
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
		// TB_EXAM_SCH.SEQ ã��
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
        //******************************

    // �ѻ���� ��å�� ���� ���ø� �ι��̻� �Ұ��
    if($rowcount >= 0 && $r_retakecnt >= 0)
		{	
			// insert
			$r_retakecnt = 1;
			$sth = $db->prepare("INSERT INTO TB_EXAM_REC (RETAKE_CNT, USER_ID, EXAM_SCH_SEQ, EXAM_START, UPDATE_ILSI, REG_ILSI) values (?,?,?,now(),now(),now())");
			$data = array($r_retakecnt, $userid, $exam_sch_seq);
			$db->execute($sth, $data );  
			if (PEAR::isError($db)) {
			die($db->getMessage());
			}

        	echo "<br>start insert success...!";
		}
		else
		{
			$r_retakecnt++;
			// update
			$sth = $db->prepare("UPDATE TB_EXAM_REC SET RETAKE_CNT = ?, UPDATE_ILSI = now() WHERE USER_ID = ?");
			$data = array($r_retakecnt, $userid);
			$db->execute($sth, $data );
			
	    	echo "<br>start update success...!";
		}
	}

	function func_reg_Skip($bookid, $examid, $userid, $p_examlgubun, $p_examsgubun, $skipno, $elapsedtime)
	{
		// ���� �˻�
		$connect=dbConn();
		$member=member_info();

		call_pear_init();
		require_once("DB.php");  

		// DB ����
		$db =& DB::connect(call_pear_db_dsn());
		if (PEAR::isError($db)) {
			die($db->getMessage()); 
		}

        //******************************
		// CLASS_ID ã��
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
		// TB_EXAM.SEQ ã��
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
		// TB_EXAM_SCH.SEQ ã��
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
        //******************************

		$sql = "SELECT SEQ, SKIP_NO "
		 ." FROM TB_EXAM_REC "
		 ." WHERE EXAM_SCH_SEQ = '$exam_sch_seq' "
		 ." AND USER_ID = '$userid' ";

		$res = $db->query($sql);
		if (PEAR::isError($db)) {
		die($db->getMessage());
		}
		
		while ($res->fetchInto($row)) {
			$r_seq = $row[0];
		}
        //******************************

		$res = $db->query($sql);
		if (PEAR::isError($db)) {
		die($db->getMessage());
		}

		while ($res->fetchInto($row)) {
			$r_skipno = $row[1];
		}
		
		$r_skipno = $skipno."@".$r_skipno; // ������ȣ �߰�

		// ����
		$sth = $db->prepare("UPDATE TB_EXAM_REC SET SKIP_NO = ?, UPDATE_ILSI = now(), ELAPSED_TIME = ? WHERE SEQ = ?");
		$data = array($r_skipno, $elapsedtime, $r_seq);
		$db->execute($sth, $data );
	}
?>