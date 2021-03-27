<?php
$TempAdminLogin=true;
$Path_to_guestbook_php=$_SERVER['DOCUMENT_ROOT'].'/php-guestbook/php/';
require_once($Path_to_guestbook_php.'func.php');
require_once($Path_to_guestbook_php.'pdo_mysql.php');
require_once($Path_to_guestbook_php.'usersonline.php');
require_once($Path_to_guestbook_php.'nocsrf.php');
$getIP=getIP();
//////////////////////////////////////////////
/// Get current directory for default dfilename
//////////////////////////////////////////////
$ddirarray = explode(DIRECTORY_SEPARATOR, getcwd());
$current_ddir = $ddirarray[(count($ddirarray)-1)];
######################################################################
#
# Start Database
#
######################################################################
$settings = include($Path_to_guestbook_php."/dbconfig.php");
$DB_HOST = $settings["host"];
$DB_USER = $settings["username"];
$DB_PASS = $settings["password"];
$DB_DB = $settings["dbname"];
//////////////////////////////////////////////
//$table="";
$table="forum";
//////////////////////////////////////////////
$db= pdo_pconnect ( $DB_HOST , $DB_USER , $DB_PASS );
pdo_select_db ( $DB_DB )  or die ( "DATABASE ERROR! Line 29" );
######################################################################
#
# Start Settings
#
######################################################################
//$dfilename="";//
$dfilename="guestbook";//
if(!$dfilename){$dfilename=$current_ddir;}
//////////////////////////////////////////////
$pagename="PHP Guestbook";
//////////////////////////////////////////////
$current_short_description = "MYSQL PDO PHP Guestbook, Freedom of Speech Platform";
//////////////////////////////////////////////
$og_image = "";
$og_image_alt  = "";
//////////////////////////////////////////////
$reply_comment_message="Add New ".$dfilename;
//////////////////////////////////////////////
//$displaypostID=false;
$defaultpostID=false;
######################################################################
#
# Process Variables
#
######################################################################
//Removes excessive white spaces
$current_short_description = preg_replace('/\s+/', ' ', $current_short_description);
//Removes all quotes "
$current_short_description = str_replace('"', "", $current_short_description);
//////////////////////////////////////////////
$keywords=preg_replace('#\s+#',',',trim($current_short_description));
######################################################################
#
# Load Up Arrays
#
######################################################################
//////////////////////////////////////////////
/// comments_array
//////////////////////////////////////////////
//  $comments_array = pdo_fetch_array(pdo_query("SELECT * FROM $table WHERE id='7206'"));
if($defaultpostID){$comments_array = pdo_fetch_array(pdo_query("SELECT * FROM $table WHERE id='$defaultpostID'"));}
else{
$comments_array = array(
    "dfilename" => $dfilename,
    "ip"  => $getIP,
    "name"  => "",
    "email"  => "",
    "location"  => "",
    "topic"  => $pagename,
    "comments"  => "",
    "my_parent"  => "0",
    "timestamp" => time(),
    "url"  => "",
    "viewable"  => "",
    "rating"  => "",
    "views"  => "",
    "id" => $defaultpostID
    );
}
//////////////////////////////////////////////
/// xmlns_array
//////////////////////////////////////////////
$current_url='https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$xmlns_array = array(
    "og_image" => $og_image,
    "og_image_alt"  => $og_image_alt,
    "og_url"  => $current_url,
    "og_type"  => "",
    "og_description"  => $current_short_description,
    "og_title"  => $pagename,
    "og_app_id"  => "",
    "og_1"  => "",
    "og_2" => "",
    "og_3" => ""
    );
//////////////////////////////////////////////
/// header_array
//////////////////////////////////////////////
$header_array = array(
    "Copyright" => "Copyright © Jan. 1, 1999",
    "Revisit-After"  => "31 days",
    "Rating"  => "general",
    "Classification"  => "Religious, Revelation, Prophecy",
    "Title"  => $pagename,
    "Description"  => $current_short_description,
    "keywords"  => $keywords,
    "og_1"  => "",
    "og_2" => "",
    "og_3" => ""
    );
######################################################################
?>
<!DOCTYPE html  >
<html lang="en"  xmlns="http://www.w3.org/1999/xhtml" >
<head><meta charset="utf-8">
<meta property="og:image" content="<?php echo $xmlns_array['og_image']; ?>">
<meta property="og:url" content="<?php echo $xmlns_array['og_url']; ?>" >
<meta property="og:image:alt" content="<?php echo $xmlns_array['og_image_alt']; ?>" >
<meta property="og:type"  content="<?php echo $xmlns_array['og_type']; ?>" >
<meta property="og:description" content="<?php echo $xmlns_array['og_description']; ?>" >
<meta property="og:title" content="<?php echo $xmlns_array['og_title']; ?>" >
<meta property="fb:app_id" content="<?php echo $xmlns_array['og_app_id']; ?>" >
<!-- end xmlns -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Copyright" content="<?php echo $header_array['Copyright']; ?>" >
<meta name="Revisit-After" content="<?php echo $header_array['Revisit-After']; ?>" >
<meta name="Rating" content="<?php echo $header_array['Rating']; ?>">
<!--The available ratings are "general," "mature," "restricted" and "14 years." -->
<meta name="Classification" content="<?php echo $header_array['Classification']; ?>">
<meta name="Description" content="<?php echo $header_array['Description']; ?>">
<meta name="keywords" content="<?php echo $header_array['keywords']; ?>">
<title><?php echo $header_array['Title']; ?></title>

<!-- start stylesheet -->
    <link rel="stylesheet" href="../../php-guestbook/theme/css/bootstrap.css" media="screen">
    <!--<link rel="stylesheet" href="../../php-guestbook/theme/css/usebootstrap.css">-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../php-guestbook/theme/bootstrap/html5shiv.js"></script>
      <script src="../../php-guestbook/theme/bootstrap/respond.min.js"></script>
    <![endif]-->
<!-- end stylesheet -->

</head>

<body>
  <div class="container-fluid">
<?php
require_once($Path_to_guestbook_php.'menu.php');
?>
<div class="container-fluid">

<?php

if($TempAdminLogin){
echo '<button data-toggle="collapse" data-target="#demo" class="btn btn-info">Collapsible Admin</button>';
echo '<div id="demo" class="collapse">';
echo "TempAdminLogin=".$TempAdminLogin;
echo "<br>comments_array[]";
echo '<pre>'; print_r($comments_array); echo '</pre>';
echo "<br>xmlns_array[]";
echo '<pre>'; print_r($xmlns_array); echo '</pre>';
echo "<br>header_array[]";
echo '<pre>'; print_r($header_array); echo '</pre>';
echo '</div>';
}
?>


<?php
if(!$_POST){
?>
<!-- Start Webpage -->
 <div class="row">
 <div class="col-sm">
 <blockquote class="pull-">
     <h3>PHP Guestbook</h3>
Welcome to the MYSQL PDO PHP Guestbook, the Freedom of Speech Platform!<br>
This content could be either your HTML content or a selected postID?<br>
 <br>
 <a href="comment_threads.php?postID=1">PHP Guestbook</a>
     <div>
         <span class="badge badge-success">
 Posted by Samekhi Am I on March 7, 2021, 7:37 pm</span>
         <div class="pull-right">
         <span class="label label-default">
 <a href="?dfilename=guestbook">guestbook</a>
         </span>
     </div>
 </blockquote>
 </div>
 </div>
<!-- End Webpage -->
<?php
}
?>














  <!-- Start Comments -->
  <div class="row">
      <div class="col-xl-10">
    <?php
    $message_title=$reply_comment_message;
    require_once($Path_to_guestbook_php.'comment.php');
    ?>
    </div>
  </div>
  <!-- End Comments -->



  <!-- Start Display Comments threads -->
  <div class="row">
      <div class="col-xl-10">Last 100
  <?php
  if(!$_POST){
  all_comments_threads2w($table,"100",$dfilename);
  }
  ?>
    </div>
  </div>
  <!-- End Display Comments threads -->




  <!-- Start Footer -->
  <?php
  //require_once($_SERVER['DOCUMENT_ROOT'].'/php-guestbook/php/footer.php');
  ?>
  <!-- End Footer -->

  </div>
  <!-- eof #container-fluid -->
  </div>
  <!-- eof container-fluid -->

      <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
      <script src="../../php-guestbook/theme/bootstrap/bootstrap.min.js"></script>
      <script src="../../php-guestbook/theme/bootstrap/usebootstrap.js"></script>
    </body>
  </html>
