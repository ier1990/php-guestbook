<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Theme Preview - Usebootstrap.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../php-guestbook/theme/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="../../php-guestbook/theme/css/usebootstrap.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="bootstrap/html5shiv.js"></script>
      <script src="bootstrap/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<?PHP

//are-pdo-prepared-statements-sufficient-to-prevent-sql-injection
//https://stackoverflow.com/questions/134099/are-pdo-prepared-statements-sufficient-to-prevent-sql-injection
//$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
try {
     $myServer = "localhost";
     $myUser   = "phpguestbook";
     $myPass   = "1234";
     $myDB	 = "thephpguestbook";
     $dbh = new PDO("mysql:host=$myServer;dbname=$myDB", $myUser, $myPass);
     $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
     # $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );
     # $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
}
catch(PDOException $e) {
     echo $e->getMessage();
     # file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}

$dfilename="demo";

if (isset($dfilename)) {
     $stmt = $dbh->prepare('SELECT * FROM forum WHERE `dfilename` = :dfilename');
     $stmt->bindParam('dfilename', $dfilename, PDO::PARAM_STR, 64);
     $stmt->execute();
echo '<table class="table table-striped table-hover ">';
echo '<thead><tr class="info">';
          echo "<th>dfilename</th>";
          echo "<th>ip</th>";
          echo "<th>name</th>";
          echo "<th>email</th>";
          echo "<th>location</th>";
          echo "<th>topic</th>";
          echo "<th>comments</th>";
          echo "<th>my_parent</th>";
          echo "<th>timestamp</th>";
          echo "<th>url</th>";
          echo "<th>viewable</th>";
          echo "<th>rating</th>";
          echo "<th>views</th>";
          echo "<th>id</th>";
echo '</tr></thead>';

echo '<tbody>';
     while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
echo "<tr>";
          echo "<td>".$row['dfilename']."</td>";
          echo "<td>".$row['ip']."</td>";
          echo "<td>".$row['name']."</td>";
          echo "<td>".$row['email']."</td>";
          echo "<td>".$row['location']."</td>";
          echo "<td>".$row['topic']."</td>";
          echo "<td>".$row['comments']."</td>";
          echo "<td>".$row['my_parent']."</td>";
          echo "<td>".$row['timestamp']."</td>";
          echo "<td>".$row['url']."</td>";
          echo "<td>".$row['viewable']."</td>";
          echo "<td>".$row['rating']."</td>";
          echo "<td>".$row['views']."</td>";
          echo "<td>".$row['id']."</td>";
echo "</tr>";
echo '<thead><tr class="info">';
          echo "<th>dfilename</th>";
          echo "<th>ip</th>";
          echo "<th>name</th>";
          echo "<th>email</th>";
          echo "<th>location</th>";
          echo "<th>topic</th>";
          echo "<th>comments</th>";
          echo "<th>my_parent</th>";
          echo "<th>timestamp</th>";
          echo "<th>url</th>";
          echo "<th>viewable</th>";
          echo "<th>rating</th>";
          echo "<th>views</th>";
          echo "<th>id</th>";
echo '</tr></thead>';


     }//end while
echo '</tbody></table>';
     $stmt = null;
     }//end isset

     echo "<pre>";
     var_dump($row);
     echo "</pre>";

?>
</div>


<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="../../php-guestbook/theme/bootstrap/bootstrap.min.js"></script>
<script src="../../php-guestbook/theme/bootstrap/usebootstrap.js"></script>
</body>
</html>
<?php
     exit;




//////////////////////////////////////////////////
//////////////////////////////////////////////////
/////////////////

















$dfilename="demo";
if (isset($dfilename)) {
     $forum=array();
     $stmt = $dbh->prepare('SELECT * FROM forum WHERE `dfilename` = :dfilename');
     $stmt->bindParam('dfilename', $dfilename, PDO::PARAM_STR, 64);
     $stmt->execute();
     $row = $stmt->fetch(PDO::FETCH_BOTH);
     $stmt = null;
          $forum[$row['dfilename']]['dfilename'] = $row['dfilename'];
          $forum[$row['dfilename']]['ip'] = $row['ip'];
          $forum[$row['dfilename']]['name'] = $row['name'];
          $forum[$row['dfilename']]['email'] = $row['email'];
          $forum[$row['dfilename']]['location'] = $row['location'];
          $forum[$row['dfilename']]['topic'] = $row['topic'];
          $forum[$row['dfilename']]['comments'] = $row['comments'];
          $forum[$row['dfilename']]['my_parent'] = $row['my_parent'];
          $forum[$row['dfilename']]['timestamp'] = $row['timestamp'];
          $forum[$row['dfilename']]['url'] = $row['url'];
          $forum[$row['dfilename']]['viewable'] = $row['viewable'];
          $forum[$row['dfilename']]['rating'] = $row['rating'];
          $forum[$row['dfilename']]['views'] = $row['views'];
          $forum[$row['dfilename']]['id'] = $row['id'];
     }//end isset
     echo "<pre>";
     var_dump($forum);
     echo "</pre>";
     exit;




//////////////////////////////////////////////////
//////////////////////////////////////////////////
/////////////////
$dfilename="demo";
if (isset($dfilename)) {
     $stmt = $dbh->prepare('SELECT * FROM forum WHERE `dfilename` = :dfilename');
     $stmt->bindParam('dfilename', $dfilename, PDO::PARAM_STR, 64);
     $stmt->execute();
     $row = $stmt->fetch(PDO::FETCH_BOTH);
     $stmt = null;
          $dfilename = $row['dfilename'];
          $ip = $row['ip'];
          $name = $row['name'];
          $email = $row['email'];
          $location = $row['location'];
          $topic = $row['topic'];
          $comments = $row['comments'];
          $my_parent = $row['my_parent'];
          $timestamp = $row['timestamp'];
          $url = $row['url'];
          $viewable = $row['viewable'];
          $rating = $row['rating'];
          $views = $row['views'];
          $id = $row['id'];
     }//end isset
echo "<pre>";
var_dump($row);
echo "</pre>";
exit;

//////////////////////////////////////////////////
//////////////////////////////////////////////////
/////////////////
if (isset($_POST['dfilename'])) {
     $stmt = $dbh->prepare('SELECT * FROM forum WHERE `dfilename` = :dfilename');
     $stmt->bindParam('dfilename', $_POST['dfilename'], PDO::PARAM_STR, 64);
     $stmt->execute();
     $row = $stmt->fetch(PDO::FETCH_BOTH);
     $stmt = null;
          $dfilename = $row['dfilename'];
          $ip = $row['ip'];
          $name = $row['name'];
          $email = $row['email'];
          $location = $row['location'];
          $topic = $row['topic'];
          $comments = $row['comments'];
          $my_parent = $row['my_parent'];
          $timestamp = $row['timestamp'];
          $url = $row['url'];
          $viewable = $row['viewable'];
          $rating = $row['rating'];
          $views = $row['views'];
          $id = $row['id'];
     }//end isset

     var_dump($row);
     exit;

     //////////////////////////////////////////////////
     //////////////////////////////////////////////////
     /////////////////

if (isset($_POST['id'])) {
     $stmt = $dbh->prepare('SELECT * FROM forum WHERE `id` = :id');
     $stmt->bindParam('id', $_POST['id'], PDO::PARAM_STR, 64);
     $stmt->execute();
     $row = $stmt->fetch(PDO::FETCH_BOTH);
     $stmt = null;
          $dfilename = $row['dfilename'];
          $ip = $row['ip'];
          $name = $row['name'];
          $email = $row['email'];
          $location = $row['location'];
          $topic = $row['topic'];
          $comments = $row['comments'];
          $my_parent = $row['my_parent'];
          $timestamp = $row['timestamp'];
          $url = $row['url'];
          $viewable = $row['viewable'];
          $rating = $row['rating'];
          $views = $row['views'];
          $id = $row['id'];
}

var_dump($row);
exit;


//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////

$stmt = $dbh->prepare("insert into forum (
   `dfilename`,
   `ip`,
   `name`,
   `email`,
   `location`,
   `topic`,
   `comments`,
   `my_parent`,
   `timestamp`,
   `url`,
   `viewable`,
   `rating`,
   `views`,
   `id`
) values (
   :dfilename,
   :ip,
   :name,
   :email,
   :location,
   :topic,
   :comments,
   :my_parent,
   :timestamp,
   :url,
   :viewable,
   :rating,
   :views,
   :id
)");
   $stmt->bindParam(':dfilename', $_POST['dfilename'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':ip', $_POST['ip'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':location', $_POST['location'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':topic', $_POST['topic'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':comments', $_POST['comments'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':my_parent', $_POST['my_parent'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':timestamp', $_POST['timestamp'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':url', $_POST['url'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':viewable', $_POST['viewable'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':rating', $_POST['rating'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':views', $_POST['views'], PDO::PARAM_STR, 64);
   $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_STR, 64);
$executed = $stmt->execute();
if($executed){
   $db_message = '<p class="db_success">Successfully saved <b>id : '.reverb($_POST['id']).'</b> to the database!!</p>';
}else{
   $db_message = '<p class="db_error">There was a problem saving <b>id : '.reverb($_POST['id']).'</b> to the database!!</p>';
}



exit;
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////


//$id = $dbh->quote($_POST['id']);
//$id = $_POST['id'];
$stmt = $dbh->prepare('DELETE FROM forum WHERE `id` = :id');
$stmt->bindParam('id', $id, PDO::PARAM_STR);
$executed = $stmt->execute();
if($executed){
   $db_message = '<p class="db_success">Successfully removed <b>id : '.reverb($_POST['id']).'</b> from the database!!</p>';
}else{
   $db_message = '<p class="db_error">There was a problem removing <b>id : '.reverb($_POST['id']).'</b> from the database!!</p>';
}

exit;
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////


?>
