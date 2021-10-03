<?php 
session_start();
ob_start();
$project_dir = "/blog/";
$path = $_SERVER['DOCUMENT_ROOT'].$project_dir;

// Developed by Abdul Razzaq -- ab.razzaq32@yahoo.com

include($path."./classes/database.php");
include($path."./classes/category.php");
include($path."./classes/post.php");
include($path."./classes/comment.php");
include($path."./classes/page.php");
include($path."./classes/slider.php");
include($path."./classes/role.php");
include($path."./classes/user.php");
include($path."./classes/auth.php");
include($path."./classes/message.php");
include($path."./classes/setting.php");
include($path."./classes/customfunctions.php");


 ?>