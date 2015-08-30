<?
   $_zb_url = "/bbs/";
   $_zb_path = "/home/hosting_users/academysoft/www/bbs/";
   include $_zb_path."outlogin.php";   
	
// DB 연결
	if(!$connect) $connect=dbConn();
	
// 멤버 정보 구해오기
	$member=member_info();
	if(!$member[no]) Error("로그인 하신 후 다시 하십시오","window.close");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<title>강의 시리얼 등록</title>
<link href="css/global.css" rel="stylesheet" type="text/css" />
</head>

<script>
function check_submit()
 {

  if(!write.p_class_id.value) {alert("수강반ID를 입력하여 주십시요.");write.user_id.focus(); return false;}
  return true;
  }

</script>
<body leftmargin="0" topmargin="0">
<form name=write method=post action=serial_reg_01_ok.php enctype=multipart/form-data onsubmit="return check_submit();">
<table width="400" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="1" colspan="4"><img src="images/img_20.gif" width="275" height="22" hspace="10" vspace="10" /></td>
	</tr>
	<tr>
		<td height="1" bgcolor="#e2e2e2" colspan="4"></td>
	</tr>
	<tr>
		<td width="2%" height="33" align="right">&nbsp;<img src="images/dot.gif" /></td>
		<td width="16%" height="33" align="left">아이디</td>
		<td width="14%" height="33"><? echo("$member[user_id]"); ?></td>
		<td width="68%">&nbsp;</td>
	</tr>
	<tr>
		<td height="1" colspan="4" background="images/line.gif"></td>
	</tr>
	<tr>
		<td height="33" align="right">&nbsp;<img src="images/dot.gif" /></td>
		<td height="33" align="left">이름</td>
		<td height="33"><? echo("$member[name]"); ?></td>
		<td></td>
	</tr>
	<tr>
		<td height="1" colspan="4" background="images/line.gif"></td>
	</tr>
	<tr>
		<td height="33" align="right">&nbsp;<img src="images/dot.gif" /></td>
		<td align="left">수강반ID</td>
		<td colspan="2"><input name="p_class_id" type="text" class="textareabg" size="20" /></td>
	</tr>
	<tr>
		<td height="1" colspan="4" background="images/line.gif"></td>
	</tr>
	<tr>
		<td height="33" align="right">&nbsp;<img src="images/dot.gif" /></td>
		<td align="left">시리얼 번호</td>
		<td colspan="2"><input name="p_book_sno" type="text" class="textareabg" size="40" /></td>
	</tr>
	<tr>
		<td height="1" colspan="4" background="images/line.gif"></td>
	</tr>
	<tr>
		<td height="1" bgcolor="#e2e2e2" colspan="4"></td>
	</tr>
	<tr>
		<td height="34" colspan="4" align="center"><a href="#"><input type=image border=0 src=images/btn_ok.gif><img src="images/btn_cancel.gif" width="44" height="20" hspace="10" border="0" /></a></td>
	</tr>
	<tr id="button_submit">
		<td align="center" colspan="4"></td>
	</tr>
</form>	
</table>
</body>
</html>
<?
	@mysql_close($connect);
	foot();
?>