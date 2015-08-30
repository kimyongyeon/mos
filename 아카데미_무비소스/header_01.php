<?
   $_zb_url = "/bbs/";
   $_zb_path = "/home/hosting_users/academysoft/www/bbs/";
   include $_zb_path."outlogin.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<title>아카데미 소프트공학 연구소</title>
<link href="/css/global.css" rel="stylesheet" type="text/css" />
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:744px;
	top:70px;
	width:220px;
	height:21px;
	z-index:1;
	visibility: hidden;
}
#apDiv2 {
	position:absolute;
	left:616px;
	top:70px;
	width:180px;
	height:21px;
	z-index:2;
	visibility: hidden;
}
-->
</style>
</head>

<body bgcolor="efefef" leftmargin="0" topmargin="0" vlink="white">
<div id="apDiv1" onmouseover="MM_showHideLayers('apDiv1','','show','apDiv2','','hide')" onmouseout="MM_showHideLayers('apDiv1','','hide','apDiv2','','hide')">
	<table border="0" cellspacing="0" cellpadding="3">
		<tr>
			<td width="50"><a href="/bbs/zboard.php?id=mb_teacher">강의안내</a></td>
			<td width="70"><a href="#" onclick="MM_openBrWindow('/serial_reg_02.php','academysoft','width=400,height=250')">강사등록신청</a></td>
			<td width="60"><a href="/index.php?html=cb_list_teacher">강의실입장</a></td>
			<!--<td width="50"><a href="#">공지사항</a></td>-->
		</tr>
	</table>
</div>
<div id="apDiv2" onmouseover="MM_showHideLayers('apDiv1','','hide','apDiv2','','show')" onmouseout="MM_showHideLayers('apDiv1','','hide','apDiv2','','hide')">
	<table border="0" cellspacing="0" cellpadding="3">
		<tr>
			<td width="60"><a href="/bbs/zboard.php?id=mb_notice">공지사항</a></td>
			<td width="50"><a href="/bbs/zboard.php?id=mb_free">게시판</a></td>
			<td width="50"><a href="/bbs/zboard.php?id=mb_pds">자료실</a></td>
		</tr>
	</table>
</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="ffffff">
	<tr>
		<td width="241" height="30">&nbsp;</td>
		<td width="720" align="right"><table width="200" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><a href="/index.php?html=list"><img src="/images/img_01.gif" alt="" border="0" /></a></td>
				<td><a href="#" onclick="window.open('/bbs/member_join.php?group_no=1','zbMemberJoin','width=560,height=590,toolbars=no,resizable=yes,scrollbars=yes')"><img src="/images/img_02.gif" alt="" width="38" height="12" border="0" /></a></td>
				<td><a href="#"><img src="/images/img_03.gif" alt="" width="28" height="12" border="0" /></a></td>
			</tr>
		</table></td>
		<td align="right">&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="960"><table width="960" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="19"><img src="/images/m_bg.gif" alt="" width="19" height="41" /></td>
				<td width="221" bgcolor="#FFFFFF"><a href="/index.php?html=list"><img src="/images/logo.gif" alt="" width="201" height="34" hspace="10" border="0" /></a></td>
				<td width="116"><a href="/bbs/zboard.php?id=mb_courseware"><img src="/images/m_01.gif" alt="" width="116" height="41" border="0" /></a></td>
				<td width="85"><a href="/bbs/zboard.php?id=mb_ittech"><img src="/images/m_02.gif" alt="" width="85" height="41" border="0" /></a></td>
				<td width="99"><a href="/bbs/zboard.php?id=mb_license"><img src="/images/m_03.gif" alt="" width="99" height="41" border="0" /></a></td>
				<td width="86"><a href="/bbs/zboard.php?id=mb_book"><img src="/images/m_04.gif" alt="" width="86" height="41" border="0" /></a></td>
				<td width="85"><a href="#"><img src="/images/m_05.gif" alt="" width="85" height="41" border="0" onmouseover="MM_showHideLayers('apDiv1','','hide','apDiv2','','show')" /></a></td>
				<td width="88"><a href="#"><img src="/images/m_06.gif" width="88" height="41" border="0" /></a></td>
				<td width="75"><a href="#"><img src="/images/m_07.gif" alt="" width="75" height="41" border="0" onmouseover="MM_showHideLayers('apDiv1','','show')" /></a></td>
				<td width="86"><a href="#"><img src="/images/m_08.gif" alt="" width="86" height="41" border="0" /></a></td>
			</tr>
		</table></td>
		<td bgcolor="#000000">&nbsp;</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
		<td width="10" valign="top"><img width="10" height="0" /></td>
		<td width="225" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center"><? print_outlogin("mlogin", 1, 10) ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<!--<td align="center"><img src="/images/sam_01.gif" width="180" height="132" /></td>-->
				<!--<td align="center"><a href="http://www.academysoft.kr/bbs/zboard.php?id=mb_sc_free_edu"><img src="/event/sc_free_edu/2008_free_edu.jpg" width="191" height="116" /></a></td>-->
				<!--<td align="center"><a href="http://www.academysoft.kr/bbs/zboard.php?id=mb_register"><img src="/event/mos/2009_07_19_mos.jpg" width="191" height="116" /></a></td>-->
				<td align="center"><a href="http://selab.sunchon.ac.kr/pub/ketri/2010/mos/index.htm"><img border="0" src="/event/mos/2010_01_18_mos.jpg" width="191" height="116" /></a></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><table border="0" align="center" cellpadding="5" cellspacing="0">
					<tr>
						<td><a href="#"><img src="/images/img_10.gif" width="216" height="45" border="0" onclick="MM_openBrWindow('/serial_reg_01.php','academysoft','width=400,height=250')" /></a></td>
					</tr>
					<!-- 2007.09.04 : SCS
					<tr>
						<td><a href="#"><img src="/images/img_10.gif" width="216" height="45" border="0" /></a></td>
					</tr>
					-->
					<tr>
						<td><a href="/index.php?html=cb_list_student"><img src="/images/img_11.gif" width="216" height="45" border="0" /></a></td>
					</tr>
					<tr>
						<td><a href="#"><img src="/images/img_12.gif" width="216" height="45" border="0" /></a></td>
					</tr>
				</table></td>
			</tr>
			<tr>
			  <td align="center"><br />
			      <a href="http://day.passon.co.kr/" target="_blank"><img src="/images/link_01.gif" width="160" height="43" border="0" /></a><br />
		        <a href="http://mos.ybmsisa.com/" target="_blank"><img src="/images/link_02.gif" width="160" height="43" border="0" /></a><br />
	            <a href="http://www.gilbut.co.kr" target="_blank"><img src="/images/link_03.gif" width="160" height="42" border="0" /></a><br /></td>
		  </tr>
		</table></td>
		<td width="755" valign="top">