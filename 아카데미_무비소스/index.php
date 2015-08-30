<?
include "header_01.php";
?>
<?
// 2007.09.04 : SCS
//include $HTTP_GET_VARS[html].".php";
if (!$HTTP_GET_VARS[html]) 
{  
   include "list.php";
}   
else
{
   include $HTTP_GET_VARS[html].".php";
}  
?>
<?
include "foot_01.html";
?>
