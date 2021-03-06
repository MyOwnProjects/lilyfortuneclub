<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('paginate'))
{
	function paginate($total, $current, $row_count){
		$d1 = floor($total / $row_count);
		$d2 = $total % $row_count;
		$last = $d2 > 0 ? $d1 + 1 : $d1;
		if($current == 'first'){
			$current = 1;
		}
		else if($current == 'last'){
			$current = $last;
		}
			
		if($current < 1){
			$current = 1;
		}
		else if($current > $last){
				$current = $last;
		}
		return array(
			'current' => $current,
			'last' => $last,
			'row_count' => $row_count,
			'total' => $total,
			'rows' => array()
		);
	}
}

if ( ! function_exists('encode'))
{
	function encode($origin){
		$len = strlen($origin);
		$md5 = md5($origin);
		$prefix = substr($md5, 0, $len);
		$postfix = substr($md5, $len);
		$p_origin = '';
		$ord_a = ord('a');
		$ord_z = ord('z');
		$ord_A = ord('A');
		$ord_Z = ord('Z');
		$ord_0 = ord('0');
		$ord_9 = ord('9');
		for($i = 0; $i < $len; ++$i){
			$c = $origin[$i];
			$ord_c = ord($c);
			if($ord_c >= $ord_a && $ord_c < $ord_z || $ord_c >= $ord_A && $ord_c < $ord_Z || $ord_c >= $ord_0 && $ord_c < $ord_9){
				$p_origin .= chr($ord_c + 1);
			}
			else if($c == 'z'){
				$p_origin .= 'a';
			}
			else if($c == 'Z'){
				$p_origin .= 'A';
			}
			else if($c == '9'){
				$p_origin .= '0';
			}
			else{
				$p_origin .= $c;
			}
		}
		return str_pad(sprintf('%x', $len), 2, '0', STR_PAD_LEFT).$prefix.$p_origin.$postfix;
	}
}

if ( ! function_exists('decode'))
{
	function decode($value){
		$len = hexdec(substr($value, 0, 2));
		if($len > 32){
			$p_origin = substr($value, 34);
		}
		else{
			$p_origin = substr($value, $len + 2, $len);
		}
		$ord_a = ord('a');
		$ord_z = ord('z');
		$ord_A = ord('A');
		$ord_Z = ord('Z');
		$ord_0 = ord('0');
		$ord_9 = ord('9');
		$origin = '';
		for($i = 0; $i < $len; ++$i){
			$c = $p_origin[$i];
			$ord_c = ord($c);
			if($ord_c > $ord_a && $ord_c <= $ord_z || $ord_c > $ord_A && $ord_c <= $ord_Z || $ord_c > $ord_0 && $ord_c <= $ord_9){
				$origin .= chr($ord_c - 1);
			}
			else if($c == 'a'){
				$origin .= 'z';
			}
			else if($c == 'A'){
				$origin .= 'Z';
			}
			else if($c == '0'){
				$origin .= '9';
			}
			else{
				$origin .= $c;
			}
		}
		return $origin;
	}
}

	
if ( ! function_exists('mime_type'))
{
	function mime_type($file_name){
		if(!file_exists($file_name)){
			return array('text', 'txt');
		}
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
		$mime_type_str = finfo_file($finfo, $file_name);
		finfo_close($finfo);
		if(strpos($mime_type_str, 'video/') === 0){
			return array('video', 'video');
		}
		if(strpos($mime_type_str, 'audio/') === 0){
			return array('audio', 'wav');
		}
		if(strpos($mime_type_str, 'image/') === 0){
			return array('image', 'jpg');
		}
		if(strpos($mime_type_str, 'pdf') !== false){
			return array('pdf', 'acrobat');
		}
		if(in_array($mime_type_str, array(
			'application/msword', 'application/msword',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'application/zip')) && in_array($ext, array('doc', 'docx'))){
				return array('doc', 'word');
		}
		if(in_array($mime_type_str, array('application/powerpoint', 'application/vnd.ms-powerpoint',
			'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'application/zip')) && in_array($ext, array('ppt', 'pptx', 'pptm'))){
				return array('ppt', 'powerpoint');
		}
		if(in_array($mime_type_str, array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
			'application/excel', 'application/vnd.ms-excel', 'application/msexcel',
			'application/zip', 'application/octet-stream', 'application/vnd.ms-excel', 'application/vnd.msexcel')) 
			&& in_array($ext, array('xlsx', 'xlt', 'xlsm'))){
			return array('excel', 'excel');
		}
		if(in_array($mime_type_str, array('text/plain', 'text/x-comma-separated-values', 'text/comma-separated-values', 
			'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv')) && in_array($ext, array('csv'))){
				return array('csv', 'excel');
		}
		return array('text', 'txt');
	}
}

if ( ! function_exists('get_doc_access'))
{
	function get_doc_access($user_grade){
		global $grade_access;
		$ret = array();
		$find = false;
		while(current($grade_access)){
			if($find){
				array_push($ret, key($grade_access));
			}
			else{
				if(key($grade_access) == $user_grade){
					array_push($ret, key($grade_access));
					$find = true;
				}
			}
			next($grade_access);
		}
		return $ret;
	}
}

if ( ! function_exists('ajax_error')){
	function ajax_error($code, $message = ''){
		$error_msgs = array(
			403 => 'Forbidden',
			500 => 'Internal Server Error',
			511 => 'Network Authentication Required'
		);
		set_status_header($code, $error_msgs[$code]);
		//header("HTTP/1.1 $code ".$error_msgs[$code]);
		header('Content-Type: application/text; charset=UTF-8');
		die($message);
	}
}

if ( ! function_exists('my_email')){
	require_once('./application/libraries/phpmailer.php');
	function my_email($smtp, $from, $from_name, $to, $cc, $bcc, $reply_to, $subject, $body){
		$mail = new PHPMailer();
		$mail->isSMTP();
		//$mail->Mailer = 'smtp';
		//$mail->SMTPAuth = true;
		//$mail->Port = $smtp['port'];
		//$mail->SMTPSecure = $smtp['secure'];
		$mail->Host = 'relay-hosting.secureserver.net';//$smtp['host'];
		$mail->Username = $smtp['username'];
		$mail->Password = $smtp['password'];

		//$mail->SMTPDebug = 2;

		$mail->isHTML(true); // if you are going to send HTML formatted emails
		$mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

		$mail->From = $from;//"ask4betty.dublin@yahoo.com";
		$mail->FromName = $from_name;//"Xiaozhao Zhuang";
		if(!empty($reply_to)){
			$mail->addReplyTo($reply_to);
		}
		foreach($to as $t){
			$t = trim($t);
			if(!empty($t)){
				$mail->addAddress($t);
			}
		}
		
		foreach($cc as $c){
			$c = trim($c);
			if(!empty($c)){
				$mail->addCC(trim($c));
			}
		}

		foreach($bcc as $c){
			$c = trim($c);
			if(!empty($c)){
				$mail->addBCC(trim($c));
			}
		}

		$mail->Subject = $subject;
		$mail->Body = $body;

		if(!$mail->Send())
			return "Message was not sent. ".$mail->ErrorInfo;
		else
			return true;
	}
}

if ( ! function_exists('update_content')){
	function update_content($content, $saved_image_path){
		if(empty($content)){
			return '';
		}
		$content = str_replace("\n", "", $content);
		$local_host_path = parse_url(base_url());
		$local_host = strtolower($local_host_path['host']);
		$xmlDoc = new DOMDocument();
		//$xmlDoc->encoding = 'UTF-8';
		$internalErrors = libxml_use_internal_errors(true);
		$xmlDoc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
		libxml_use_internal_errors($internalErrors);
		$img_list = $xmlDoc->getElementsByTagName('img');
		for($i = 0; $i < $img_list->length; ++$i){
			$class = trim($img_list->item($i)->parentNode->getAttribute('class'));
			$class_list = explode(' ', $class);
			if(!in_array('content-image', $class_list)){
				$img_list->item($i)->parentNode->setAttribute('class', $class." content-image");
			}
			$src = strtok($img_list->item($i)->getAttribute('src'), '?');
			$class = $img_list->item($i)->getAttribute('class');
			while ($img_list->item($i)->attributes->length > 0) {
				$img_list->item($i)->removeAttribute($img_list->item($i)->attributes->item(0)->name);
			}
			$img_list->item($i)->setAttribute('class', $class);
			$path = parse_url($src);
			if(!isset($path['host']) || strtolower($path['host']) != $local_host){
				$image = file_get_contents($src);
				$image_name = time().$i;
				file_put_contents(getcwd().'/'.$saved_image_path.'/'.$image_name, $image);
				$img_list->item($i)->setAttribute('src', base_url().$saved_image_path.'/'.$image_name);
			}
			else{
				$img_list->item($i)->setAttribute('src', $src);
			}
		}
		
		$innerHTML= ''; 
		$children = $xmlDoc->getElementsByTagName('body')->item(0)->childNodes; 
		foreach ($children as $child) { 
			$innerHTML .= $child->ownerDocument->saveXML( $child ); 
		} 

		return $innerHTML; 
	}
}

if ( ! function_exists('doc_icon_color')){
	function doc_icon_color($type){
		$icon_colors = array(
			'pdf' => '#8B0000',
			'powerpoint' =>'#FF8C00',
			'image' => '#48D1CC',
			'word' => '#191970',
			'video' => '#696969',
			'excel' => '#008000'
		);
		foreach($type as $t){
			$t = strtolower($t);
			if(array_key_exists($t, $icon_colors)){
				return $icon_colors[$t];
			}
		}
		return '#000';
	}
}

if ( ! function_exists('send_mail')){
	function send_mail($mailer, $from, $fromName, $to, $subject, $body){
		$mailer->From = $from;
		$mailer->FromName = $fromName;
		
		$mailer->addReplyTo($from);
		foreach($to as $t){
			$mailer->addAddress(trim($t));
		}
		
		$mailer->Subject = $subject;
		$mailer->Body = $body;

		if(!$mailer->Send()){
			return "Message was not sent. ".$mailer->ErrorInfo;
		}
		return true;
	}
}

if ( ! function_exists('number_to_chinese')){
	function number_to_chinese($number){
		//10.3万
		//341万
		//2039万
		//1.37亿
		//13.98亿
		if($number < 10000){
			return $number;
		}
		else if($number < 100000){
			$number = round($number / 10000, 1);
			return $number.'万';
		}
		else if($number < 100000000){
			$number = round($number / 10000);
			return $number.'万';
		}
		$number = round($number / 100000000, 2);
		return $number.'亿';
	}
}
	
if ( ! function_exists('number_to_english')){
	function number_to_english($number){
		//10.3万
		//341万
		//2039万
		//1.37亿
		//13.98亿
		if($number / 1000000 >= 1){
			return ($number / 1000000).'M';
		}
		
		if($number / 1000 >= 1){
			return ($number / 1000).'K';
		}
		return $number;
	}	
}

if ( ! function_exists('custom_number_format')){
	function custom_number_format($n) {
		if ($n < 1000) {
			// Anything less than a million
			$n_format = $n;
		} else if ($n < 1000000) {
			// Anything less than a million
			$n_format = number_format($n / 1000).'K';
		} else if ($n < 1000000000) {
			// Anything less than a billion
			if(number_format($n / 1000000) == $n / 1000000){
				$n_format = ($n / 1000000) . 'M';
			}
			else{
				$n_format = number_format($n / 1000000, 1) . 'M';
			}
		}

		return $n_format;
	}
}

if ( ! function_exists('date_format_convertion')){
	function date_format_convertion($d) {//m/d/y -> Y-m-d
		$da = explode('/', $d);
		if($da && count($da) == 3){
			$date = trim($da[2]).'-'.trim($da[0]).'-'.trim($da[1]);
			return $date;
		}
	}
}

if ( ! function_exists('filter_char')){
	function filter_char($s) {//only keep digitand letter
		$len = strlen($s);
		$v = '';
		for($i = 0; $i < $len; ++$i){
			if(($s[$i] >= '0' && $s[$i] <= '9')
				|| ($s[$i] >= 'A' && $s[$i] <= 'Z')
				|| ($s[$i] >= 'a' && $s[$i] <= 'z')){
				$v .= $s[$i];
			}
		}
		return $v;
	}
}

if ( ! function_exists('filter_digit')){
	function filter_digit($s) {//only keep digitand letter
		$len = strlen($s);
		$v = '';
		for($i = 0; $i < $len; ++$i){
			if($s[$i] >= '0' && $s[$i] <= '9'){
				$v .= $s[$i];
			}
		}
		return $v;
	}
}
