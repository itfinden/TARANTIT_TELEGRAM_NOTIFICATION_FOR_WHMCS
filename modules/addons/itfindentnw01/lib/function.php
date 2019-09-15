<?php

function check_new_version(){

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://raw.githubusercontent.com/octocat/Spoon-Knife/master/index.html');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);

	echo $data;	
} 


function itfinden_salida($log_msg)
{
    $log_filename = "/home/itfinden/customer.itfinden.com/includes/hooks";
     
    $log_msg=var_export($log_msg,TRUE) ;
	
    if (!file_exists($log_filename)) 
    {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    
    $log_file_data = $log_filename.'/dump_' . date('d-M-Y') . '.log';
    // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
    file_put_contents($log_file_data, '----------------------------' . "\n", FILE_APPEND);
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
    file_put_contents($log_file_data, '----------------------------' . "\n", FILE_APPEND);
}

function processNotification($pm)
{
    
	$chat_id 		= $GLOBALS['telegram_chat'];
	$botToken 		= $GLOBALS['telegram_bot'];
    $line_telegram 	= "---------------------------";
    $len_box 		= strlen($line_telegram);
    $space			= chr(32);

    #$pm=var_export($pm,TRUE) ;
    foreach ($pm as $key => $value) {

		if($key != 'content' && $key != 'url' && $key != 'companyName' && $key != 'title' && $key != 'author' && $key != 'name' && $key != 'avatar_url'){
		        
		         $pmx .= "<code>".PHP_EOL.$key.'='.$value."</code>" ;
		        # if((strlen($value) + 2) <= $len_box) { $pmx .= str_repeat(chr(32), $len_box-strlen($value)+2)."</code>";} 
		        
		        }elseif($key == 'content'){
		         $content = $value;
		        }elseif ($key == 'companyName') {
		         $companyName = trim($value);
		        }elseif ($key == 'name') {
		         $event = trim($value);
		        }elseif ($key == 'title') {
		         $title = trim($value);	
		        }elseif ($key == 'url') {
		         $url = trim($value);	
		        }
    }

    $msg_telegram  = PHP_EOL.$line_telegram;
    $msg_telegram .=  "<pre>".chr(240) . chr(159) . chr(144) . chr(152) . $companyName."</pre>" ; 
    #if((strlen($companyName) + 2) <= $len_box) { $msg_telegram .= str_repeat($space, $len_box-strlen($companyName)+2)."|";} 
    $msg_telegram .= $line_telegram;
    $msg_telegram .= PHP_EOL."| ". "<b>".$title."</b>";
    #if((strlen($title) + 2) <= $len_box) { $msg_telegram .= str_repeat($space, $len_box-strlen($title)+2)."|";} 
    $msg_telegram .= PHP_EOL.$line_telegram;
    $msg_telegram .= $pmx ;
    $msg_telegram .= PHP_EOL.$line_telegram; 
    $msg_telegram .= PHP_EOL."<a href='".$url."'>Ver link</>";
    $msg_telegram .= PHP_EOL.$line_telegram; 
    $msg_telegram .= PHP_EOL. base64_decode("V0hNQ1MgSXRGaW5kZW4=");
    $msg_telegram .= PHP_EOL.$line_telegram;

    #$msg_telegram .= PHP_EOL."[inline URL](http://www.example.com/)";

	$data = array(
		'chat_id' 	=> $chat_id,
		'text' 		=> $msg_telegram,
		'parse_mode' => 'HTML' //or html
	);
    
    #itfinden_log(var_export($pm,TRUE));
    itfinden_salida(var_export($pm,TRUE));

    
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/bot".$botToken."/sendMessage");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_exec($curl);
	
	if(!curl_errno($curl))
        {
         $info = curl_getinfo($curl);
        # itfinden_log ('Tiempo ' . $info['total_time'] . ' URL :  ' . $info['url']);
        }
        
        // Close handle
	
	curl_close($curl);
    
}

function itfinden_log($log_msg)
{
    $log_filename = getcwd()."/itfindentnw01_log/";
    if (!file_exists($log_filename)) 
    {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    
    $log_file_data = $log_filename.'log_' . date('d-M-Y') . '.log';
    // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
}
function itfinden_dump($log_msg)
{
    $log_filename = getcwd()."/itfindentnw01_dump/";
    
    $log_msg=var_export($log_msg,TRUE) ;
	
    if (!file_exists($log_filename)) 
    {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    
    $log_file_data = $log_filename.'dump_' . date('d-M-Y') . '.log';
    // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
}


function sendTelegramMessage($pm) {
	global $vars;
	$application_chatid = mysql_fetch_array( select_query('tbladdonmodules', 'value', array('module' => 'itfindentnw01', 'setting' => 'chatid') ), MYSQL_ASSOC );
	$application_botkey = mysql_fetch_array( select_query('tbladdonmodules', 'value', array('module' => 'itfindentnw01', 'setting' => 'BotId') ), MYSQL_ASSOC );
	$chat_id 		= $application_chatid['value'];
	$botToken 		= $application_botkey['value'];
	
	$pm=var_export($pm,TRUE); 

	$data = array(
		'chat_id' 	=> $chat_id,
		'text' 		=> PHP_EOL. $pm . PHP_EOL."-------------" . PHP_EOL. "itfindentnw01". PHP_EOL .base64_decode("V0hNQ1MgSXRGaW5kZW4=")
	);
    

    itfinden_log($pm);
    
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/bot".$botToken."/sendMessage");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_exec($curl);
	
	if(!curl_errno($curl))
        {
         $info = curl_getinfo($curl);
         itfinden_log ('Tiempo ' . $info['total_time'] . ' URL :  ' . $info['url']);
        }
        
        // Close handle
	
	curl_close($curl);
}


?>