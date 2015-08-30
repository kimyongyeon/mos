<?php
// *nix style (note capital 'S')
define('SMARTY_DIR', '/home/hosting_users/academysoft/www/Smarty-2.6.18/libs/');

// windows style
//define('SMARTY_DIR', 'c:/webroot/libs/Smarty-v.e.r/libs/');

// hack version example that works on both *nix and windows
// Smarty is assumend to be in 'includes/' dir under current script
define('SMARTY_DIR',str_replace("\\","/",getcwd()).'/includes/Smarty-v.e.r/libs/');

require_once(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty();

?> 