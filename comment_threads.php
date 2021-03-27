<?php
$Path_to_guestbook_php=$_SERVER['DOCUMENT_ROOT'].'/php-guestbook/php/';
require_once($Path_to_guestbook_php.'func.php');
require_once($Path_to_guestbook_php.'pdo_mysql.php');
require_once($Path_to_guestbook_php.'usersonline.php');
require_once($Path_to_guestbook_php.'nocsrf.php');
//////////////////////////////////////////////
/// Get current directory for default dfilename
//////////////////////////////////////////////
$ddirarray = explode(DIRECTORY_SEPARATOR, getcwd());
$current_ddir = $ddirarray[(count($ddirarray)-1)];
//////////////////////////////////////////////
///
//////////////////////////////////////////////
$TempAdminLogin=true;
$getIP=getIP();
$og_image = "";
$og_image_alt  = "";
$defaultpostID=1;
######################################################################
# Database settings
######################################################################
$settings = include($Path_to_guestbook_php."/dbconfig.php");
$DB_HOST = $settings["host"];
$DB_USER = $settings["username"];
$DB_PASS = $settings["password"];
$DB_DB = $settings["dbname"];
//
//$table="";
$table="forum";
//
######################################################################
# Class for Mysql to PDO
######################################################################
$db= pdo_pconnect ( $DB_HOST , $DB_USER , $DB_PASS );
pdo_select_db ( $DB_DB )  or die ( "DATABASE ERROR! Line 20" );
######################################################################
# Get $comments_array from database or create default one
######################################################################
$search = getit($_GET,"search",75);
if($_GET)
	{
	$getID = getit($_GET,"postID",55);
	if (preg_match('/^[0-9]*$/', $getID)){	}else{$getID=$defaultpostID;}
	$comments_array = pdo_fetch_array(pdo_query("SELECT * FROM $table WHERE id='$getID'"));
	}
else if($_POST)
	{
	$post_id = getit($_POST,"post_id",55);
	if (preg_match('/^[0-9]*$/', $post_id)){	}else{$post_id=$defaultpostID;}
	$comments_array = pdo_fetch_array(pdo_query("SELECT * FROM $table WHERE id='$post_id'"));
	}
if(empty($comments_array)){
	//$comments_array = pdo_fetch_array(pdo_query("SELECT * FROM $table WHERE id='1'"));
	$comments_array = array(
			"dfilename" => $current_ddir,
			"ip"  => $getIP,
			"name"  => "John Doe",
			"email"  => "1@1.com",
			"location"  => "Texas USA",
			"topic"  => "Topic Goes here!",
			"comments"  => "Comment goes here!",
			"my_parent"  => "0",
			"timestamp" => time(),
			"url" => "",
		  "viewable" => "0",
		  "rating" => "0",
		  "views" => "1",
			"id" => false
			);
}
//////////////////////////////////////////////
///
//////////////////////////////////////////////
$TITLE=htmlspecialchars(substr( (trim($comments_array["topic"])),0,25));
$sitename=$TITLE;
$pagename=$sitename;
$dfilename=htmlspecialchars(trim($comments_array["dfilename"]));
if($dfilename==""){$dfilename=$current_ddir;}
$topic_string=htmlspecialchars(trim($comments_array["topic"]));
//////////////////////////////////////////////
$current_short_description = $sitename;
//Removes excessive white spaces
$current_short_description = preg_replace('/\s+/', ' ', $current_short_description);
//Removes all quotes "
$current_short_description = str_replace('"', "", $current_short_description);
//////////////////////////////////////////////
$current_long_description = htmlspecialchars(substr( (trim($comments_array["comments"])),0,250));
//Removes excessive white spaces
$current_long_description = preg_replace('/\s+/', ' ', $current_long_description);
//Removes all quotes "
$current_long_description = str_replace('"', "", $current_long_description);
$current_long_description = str_replace(',', "", $current_long_description);
$keywords=preg_replace('#\s+#',',',trim($current_long_description));
//////////////////////////////////////////////
/// xmlns_array
//////////////////////////////////////////////
$current_url='https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$xmlns_array = array(
    "og_image" => $og_image,
    "og_image_alt"  => $og_image_alt,
    "og_url"  => $current_url,
    "og_type"  => "",
    "og_description"  => $current_long_description,
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
    "Classification"  => "Bible, Christian, Religious, Revelation, Prophecy",
    "Title"  => $pagename,
    "Description"  => $current_long_description,
    "keywords"  => $keywords,
    "og_1"  => "",
    "og_2" => "",
    "og_3" => ""
    );
?>
<!DOCTYPE html  >
<html lang="en"  xmlns="http://www.w3.org/1999/xhtml"  xmlns:fb="http://ogp.me/ns/fb#">
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
<meta name="keywords" content=""<?php echo $header_array['keywords']; ?>">
<title><?php echo $header_array['Title']; ?></title>


<!-- start stylesheet -->
    <link rel="stylesheet" href="../../php-guestbook/theme/css/bootstrap.css" media="screen">
    <!-- <link rel="stylesheet" href="../../php-guestbook/theme/css/usebootstrap.css"> -->
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

//$topic_query = pdo_query("SELECT * FROM `prayer`");
//while($topic = pdo_fetch_array($topic_query)){
//}

}
?>





<?php

if(!$_POST){
?>
<div class="row">
	<div class="col-xl-10">
		<TABLE class="table "> <TR><TD  >
		<h1><?php  echo stripslashes($topic_string). " ".$dfilename;?></h1>
		<div class="jumbotron"><p>
		<?php
//if(){
$post_with = html_entity_decode($comments_array['comments']);
//$post_with = $comments_array['comments'];
//}else{
//$post_with =  htmlspecialchars(stripslashes($comments_array['comments']));
//$post_with =  nl2br($post_with);
//}
//$post_with = converttext($post_with);
echo $post_with;

echo '</p>';
if(($comments_array['viewable']) && ($comments_array['rating']>99))
{
echo'<p>';
echo '<a href="'.$comments_array['url'].'">'.$comments_array['url'].'</a>';
echo'</p>';
}
?>
</div>

		<ul class="nav nav-pills">
		  <li><a href="#">Posted by <b><?php
		  print(htmlspecialchars(stripslashes($comments_array['name'])) . "</b> ");
		  print("on " . date("l, F j Y g:i a", $comments_array['timestamp']));?>
		  </a></li>
		  <li><a href="#">Profile <span class="badge"></span></a></li>
		  <li><a href="#">Replies <span class="badge">3</span></a></li>

			<li>
			<button type="button" class="btn btn-info ">Like</button>
			<button type="button" class="btn btn-warning ">DisLike</button>
			<button type="button" class="btn btn-danger ">Spam</button>
			</li>

		</ul>
		</TD>



		<TD>
		<?php
		if($comments_array["my_parent"])
			{
			echo '<P><A HREF="comment_threads.php?postID='.$comments_array["my_parent"].'">View Parent Message</A></P>';
			}
		if($comments_array["dfilename"])
			{
			echo '<P><A HREF="index.php?dfilename='.$comments_array["dfilename"].'">View dfilename</A></P>';
			}
		echo '<P><A HREF="index.php">Return Home</A></P>';

		echo '</TD></TR></TABLE><hr>';
		///////////////////////////////////////////////////
		///////////////////////////////////////////////////
		///////////////////////////////////////////////////
?>
</div></div>
<?php
}
?>

<div class="row">
    <div class="col-xl-10">
  <?php
	$message_title="message_title";
  require_once($Path_to_guestbook_php.'comment.php');
  ?>
  </div>
</div>


<div class="row">
    <div class="col-xl-10">
		<?php
		////dfilename ip name email location topic comments my_parent timestamp id
		//$my_parent_value = post_comment_threads($getID);
		    print("&nbsp;&nbsp;Current thread:<BR><BR>");
		    /* child_posts function looks for children for the current post, the children of these children and so on by calling itself as soon as there are children posts found. */
		    //post_comment_threads($comments_array["id"]);
		    //echo "<HR>";
		    //display_child_comment_posts($comments_array["id"]);
		    //all_comments_threads2w($table,"100",$comments_array["dfilename"]);
		    //WIDTH=20% HEIGHT=100% ALIGN="left" VALIGN="top"
		?>
	</div>
</div>

<?php
//require_once($Path_to_guestbook_php.'footer.php');;
?>

</div>
<!-- eof #box_wrapper -->
</div>
<!-- eof #canvas -->



    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="../../php-guestbook/theme/bootstrap/bootstrap.min.js"></script>
		<script src="../../php-guestbook/theme/bootstrap/usebootstrap.js"></script>
  </body>
</html>
