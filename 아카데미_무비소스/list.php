<?
	$_zb_url = "/bbs/";
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";   
		
	include $_zb_path."../commonLib.php";	
?>
<table border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><img src="images/main_img.gif" width="755" height="162" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><table width="755" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td width="270" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="images/img_13.gif" width="111" height="13" hspace="3" vspace="5" border="0" /></a></td>
						<td align="right"><? call_board("mb_notice");?><img src="images/img_14.gif" width="27" height="7" hspace="5" border="0" /></a></td>
					</tr>
					<tr>
						<td height="2" colspan="2" bgcolor="#33CCCC"></td>
					</tr>
					<tr>
						<td height="3" colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><? print_bbs("media/bbs", "공지사항", "mb_notice", 5, 24)?></td>
					</tr>
				</table></td>
				<td width="270" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="images/img_17.gif" width="163" height="12" hspace="3" vspace="5" border="0" /></a></td>
						<td align="right"><? call_board("mb_diary");?><img src="images/img_14.gif" width="27" height="7" hspace="5" border="0" /></a></td>
					</tr>
					<tr>
						<td height="2" colspan="2" bgcolor="#FF3399"></td>
					</tr>
					<tr>
						<td height="3" colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><? print_bbs("media/bbs", "수험일정", "mb_diary", 5, 24)?></td>
					</tr>
				</table></td>
				<td width="185"><? include './bbs/uks_vote/vote.php'; ?> </td>
			</tr>
			<tr>
				<td width="270" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="images/img_18.gif" width="111" height="13" hspace="5" vspace="3" border="0" /></a></td>
						<td align="right"><? call_board("mb_pds");?><img src="images/img_14.gif" width="27" height="7" hspace="5" border="0" /></a></td>
					</tr>
					<tr>
						<td height="2" colspan="2" bgcolor="#CCCCCC"></td>
					</tr>
					<tr>
						<td height="3" colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><? print_bbs("media/bbs", "자료실", "mb_pds", 5, 24)?></td>
					</tr>
				</table></td>				
				<!--<td width="270" align="top"><img src="images/img_16.gif" width="265" height="132" /></td>-->
				<td width="270" valign="top"><table width="96%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="images/title_register.gif" width="111" height="13" hspace="5" vspace="3" border="0" /></a></td>
						<td align="right"><? call_board("mb_register");?><img src="images/img_14.gif" width="27" height="7" hspace="5" border="0" /></a></td>
					</tr>
					<tr>
						<td height="2" colspan="2" bgcolor="#CCCCCC"></td>
					</tr>
					<tr>
						<td height="3" colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"><? print_bbs("media/bbs", "시험접수", "mb_register", 5, 24)?></td>
					</tr>
				</table></td>				
				
				<td width="185" align="center"><a href="http://www.purnflower.com/"><img src="images/img_15.gif" width="180" height="132" /><a></td>
			</tr>
		</table></td>
	</tr>
</table>
