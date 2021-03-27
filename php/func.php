<?php
############################################################################
#
#
#
############################################################################
#######################################
#
#######################################
if (!function_exists('getit'))
  {
  function getit($Requested_Array=array(),$key='',$length=254,$defaut=false){
    //Get or Post or Request or cookie, any Array, etc
    $temp="";
    $temp=(isset($Requested_Array[$key])) ? strip_tags(trim($Requested_Array[$key])) : $defaut;
    $temp=htmlspecialchars($temp, ENT_QUOTES, 'UTF-8');
    $temp=substr($temp, 0, $length);
    return $temp;
  }
}
if (!function_exists('getit_raw'))
  {
  function getit_raw($Requested_Array=array(),$key=''){
    //Get or Post or Request or cookie, any Array, etc
    $temp="";
    $temp=(isset($Requested_Array[$key])) ? trim($Requested_Array[$key]) : false;
    return $temp;
  }
}
#######################################
#
#######################################
if (!function_exists('flipflop'))
  {
  function flipflop($a=true,$b=false,$var=false)
  {
    if($var==$b){return $a;}
    elseif($var==$a){return $b;}
    else{return $var;}
  }
}
#######################################
#
#######################################
if (!function_exists('getIP'))
  {
  function getIP(){
     if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            return $_SERVER["REMOTE_ADDR"];
        }
        return "0.0.0.0";
  }
}


#######################################
#
#######################################

if (!function_exists('inspect'))
  {
  function inspect($str) {
  if($str==""){return false;}

      $hack = false;

      // Declare possible Scripts
      $script = array(
        '<'
        ,'&lt;'
        ,'&le;'
        ,'url='
        ,'url ='
        ,'viagra'
      );

      foreach($script as $s) {
        if(preg_match("/$s/i", $str)) {
          $hack = '[SCRIPT]'.$hack;
          break;
        }
      }

      // return false or hack string type?
      return $hack;



  }
}
#######################################
#
#######################################

if (!function_exists('RandomToken'))
  {
function RandomToken($length = 32){
    if(!isset($length) || intval($length) <= 8 ){
      $length = 32;
    }
    if (function_exists('random_bytes')) {
        return bin2hex(random_bytes($length));
    }
    if (function_exists('mcrypt_create_iv')) {
        return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
    }
    if (function_exists('openssl_random_pseudo_bytes')) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
}
}
#######################################
#
#######################################

if (!function_exists('Salt'))
  {
function Salt(){
    return substr(strtr(base64_encode(hex2bin(RandomToken(32))), '+', '.'), 0, 44);
}
}
############################################################################
#
#
#
############################################################################
#######################################
#
#######################################
function cheat_time($datestart=1){
//$datestart = strtotime('2018-12-10');//you can change it to your timestamp;
$dateend = strtotime('2019-12-31');//you can change it to your timestamp;
$dateend = time();
$int= mt_rand($datestart,$dateend);
$tmp=date("l, F j Y  g:i a",$int);
return $tmp;
}



function all_comments_threads2w($table="COMMENTS", $LIMIT=false,$get_dfilename=false)
{
if($get_dfilename){$get_dfilename=" WHERE dfilename='$get_dfilename' "; }
if($LIMIT){$LIMIT=" LIMIT $LIMIT "; }
$topic_query = pdo_query("SELECT * FROM $table $get_dfilename ORDER BY timestamp DESC $LIMIT");
if($topic_query == FALSE){return "error";}
echo "<BLOCKQUOTE><ul>";
while($topic = pdo_fetch_array($topic_query))
 {
 if($topic['my_parent'] == 0)
    {
    parent2w($topic['id'],$table) ;
     }
  }
echo "</ul></BLOCKQUOTE>";
}

#######################################
#
#######################################

function parent2w($postID,$table="COMMENTS")
  {
  if($postID == 0){return;}
  $post_with_threads_query = pdo_query("SELECT * FROM $table WHERE id='$postID'");
if($post_with_threads_query == FALSE){return;}
  while ($post_with_threads = pdo_fetch_array($post_with_threads_query))
    {
    $theparentid=$postID;
    echo "<li>";
    $dfilename = $post_with_threads['dfilename'];
echo '<a href="comment_threads.php?postID='
. $post_with_threads['id']
. '" title="TOPIC AREA:' . $dfilename . '" >';
    if($post_with_threads['topic'] == "")
    {echo "No Subject Given";}
    print(htmlspecialchars(stripslashes($post_with_threads['topic'])));
    echo "</a>";
    echo "&nbsp;&nbsp;";
if($post_with_threads['name'] == "")
{$tempname = "Anonymous";}
else
{$tempname = htmlspecialchars(stripslashes($post_with_threads['name']));}
    echo "<b>";
    echo $tempname;
    echo "</b>&nbsp;";

    print(cheat_time($post_with_threads['timestamp']));
    echo "<BR>";

    /* child_posts2 function looks for children for the current post, the children of these children and so on by calling itself as soon as there are children posts found. */
    child2w($theparentid,$table);

    /* value in my_parent field of the current post */
    $my_parent_column_value=$post_with_threads['my_parent'];

    /* the returned value will be equal to the ID of the post which is the parent of the current post */
    return $my_parent_column_value;
    }

  }

#######################################
#
#######################################

function child2w($theparentid,$table="COMMENTS")
  {
if($theparentid == 0){return;}
  $child_posts2_query = pdo_query("SELECT * FROM $table WHERE my_parent='$theparentid' ORDER BY timestamp");
if($child_posts2_query == FALSE){return;}
  static $whitespaces="";
  static $i;
  $i++;
  while($child_posts2 = pdo_fetch_array($child_posts2_query))
    {
    echo "<UL><LI>";
echo '<a href="comment_threads.php?postID='
. $child_posts2['id']
. '&parentid='
. $child_posts2['my_parent']
. '" >';
print(htmlspecialchars(stripslashes($child_posts2['topic'])) . "</a> by ");

echo "&nbsp;&nbsp;";
if($child_posts2['name'] == "")
{$tempname = "Anonymous";}
else
{$tempname = htmlspecialchars(stripslashes($child_posts2['name']));}

echo "<b>";
echo $tempname;
echo "</b>&nbsp;";

print(cheat_time($child_posts2['timestamp']));
echo "<BR>";

      $theparentid=$child_posts2['id'];
      child2w($theparentid,$table);
      echo "</UL>";
    }
  }
#######################################
#
#######################################

if (!function_exists('get_comment_field'))
  {
  function get_comment_field($postID,$field='topic')
    {
    $post_with_threads_query = pdo_query("SELECT * FROM comments WHERE id='$postID'");
    if($post_with_threads_query == FALSE){return;}
    //echo var_dump($post_with_threads_query);
   /* while the pdo_query returned something (and this will always be one row, as ID is unique),
    get the information as a set of field values in the $post_with_threads array */
    while ($post_with_threads = pdo_fetch_array($post_with_threads_query))
        {
        return htmlspecialchars(stripslashes($post_with_threads[$field]));
        }
    }
}
#######################################
#
#######################################

if (!function_exists('display_post_comment_threads'))
  {//display_post_comment_threads($postID);
function display_post_comment_threads($postID)
  {
  global $dfilename;
  if(!$postID){return false;}
  $post_with_threads_query = pdo_query("SELECT * FROM comments WHERE ID='$postID'");
if($post_with_threads_query == FALSE){return;}

  /* while the pdo_query returned something (and this will always be one row, as ID is unique),
  get the information as a set of field values in the $post_with_threads array */

  while ($post_with_threads = pdo_fetch_array($post_with_threads_query))
    {

    /* any immediate children of the current post will have their my_parent value equal to $theparentid */

    $theparentid=$postID;

    // retrieving the necessary values from our array and putting them in the right places.
    // Along with that we strip slashes off the contents (remember we added slashes before
    //we inserted the information into the database?). Also, all HTML code which was input
    //by a user must not be treated as HTML code, otherwise it would be possible to execute
    //scripts by having them between <SCRIPT> and </SCRIPT> tagsor do other nasty things.
    //PHP function htmlspecialchars() makes HTML tags look like plain text to the browser.
    //There is one more useful PHP function used here, nl2br(). It converts all newline
    //characters into HTML <BR> tags so that the browser preserves the layout of the
    //message with all its new lines and breaks. Otherwise after the message is retrieved
    //from the MySQL database all newlines will be treated as white spaces
    //(at least this is what I experienced).
  //print( "<center><FONT SIZE=\"-1\" FACE=\"arial,helv,helvetica\">" );

  $dfilename = htmlspecialchars(stripslashes($post_with_threads['dfilename']));
//  echo "NEW COMMENT AREA: " . $dfilename;
  print( "<h1>" );
  echo htmlspecialchars(stripslashes($post_with_threads['topic']));
  print( "</h1>" );

  if($post_with_threads['my_parent'] == 0)
  {
  $dfilename = $dfilename . "thread";
  }

  print( "<br>" );
  print("&nbsp;&nbsp;Posted by <b>");
  print(htmlspecialchars(stripslashes($post_with_threads['name'])) . "</b> ");
//  print("<A HREF=mailto:" . htmlspecialchars(stripslashes($post_with_threads['email'])) . ">" . htmlspecialchars(stripslashes($post_with_threads['name'])) . "</A></b> ");
  print("on " . cheat_time($post_with_threads['timestamp']) ."<P>" );


  print( "<div class=\"content\">" );

    $post_with =  htmlspecialchars(stripslashes($post_with_threads['comments']));
    $post_with =  nl2br($post_with);
    //$post_with = converttext($post_with);
    print($post_with . "</div><BR><BR>");
    print( "<HR WIDTH=\"75%\">" );

    print("&nbsp;&nbsp;Current thread:<BR><BR>");

    /* child_posts function looks for children for the current post, the children of these children and so on by calling itself as soon as there are children posts found. */

    display_child_comment_posts($theparentid);

    /* value in my_parent field of the current post */

    $my_parent_column_value=$post_with_threads['my_parent'];

    /* the returned value will be equal to the ID of the post which is the parent of the current post */

    return $my_parent_column_value;
    }

  }
}
#######################################
#
#######################################

if (!function_exists('display_child_comment_posts_parables'))
  {
function display_child_comment_posts($theparentid)
  {
  //echo $theparentid;
  if(!$theparentid){return false;}
  $child_posts_query = pdo_query("SELECT * FROM comments WHERE my_parent='$theparentid' ORDER BY timestamp");
if($child_posts_query == FALSE){return;}
  /* adding a couple of whitespaces before the title of a child post is one of the ways to add a visible "ladder", or "tree" structure for displaying parent-child relationships in the browser. We need to make it static so that the function "remembers" all iterations the $whitespaces variable will have. */
  static $whitespaces="";

  /* we need static variable $i to ensure that the "Currently there are no responces to this post" is displayed _only_ in case there are no children of the current post. When there are children, the variable is iterated and the message never appears. You may take it away from the function and see what happens */
  static $i;

  /* if there are no children posts found in the database */

  if(!pdo_num_rows($child_posts_query) and $i==0)
    {
    print( "<FONT SIZE=\"-1\" FACE=\"arial,helv,helvetica\">" );
    echo("<CENTER>Currently there are no responces to this post.</CENTER></font>");
    }

  $i++;

  /* while there are children, go row by row creating $child_posts array. */

  while($child_posts = pdo_fetch_array($child_posts_query))
    {

      /* print necessary amount of whitespaces, then print the topic as a link to the post */
      print($whitespaces . "<A HREF=comment_threads.php?postID=" . $child_posts['id'] . "&parentid=" . $child_posts['my_parent'] . ">");
      print(htmlspecialchars(stripslashes($child_posts['topic'])) . "</A><BR>");

       /* let the function give itself the ID of the current post when looking for children posts for the current post. Calling itself continues until there are children, otherwise the nested while-loops exit one by one. Finally, no more loops are entered since all children have been found and the function exits. */

      $theparentid=$child_posts['id'];
      $whitespaces = "&nbsp;&nbsp;" . $whitespaces; // add whitespaces for the next nested loop
      display_child_comment_posts($theparentid);
    }

  /* when the inner while loop exits, it means that there will be no more children for some particular post and we need to add two whitespaces so that it shows that we returned one level up the hierarchy */
  $whitespaces = substr_replace($whitespaces, "", -12);//when a while-loop exits, need to return two whitespaces up one level
  }
}



#######################################
#
#######################################


if (!function_exists('display_all_comments_threads'))
  {
  function display_all_comments_threads($dfilename)
  {

  if($dfilename == "*")
    {
    $topic_query = pdo_query("SELECT * FROM comments WHERE dfilename !='mysqlprayerrequest' ORDER BY id DESC WHERE my_parent='0' ");
    }
  else
    {
    $topic_query = pdo_query("SELECT * FROM comments WHERE dfilename = '$dfilename' ORDER BY id DESC");
    }
  if($topic_query == FALSE){return;}
  echo "<BLOCKQUOTE><ul>";
  while($topic = pdo_fetch_array($topic_query))
   {
   if($topic['my_parent'] == 0)
      {
      print( "<FONT SIZE=\"-1\" FACE=\"arial,helv,helvetica\">\n" );
      parent($topic['id']) ;
      print( "</FONT>\n" );
       }
    }
  echo "</ul></BLOCKQUOTE>";
  }
}
#######################################
#
#######################################

if (!function_exists('parent'))
  {
function parent($postID)
  {

  $post_with_threads_query = pdo_query("SELECT * FROM comments WHERE id='$postID'");
  if($post_with_threads_query == FALSE){return;}
  while ($post_with_threads = pdo_fetch_array($post_with_threads_query))
    {
    $theparentid=$postID;
    echo "<li>";
    $dfilename = $post_with_threads['dfilename'];
    echo "<A HREF=\"comment_threads.php?postID=" . $post_with_threads['id'] . "\" title=\"TOPIC AREA: " . $dfilename . "\">";
    if($post_with_threads['topic'] == "")
    {echo "No Subject Given";}
    print(htmlspecialchars(stripslashes($post_with_threads['topic'])));
    echo "</a>";
    echo "&nbsp;&nbsp;";
if($post_with_threads['name'] == "")
{$tempname = "Anonymous";}
else
{$tempname = htmlspecialchars(stripslashes($post_with_threads['name']));}
    echo "<b>";
//    echo "<A HREF=\"mailto:" . htmlspecialchars(stripslashes($post_with_threads['email'])) . "\">" ;
    echo $tempname;
//    echo "</A>";
    echo "</b>&nbsp;";

    print(cheat_time($post_with_threads['timestamp']));
    echo "<BR>";

    /* child_posts2 function looks for children for the current post, the children of these children and so on by calling itself as soon as there are children posts found. */
    child($theparentid);

    /* value in my_parent field of the current post */
    $my_parent_column_value=$post_with_threads['my_parent'];

    /* the returned value will be equal to the ID of the post which is the parent of the current post */
    return $my_parent_column_value;
    }

  }
}
#######################################
#
#######################################

if (!function_exists('child'))
  {
function child($theparentid)
  {
if($theparentid == 0){return;}
  $child_posts2_query = pdo_query("SELECT * FROM comments WHERE my_parent='$theparentid' ORDER BY timestamp");
if($child_posts2_query == FALSE){return;}
  static $whitespaces="";
  static $i;
  $i++;
  while($child_posts2 = pdo_fetch_array($child_posts2_query))
    {
    echo "<UL><LI>";
    echo "<A HREF=comment_threads.php?postID=" . $child_posts2['id'] . "&parentid=" . $child_posts2['my_parent'] . ">";
    print(htmlspecialchars(stripslashes($child_posts2['topic'])) . "</A> by ");
    echo "&nbsp;&nbsp;";
if($child_posts2['name'] == "")
{$tempname = "Anonymous";}
else
{$tempname = htmlspecialchars(stripslashes($child_posts2['name']));}

    echo "<b>";
//    echo "<A HREF=\"mailto:" . htmlspecialchars(stripslashes($child_posts2['email'])) . "\">" ;
    echo $tempname;
//    echo "</A>";
    echo "</b>&nbsp;";

    print(cheat_time($child_posts2['timestamp']));
    //echo "<b>". $child_posts2['dfilename'] . "</b><BR>";
    echo "<BR>";
      $theparentid=$child_posts2['id'];
      child($theparentid);
      echo "</UL>";
    }
  }

}
#######################################
#
#######################################
if (!function_exists('mb_ord')) {
    function mb_ord($char, $encoding = 'UTF-8') {
        if ($encoding === 'UCS-4BE') {
            list(, $ord) = (strlen($char) === 4) ? @unpack('N', $char) : @unpack('n', $char);
            return $ord;
        } else {
            return mb_ord(mb_convert_encoding($char, 'UCS-4BE', $encoding), 'UCS-4BE');
        }
    }
}
?>
