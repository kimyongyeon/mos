<?
  $ss_job = $HTTP_SESSION_VARS['ss_job'];
	if (!$ss_job)
	{
		// 리다이렉트    
		error("비정상적인 접근 방법입니다.(cb_header_check)<br>[".$HTTP_REFERER."]","/");
  }		
		
  if ($ss_job == 'student')
  {
?>
<!-- ** student ** -->
<tr>
  <td><img src="/images/img_25.gif" width="72" height="24" vspace="10" /></td>
</tr>
<tr>
  <td height="1" bgcolor="cccccc"></td>
</tr>
<tr>
  <td align="center">
	  <? call_cb_board('bbs');?><img src="/images/img_28.gif" width="96" height="35" hspace="10" border="0" /></a>
	  <? call_cb_board('pds');?><img src="/images/img_29.gif" width="96" height="35" hspace="10" border="0" /></a>
	  <? call_cb_pgm('movie');?><img src="/images/img_30.gif" width="96" height="35" hspace="10" border="0" /></a>
  	<? call_cb_pgm('exam_list_student');?><img src="/images/img_34.gif" width="96" height="35" hspace="10" border="0" /></a>
	</td>
</tr>
<tr>
  <td height="1" colspan="2" bgcolor="cccccc"></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<?
  }
  else if ($ss_job == "teacher" )
  {
?>  	
<!-- ** teacher ** -->
<tr>
  <td>
  	<table width="100%" border="0" cellspacing="1" cellpadding="5">
			<tr>
			  <td width="13%"><img src="/images/img_26.gif" width="72" height="24" vspace="10" /></td>
			  <td width="87%"><table border="0" cellspacing="1" cellpadding="3">
			      <tr>
			        <td width="3"><img src="/images/img_27.gif" width="3" height="18" /></td>
			        <td><? call_cb_pgm('class_id_list');?></td>
			      </tr>
			    </table></td>
			</tr>
			<tr>
			  <td height="1" colspan="2" bgcolor="cccccc"></td>
			</tr>
			<tr>
			  <td colspan="2" align="left">
			  	<? call_cb_board("bbs");?><img src="/images/img_28.gif" width="96" height="35" hspace="5" border="0" /></a>
			    <? call_cb_board("pds");?><img src="/images/img_29.gif" width="96" height="35" hspace="5" border="0" /></a>
			    <? call_cb_pgm("movie");?><img src="/images/img_30.gif" width="96" height="35" hspace="5" border="0" /></a>
			    <? call_cb_pgm("member_list");?><img src="/images/img_31.gif" width="96" height="35" hspace="5" border="0" /></a>
			    <? call_cb_pgm("movie_sch_man");?><img src="/images/img_32.gif" width="96" height="35" hspace="5" border="0" /></a>
			    <? call_cb_pgm("movie_rec");?><img src="/images/img_33.gif" width="96" height="35" hspace="5" border="0" /></a>
			    <? call_cb_pgm("exam_sch_man");?><img src="/images/img_35.gif" width="96" height="35" hspace="5" border="0" /></a>
				<? call_cb_pgm("rec_no");?><img src="/images/img_36.gif" width="96" height="35" hspace="5" border="0" /></a>
				<? call_cb_pgm("rec_student");?><img src="/images/img_37.gif" width="96" height="35" hspace="5" border="0" /></a>
			  </td>
			</tr>
    <tr>
      <td height="1" colspan="2" bgcolor="cccccc"></td>
    </tr>
  </table></td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<?
  }        
?>  