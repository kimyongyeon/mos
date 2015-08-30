<?
   include "header_01.php";
?>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td><table width="100%" border="0" cellspacing="1" cellpadding="5">
<? 
  
	$_zb_url = "/bbs/";
	$_zb_path = "/home/hosting_users/academysoft/www/bbs/";
	include $_zb_path."outlogin.php";
	include $_zb_path."../commonLib.php";
  
  // 권한 검사  
  if($member[level] != 1)
  {  	
  	include "cb_header.php";
  }
?>
      </table></td>
  </tr>
</table>
