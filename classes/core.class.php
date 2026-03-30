<?php
/**
 * Project:
 * @copyright 2019
 * @version 0.0.1
 */

class Core
{
    /**
  * Содержит текущий url адрес в виде  массива
  * @var array $url
    */
  var $url;
    public $ip;
    public $full_url;
    public $form;


  function __construct()
	{

      $this->ip();
      $this->_setURL();
      $this->form = $this->form();
    }

    public function setGet()
    {
      $full_url = $_SERVER['REQUEST_URI'];
      $return_arr = [];
      $url_arr = explode('?', $full_url);
      if (isset($url_arr[1])) {
        $get_params = explode('&', $url_arr[1]);
        foreach($get_params as $value) {
          $param = explode('=', $value);
          if (isset($param[1])) {
            $return_arr[$param[0]] = $param[1];
          } else {
            $return_arr[$param[0]] = '';
          }

        }
      }

      return $return_arr;
    }

    public function debuging($arg, $comment = 'debug')
    {
      global $debug_mode;
      if ($debug_mode) {
        echo $comment . ' = ';
        var_dump($arg);
        echo '<hr>';
      }
    }

    function _setURL()
  	{

       if(stristr($_SERVER['HTTP_HOST'], 'www.'))  {
         $this->redir('http://'.str_replace('www.', '', $_SERVER['HTTP_HOST']).$_SERVER['REQUEST_URI']);
       }

       $url = $this->_filterUrl($_SERVER['REQUEST_URI']);
  	   $url = substr($url, 1, strlen($url));

  	   $this->full_url = $url;
  	   $url = explode('/', $url);
       if($url){
  		   foreach($url as $url){
           $url = preg_replace("/\?.+/", "", $url);

           $this->url[] =   $this->filterAllowUrl($url);
         }
  	   }
  	}

    function filterAllowUrl($url)
  	{
      $allow_url = '';
      $allow = '?1234567890qwertyuiopasdfghjklzxcvbnm_-';
      for($i=0; $i<strlen($url); $i++){
        for($ii=0; $ii<strlen($allow); $ii++){
  	       if($url[$i] == $allow[$ii]) $allow_url .=  $url[$i];
        }
      }
      return $allow_url;
  	}

    function _filterUrl($url)
  	{
        $url = strtolower($url);
  	    $url = str_replace('"', '',  $url);
  	    $url = str_replace("'", '',  $url);
        $url = htmlspecialchars($url);
  	    return $url;
  	}

    public function redir($url  = ''){
	   if(!$url)  $url = $_SERVER['REQUEST_URI'];
	   header("HTTP/1.1 301 Moved Permanently");
     header("location: $url");
     exit;
    }

    public function jsredir($url = '../'){
     echo "<script>document.location.href='".$url."'</script>";
       exit;
    }

    public function form($form = ''){
      function array_map_recursive($callback, $value){
         if (is_array($value)) {
           return array_map(function($value) use ($callback) { return array_map_recursive($callback, $value); }, $value);
         }
         return $callback($value);
      }
		  if(!$form) $form = $_POST;

      if($form){
			$form = array_map_recursive('trim', $form);
            return $form;
        }
    }

    public function ip()
  	{
  	  $ip = $_SERVER['REMOTE_ADDR'];
  	  $this->ip  = $ip;
  	  return $ip;
  	}

    public function login()
    {
      if (isset($_SESSION['id']) && isset($_SESSION['login'])) {
        if (isset($_COOKIE['PHPSESSID'])) {
          if (isset($_COOKIE['login']) && $_COOKIE['PHPSESSID'] == session_id() && $_SESSION['login'] == $_COOKIE['login']) {
            $session_time = $this->cfgRead('session_time');
            $email = $_COOKIE['login'];
            setcookie('login', '', -1, '/cab');
            setcookie ("login", $email, time() + $session_time, '/cab');
            setcookie('login', '', -1, '/');
            setcookie ("login", $email, time() + $session_time, '/');
            return true;
          }
        } else {
          //session_destroy();
        }
      }
      return false;
    }


    public function writeLog($type, $text)
    {
      global $db;
      $sql = $db->parse("INSERT INTO `logs` SET `type` = ?s, text = ?s",$type,$text);
      var_dump($sql);
    	//$db->query($sql,$type,$text);
    }

    public function getip()
    {
      if(getenv("HTTP_CLIENT_IP")) {
    		$ip = getenv("HTTP_CLIENT_IP");
    	} elseif(getenv("HTTP_X_FORWARDED_FOR")) {
    		$ip = getenv("HTTP_X_FORWARDED_FOR");
    	} else {
    		$ip = getenv("REMOTE_ADDR");
    	}
      $ip = htmlspecialchars(substr($ip,0,15), ENT_QUOTES, '');
      return $ip;
    }

    public function as_md5($string, $key = null) {
	     $string = md5( $key . md5( 'Z&' . $key . 'x_V' . htmlspecialchars( $string, ENT_QUOTES, '' ) ) );
	     return $string;
   }

   public function cfgRead($cfgName)
   {
      global $db;
      $cfgValue = $db->getOne("SELECT `data` FROM `settings` WHERE `name` = ?s", $cfgName);
      return $cfgValue;
   }


   public function generator($case1, $case2, $case3, $case4, $num1)
   {
      $password = "";

    	$small="abcdefghijklmnopqrstuvwxyz";
    	$large="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    	$numbers="1234567890";
    	$symbols="~!#$%^&*()_+-=,./<>?|:;@";
    	mt_srand((double)microtime()*1000000);

    	for ($i=0; $i<$num1; $i++) {
    		$type = mt_rand(1,4);
    		switch ($type) {
    		case 1:
    			if ($case1 == "on") { $password .= $large[mt_rand(0,25)]; } else { $i--; }
    			break;
    		case 2:
    			if ($case2 == "on") { $password .= $small[mt_rand(0,25)]; } else { $i--; }
    			break;
    		case 3:
    			if ($case3 == "on") { $password .= $numbers[mt_rand(0,9)]; } else { $i--; }
    			break;
    		case 4:
    			if ($case4 == "on") { $password .= $symbols[mt_rand(0,24)]; } else { $i--; }
    			break;
    		}
    	}
	    return $password;
   }

   public function returnJson($arr)
   {
     if (isset($arr['error'])) {
       $response['status'] = "error";
       $response['error'] = $arr['error'];
	   if(isset($arr['error_field'])) {
		 $response['field'] = $arr['error_field'];  
	   }
	   //$response[''] = $arr['error'];
     } else {
       $response['status'] = "OK";
       $response['response'] = $arr['response'];
     }

     return json_encode($response);
   }

  public function ticketLog($ticket_id, $uder_id, $text, $photo = '')
  {
    global $db;
	
	//if ($photo = ' ') $photo = NULL;
    $db->query("INSERT INTO `tickets_log` SET `ticket_id` = ?i, `user_id` = ?i, `text` = ?s, attachments = ?s", $ticket_id, $uder_id, $text, $photo);
  }

  public function getTicketStatusInfo($id)
  {
    global $db;
    $status_info = $db->getRow("SELECT * FROM `tickets_statuses` WHERE `id` = ?i", $id);
    //var_dump($status_info);
    return $status_info;
  }

  public function setPageCookie($url, $get)
  {
    $page_cooke = $url[1];
    $i = 0;
    foreach ($get as $key => $value) {
      if ($i == 0) {
        $page_cooke .= '?';
      } else {
        $page_cooke .= '&';
      }
      $page_cooke .= $key . '=' . $value;
      $i++;
    }

    setcookie("page", $page_cooke);
  }

  public function getMonthName($month) {
    $month_names = [
      1 => 'Январь',
      2 => 'Февраль',
      3 => 'Март',
      4 => 'Апрель',
      5 => 'Май',
      6 => 'Июнь',
      7 => 'Июль',
      8 => 'Август',
      9 => 'Сентябрь',
      10 => 'Октябрь',
      11 => 'Ноябрь',
      12 => 'Декабрь',
    ];

    return $month_names[$month];
  }

  public function getFileIco($extention) {
    switch ($extention) {
    case 'mp3':
        $ico = '<i class="far fa-file-audio"></i>';
        break;
    case 'doc':
        $ico = '<i class="far fa-file-word"></i>';
        break;
    case 'docx':
        $ico = '<i class="far fa-file-word"></i>';
        break;
    case 'xls':
        $ico = '<i class="far fa-file-excel"></i>';
        break;
    case 'xlsx':
        $ico = '<i class="far fa-file-excel"></i>';
        break;
    case 'pdf':
        $ico = '<i class="far fa-file-pdf"></i>';
        break;
    default:
        $ico = '<i class="far fa-file"></i>';
        break;
      }
    return $ico;
  }

  public function hex2rgba($color, $opacity = false) {

  	$default = 'rgb(0,0,0)';

  	//Return default if no color provided
  	if(empty($color))
            return $default;

  	//Sanitize $color if "#" is provided
          if ($color[0] == '#' ) {
          	$color = substr( $color, 1 );
          }

          //Check if color has 6 or 3 characters and get values
          if (strlen($color) == 6) {
                  $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
          } elseif ( strlen( $color ) == 3 ) {
                  $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
          } else {
                  return $default;
          }

          //Convert hexadec to rgb
          $rgb =  array_map('hexdec', $hex);

          //Check if opacity is set(rgba or rgb)
          if($opacity){
          	if(abs($opacity) > 1)
          		$opacity = 1.0;
          	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
          } else {
          	$output = 'rgb('.implode(",",$rgb).')';
          }

          //Return rgb(a) color string
          return $output;
  }

  public function previousPurchase($nomenclature_id, $salon_id = NULL) {
    global $db;
    if ($salon_id) {
      $purchase = $db->getOne("SELECT tp.purchase FROM tickets_purchases tp WHERE tp.nomenclature_id = ?i AND tp.salon_id = ?i AND (SELECT status FROM tickets WHERE id = tp.ticket_id) = ?i ORDER BY id LIMIT 1", $nomenclature_id, $salon_id, 2);
    } else {
      $purchase = $db->getOne("SELECT tp.purchase FROM tickets_purchases tp WHERE tp.nomenclature_id = ?i AND (SELECT status FROM tickets WHERE id = tp.ticket_id) = ?i ORDER BY id LIMIT 1", $nomenclature_id, 2);
    }

    if ($purchase) {
      return $purchase;
    }
    return 0;
  }

  public function sendMyMail($subject, $text , $address = 'adolfovich@list.ru', $errors = 0)  {
    require_once('PHPM/src/Exception.php');
    require_once('PHPM/src/PHPMailer.php');
    require_once('PHPM/src/SMTP.php');

    try {
      $mail = new PHPMailer\PHPMailer\PHPMailer(true);
      $mail->isSMTP();
      $mail->CharSet = "utf-8";
      $mail->SMTPDebug = 0;
      $mail->Debugoutput = 'html';
      $mail->Host = $this->cfgRead('smtp_server');
      $mail->Port = $this->cfgRead('smtp_port');
      $mail->SMTPSecure = 'ssl';
      //$mail->SMTPSecure = 'tls';
      $mail->SMTPAuth = true;
      $mail->Username = $this->cfgRead('smtp_user');
      $mail->Password = $this->cfgRead('smtp_password');
      $mail->setFrom($this->cfgRead('smtp_user'), $this->cfgRead('salon_name')); 
      $mail->addAddress($address);
      $mail->Subject = $subject;
      $mail->Body    = $text;
      $mail->AltBody = $text;
      $mail->IsHTML(true);
      $mail->send();
      $error_send = 0;
    } catch (Exception $e) {
      $error_send = $mail->ErrorInfo;
      $this->writeLog('email', 'Ошибка отправки письма '.$mail->ErrorInfo.' на адрес '.$address);
    }
  }

  public function hashtags($string)  {
      $words = explode(' ', $string);
      $wordsWithHash = array_map(function($word) {
          return '<span class="keyword" onClick="changeLoadBase(\''.$word.'\')">#' . $word . '</span>';
      }, $words);
      return implode(' ', $wordsWithHash);
  }


}
