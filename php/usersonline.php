<?php

/**********************************
 https://www.php-guestbook.com
***********************************
***********************************/

class OnlineUsers {
  protected $connect;

  var $numberOfUsers = 0;
  //5mins till autodelete with cron refresh()
  //60secs X 5 = 300
  var $timeoutSeconds = 300;
  var $autodelete = true;
	var $HTTP_REFERER	= "";
	var $REQUEST_METHOD	= "";
	var $HTTP_HOST	= "";
	var $QUERY_STRING = "";
	var $SERVER_PROTOCOL = "";
	var $file	= "";
	var $ip	= "";
	var $sess_id = "";
	var $timestamp = "";



    public function settimestamp(){
    	//$this->timestamp=time();
        return time();
    }
    public function setsess_id($text){
        $this->sess_id=$text;
    }

    public function setfile(){
        return $this->getit($_SERVER,'SCRIPT_NAME');
    }
    public function setSERVER_PROTOCOL(){
        return $this->getit($_SERVER,'SERVER_PROTOCOL');
    }
    public function setQUERY_STRING(){
        return $this->getit($_SERVER,'QUERY_STRING');
    }
    public function setHTTP_HOST(){
    	return $this->getit($_SERVER,'HTTP_HOST');
    }
    public function setREQUEST_METHOD(){
        return $this->getit($_SERVER,'REQUEST_METHOD');
    }
    public function setHTTP_REFERER(){
        return $this->getit($_SERVER,'HTTP_REFERER');
    }
    public function setIP(){
    	return $this->getIP();
    }

    function setnumberOfUsers() {
		$this->numberOfUsers = $this->connect->query('select count(*) from usersonline')->fetchColumn();
    }

    public function printNumber() {
        if($this->numberOfUsers == 1) {
            return $this->numberOfUsers. " User";
        } else {
            return $this->numberOfUsers. " Users";
        }
    }


	public function getit($Requested_Array=array(),$key='',$length=250,$defaut=false){
	    //Get or Post or Request or cookie, any Array, etc
		  $temp=(isset($Requested_Array[$key])) ? strip_tags(trim($Requested_Array[$key])) : $defaut;
	    $temp=htmlspecialchars($temp, ENT_QUOTES, 'UTF-8');
	    $temp=substr($temp, 0, $length);
	    return $temp;
	  }

	public function getit_raw($Requested_Array=array(),$key=''){
	    //Get or Post or Request or cookie, any Array, etc
	    $temp=(isset($Requested_Array[$key])) ? trim($Requested_Array[$key]) : false;
	    return $temp;
	  }

	public function getIP(){
	    if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
	        return $_SERVER["REMOTE_ADDR"];
        }
	    return "0.0.0.0";
	}

	public function connect()
    {
		try {
      ######################################################################
      # Database settings
      ######################################################################
      $Path_to_guestbook_php=$_SERVER['DOCUMENT_ROOT'].'/php-guestbook/php/';
      $settings = include($Path_to_guestbook_php."/dbconfig.php");
      $DB_HOST = 'mysql:host='.$settings["host"];
      $DB_USER = $settings["username"];
      $DB_PASS = $settings["password"];
      $DB_DB = ';dbname='.$settings["dbname"];

$this->connect = new PDO($DB_HOST.$DB_DB,$DB_USER, $DB_PASS);
		     $this->connect->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		     # $connect->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );
		     # $connect->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

/**
//Do your works here..or ?
$statement=$connection->prepare($sql);
if you are using errorInfo use after prepare statement before execute.here in this method i am not using it.
print_r($statement->errorInfo());
$statement->execute();
}
catch(PDOException $e) {
              this will echo error code with detail
              example: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'nasme' in 'field list'
              echo $e->getMessage();
            }
$statement=null;
**/

		}
		catch(PDOException $e) {
		     //echo $e->getMessage();
		     file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
		}
	}


    protected function query($stm, $values = array())
    {
        $query = $this->connect->prepare($stm);
        $query->execute($values);
      	return $query;
    }

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->connect();
        $this->sess_id = session_id();
        $this->ip 	   = $this->setIP();
        $this->setnumberOfUsers();
        $this->file	   = $this->setfile() . '?' .$this->setQUERY_STRING();
        $this->timestamp 	   = $this->settimestamp();
    		$this->HTTP_HOST 		= $this->setHTTP_HOST();
    		$this->HTTP_REFERER     = $this->setHTTP_REFERER();
    		$this->REQUEST_METHOD 	= $this->setREQUEST_METHOD();
        $this->init();
    }

    public function init()
    {
        if (isset($_GET['logout'])) {
            //$this->logout();
        }
    }

    public function addDB()
    {
		$stmt = $this->connect->prepare("insert into usersonline (`timestamp`,  `ip`, `file`, `HTTP_HOST`, `sess_id`, `HTTP_REFERER`, `REQUEST_METHOD` ) values (:timestamp, :ip, :file, :HTTP_HOST, :sess_id, :HTTP_REFERER, :REQUEST_METHOD )");
		$stmt->bindParam(':timestamp', $this->timestamp, PDO::PARAM_STR, 64);
		$stmt->bindParam(':ip', $this->ip, PDO::PARAM_STR, 64);
		$stmt->bindParam(':file', $this->file, PDO::PARAM_STR, 64);
		$stmt->bindParam(':HTTP_HOST', $this->HTTP_HOST, PDO::PARAM_STR, 64);
		$stmt->bindParam(':sess_id', $this->sess_id, PDO::PARAM_STR, 64);
		$stmt->bindParam(':HTTP_REFERER', $this->HTTP_REFERER, PDO::PARAM_STR, 64);
		$stmt->bindParam(':REQUEST_METHOD', $this->REQUEST_METHOD, PDO::PARAM_STR, 64);
		$executed = $stmt->execute();
		//$lastId = $stmt->lastInsertId();
		if($executed){
		   //Successfull to database!';
		}else{
    //There was a problem saving to database!>';
    //file_put_contents('PDOErrors.txt', $stmt->errorInfo(), FILE_APPEND);
		}
	}
}
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
///
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
$ol = new OnlineUsers();
$ol->addDB();
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
///
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
//    $users=$ol->printNumber();
//    $totalusers=''.$users.' online';
//    echo ''.$totalusers.'';
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
///
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
//echo "<hr>";
//echo $ol->setIP();
?>
