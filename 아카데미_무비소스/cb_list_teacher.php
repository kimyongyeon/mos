<?
	$_zb_url = "/bbs/";
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";   
	
	include $_zb_path."../commonLib.php";

	if(!eregi($HTTP_HOST,$HTTP_REFERER)) Error("정상적으로 작성하여 주시기 바랍니다.");

// DB 연결
	if(!$connect) $connect=dbConn();

// 멤버 정보 구해오기;;; 멤버가 있을때
	$member=member_info();	
	if(!$member[no]) Error("로그인 하신 후 다시 하십시오");		

// 사용자 ID
	$user_id=$member[user_id];

// 수강반ID 검사			
	$result = mysql_query("select * from TB_REG2 where USER_ID='$user_id'",$connect);
	$iRow = 0;	
	$class_id_list = "수강반ID:";
	unset($tb_reg);
	while ($tb_reg = mysql_fetch_array ($result)) {
		$iRow = $iRow + 1;
		if ($iRow == 1 or $tb_reg[CLASS_ID]==$p_class_id) 
		{
			// 수강반 보드명 설정
			$cb_bbs = "cb_".$tb_reg[CLASS_ID]."_bbs";
  		$cb_pds = "cb_".$tb_reg[CLASS_ID]."_pds";
  		$class_id = $tb_reg[CLASS_ID]; 
    }
		$class_id_list	= $class_id_list."<a href='/index.php?html=cb_list_teacher&p_class_id=$tb_reg[CLASS_ID]'>$tb_reg[CLASS_ID]</A>&nbsp;&nbsp;&nbsp;";
	}	
	if($iRow==0) Error("강사 등록 신청을 하셔야 합니다.","");
	
// 세션 등록  
	if(!session_register("ss_job")) 
	{
		$HTTP_SESSION_VARS["ss_job"] = "";
 		Error("세션등록에 실패하였습니다.<br>"); 
  }
  $HTTP_SESSION_VARS["ss_job"] = "teacher";	
  $HTTP_SESSION_VARS["ss_user_id"] = $user_id;
  $HTTP_SESSION_VARS["ss_class_id"] = $class_id;
  $HTTP_SESSION_VARS["ss_class_id_list"] = $class_id_list;
?>
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <? include 'cb_header.php'; ?>
	<tr>
		<td><table width="755" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td width="50%" valign="top"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td>게시판</td>
						<td align="right"><? call_cb_board('bbs');?><img src="images/img_14.gif" width="27" height="7" hspace="5" border="0" /></a></td>
					</tr>
					<tr>
						<td height="2" colspan="2" bgcolor="#33CCCC"></td>
					</tr>
					<tr>
						<td height="3" colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><? print_bbs("media/bbs", "게시판", $cb_bbs, 5, 38)?></td>
					</tr>
				</table></td>
				<td width="50%" valign="top"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td>자료실</td>
						<td align="right"><? call_cb_board('pds');?><img src="images/img_14.gif" width="27" height="7" hspace="5" border="0" /></a></td>
					</tr>
					<tr>
						<td height="2" colspan="2" bgcolor="#FF3399"></td>
					</tr>
					<tr>
						<td height="3" colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><? print_bbs("media/bbs", "자료실", $cb_pds, 5, 38)?></td>
					</tr>
				</table></td>
			</tr>
			<tr>
				<td valign="top">&nbsp;</td>
				<td valign="top">&nbsp;</td>
			</tr>
		</table></td>
	</tr>
</table>

<?
// DB CLOSE	
	mysql_close($connect);
?>