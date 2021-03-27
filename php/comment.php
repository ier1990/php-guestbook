<?php
if (!isset($_SESSION)) session_start();

if (!function_exists('inspect'))
{
  //error_log("deny from ".$_SERVER["REMOTE_ADDR"]." \n", 3, "/ip/comment_ban-ip.log");
  exit;
}
#######################################
#
#######################################
$error_text		= array();
$error_message = "";
function authenticate($val,$key,$min_length)
{
	global $error_text;
	if(inspect(html_entity_decode($val))){
		$error_text[] = "Your ".$key." has improper chars";
		return false;
	}

	if(is_html($val)){
		$error_text[] = "Enter your ".$key. " min ". $min_length ." char"." html url tags not allowed!";
		return false;
	}
	$error_message = "Enter your ".$key. " min ". $min_length ." char";
	$len = mb_strlen($val, 'UTF-8');

	if($key=="email"){
	$email_template = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
	if(preg_match($email_template, $val) !== 1){$error_text[] = "Incorrect email format";return true;}
	else{return false;}
	}


	if($len < $min_length){$error_text[] = $error_message;return true;}
	else{return false;}
}
#######################################
#
#######################################
function is_html($string) {
     preg_match("/<\/?\w+((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/",$string, $matches);
     if(count($matches)==0){
        return FALSE;
      }else{
         return TRUE;
      }
}
$comment_added=false;
//
$post_name = getit($_POST,"name",55);
authenticate($post_name,"name",3);
//
$post_email = getit($_POST,"email");
authenticate($post_email,"email",8);
//
$post_location = getit($_POST,"location");
authenticate($post_location,"location",2);
//
$post_url = getit($_POST,"url");
authenticate($post_url,"url",0);
//
$post_topic = getit($_POST,"topic",99,$comments_array["topic"]);
authenticate($post_topic,"topic",2);
//
$post_comments = getit($_POST,"comments");
authenticate($post_comments,"comments",25);
//
$post_url = getit($_POST,"post_url");
authenticate($post_url,"post_url",0);
//
$post_id = getit($_POST,"post_id",55);
if (preg_match('/^[0-9]*$/', $post_id)){$my_parent=$post_id;}else{$my_parent=0;}
//
$the_dfilename = getit($comments_array,"dfilename",55,$current_ddir);
$token_test=false;
//
if($_POST){
$token	 = (isset($_POST["token_contact"])) ? strip_tags(trim($_POST["token_contact"])) : false;
//
/************************************************/
/* CSRF protection */
/************************************************/
  $token_test = NoCSRF::check( 'csrf_token', $_POST, true, 60*60, false );
  if(!$token_test) {
		echo '<div class="error-message unit"><i class="fa fa-close"></i>
		Incorrect token/session expired? Please save/copy your text/comment below<hr>';
		echo '<a href="comment_threads.php?postID='.$my_parent.'" class="alert-link">
		  Click here to view the message you was replying to!</a>
		<textarea name="comments" class="form-control" rows="3" id="textArea">'.$post_comments.'</textarea></div>';
		exit;
	}

  require_once($_SERVER['DOCUMENT_ROOT'].'/php-guestbook/php/comment_ip.php');

	/* If validation error occurs */
	if ($error_text)
		{
		foreach ($error_text as $val) {
			$error_message .= '<li>' . $val . '</li>';
		}
		echo '<div class="error-message unit"><i class="fa fa-close"></i>Oops! The following errors occurred:<ul>' . $error_message . '</ul></div>';
		//exit;
		}
	else
		{
		//$jerk_check="";
		$jerk_check=pdo_fetch_array(pdo_query("SELECT MAX(id) FROM $table"));
		$jerk_check = $jerk_check['MAX(id)']+1;
		//echo $jerk_check;
		$timestamp = time();//when added

    if($post_url){$rating=1;$viewable=0;}else{$rating=100;$viewable=1;}
    $views=2;

    $query="INSERT INTO $table VALUES (
    '$the_dfilename'
    ,'$getIP'
    ,'$post_name'
    ,'$post_email'
    ,'$post_location'
    ,'$post_topic'
    ,'$post_comments'
    ,'$my_parent'
    ,'$timestamp'
    ,'$post_url'
    ,'$viewable'
    ,'$rating'
    ,'$views'
    ,'$jerk_check
    )";
    //,'$jerk_check'
    //echo $query;
    $insert = pdo_query($query);
		if (pdo_error() != "")
			{ ?>
			<br><p><center><b>There was a MySQL Error -- <?php echo pdo_error() ?></b></center></p>
			<?php
			//showfooter();
			exit;
			}
		?>
		<div class="alert alert-dismissable alert-success">
		  <button type="button" class="close" data-dismiss="alert">×</button>
		  <strong>Well done!</strong> You successfully posted -> <?php
		  echo '<a href="comment_threads.php?postID='. $jerk_check . '" class="alert-link">
		  Click here to view your new message</a>.';
//echo "<meta http-equiv='refresh' content='"."comment_threads.php?postID=". $jerk_check."'>";
		  ?>
		</div>
		<?php
		$comment_added=true;
		}

}
//
if($TempAdminLogin)
	{
echo '<BR><button data-toggle="collapse" data-target="#demo5" class="btn btn-info">Comments Admin</button>';
echo '<div id="demo5" class="collapse">';
		echo "<br>table=".$table;
		echo "<br>token_test=".$token_test;
		echo "<br>array_dfilename=".$the_dfilename;
		echo "<br>dfilename=".$dfilename;
		echo "<br>comments_array[dfilename]=".$comments_array["dfilename"];
		echo "<br>_SERVER['REQUEST_URI']=".$_SERVER['REQUEST_URI'];
		echo "<br>message_title=",$message_title;
		echo "<br>";
		var_dump($comments_array);
		echo "<br>";
echo '</div>';


	}
if($comment_added!=true){
?>
<form class="form-horizontal" id="j-forms" noauthenticate method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

        <!-- start token -->
        <div class="token">
          <?php
          $token = NoCSRF::generate( 'csrf_token' );
          echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
          ?>
        </div>
        <!-- end token -->


		<!-- start hidden -->
		<input type = "hidden" name="dfilename" value="<?php echo $comments_array["dfilename"]; ?>"  />
		<input type = "hidden" name="post_id" value="<?php echo $comments_array["id"]; ?>"  />
		<input type = "hidden" name="parentid" value="<?php echo $comments_array["my_parent"]; ?>"  />
		<!-- end hidden -->

  <fieldset>
    <legend><?php echo $message_title; ?></legend>
    <div class="form-group">
      <label for="inputName" class="col-lg-2 control-label">Username <b style="color: red;">*</b></label>
      <div class="col-lg-10">
      	<?php
        echo '<input type="text" name="name" value="'.$post_name.'" class="form-control" id="inputName" placeholder="Username" autocomplete="off" style=" background-size: 16px 18px; background-position: 98% 50%;">';
        ?>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Email <b style="color: red;">*</b></label>
      <div class="col-lg-10">
      	<?php
        echo '<input type="text" name="email" value="'.$post_email.'" class="form-control" id="inputEmail" placeholder="Email" autocomplete="off" style=" background-size: 16px 18px; background-position: 98% 50%;">';
        ?>
      </div>
    </div>
    <div class="form-group">
      <label for="inputLocation" class="col-lg-2 control-label">Location <b style="color: red;">*</b></label>
      <div class="col-lg-10">
      	<?php
        echo '<input type="text" name="location" value="'.$post_location.'" class="form-control" id="inputLocation" placeholder="Location" autocomplete="off" style=" background-size: 16px 18px; background-position: 98% 50%;">';
        ?>
      </div>
    </div>




    <div class="form-group">
      <label for="inputTopic" class="col-lg-2 control-label">Topic <b style="color: red;">*</b></label>
         <div class="col-lg-10">
      	<?php
        echo '<input type="text" name="topic" value="'.$post_topic.'" class="form-control" id="inputTopic" placeholder="Topic" autocomplete="off" style=" background-size: 16px 18px; background-position: 98% 50%;">';
        ?>
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Textarea <b style="color: red;">*</b>
      	<br><small>min25 max2000</small>
      </label>
      <div class="col-lg-10">
<?php
echo '<textarea name="comments" class="form-control" rows="3" id="textArea">'.$post_comments.'</textarea>';
?>
        <span class="help-block"><b style="color: red;">*</b> Denotes Required.</span>
      </div>
    </div>

    <div class="form-group">
      <label for="inputUrl" class="col-lg-2 control-label">URL </label>
         <div class="col-lg-10">
      	<?php
        echo '<input type="text" name="url" value="'.$post_url.'" class="form-control" id="inputUrl" placeholder="Enter Your Website" >';
        ?>
      </div>
    </div>


    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button class="btn btn-default" >Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>

    </div>
  </fieldset>
</form>
<?php
}
?>
