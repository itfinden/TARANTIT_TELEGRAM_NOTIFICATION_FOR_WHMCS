<?php
///////////////////////////////////////////////////////////////////////
$AdminLogin=true ; 
$AdminLogout=true;
///////////////////////////////////////////////////////////////////////

$GLOBALS['telegram_bot'] = "364508222:AAH4U4SRhuhk2bKJSlznSwIfAEPQtrVXAH0";
$GLOBALS['telegram_chat'] = "-360580051";
#$GLOBALS['telegram_date'] = date(DateTime::ISO8601);
$GLOBALS['telegram_date'] = date("d-m-Y H:i:s");
$GLOBALS['telegram_url'] = "https://comunica.itfinden.com/commands/process";
$GLOBALS['whmcsAdminURL'] = "https://xxcustomer.itfinden.com/gestion/";
$GLOBALS['companyName'] = "ITFINDEN CORP";
$GLOBALS['discordColor'] = hexdec("");
$GLOBALS['logo'] = "";
///////////////////////////////////////////////////////////////////////




function simpleFix($value){
	if(strlen($value) > 150) {
		$value = trim(preg_replace('/\s+/', ' ', $value));
		$valueTrim = explode( "\n", wordwrap( $value, 150));
		$value = $valueTrim[0] . '...';
	}
	$value = mb_convert_encoding($value, "UTF-8", "HTML-ENTITIES"); // Allows special characters to be displayed on Discord.
	return $value;
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
    
    $log_msg=var_export($log_msg,TRUE) 
	
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



function tnw_ClientAdd($vars) {
	global $customadminpath, $CONFIG;
	$application_key = mysql_fetch_array(select_query('tbladdonmodules', 'value', array('module' => 'itfindentnw01', 'setting' => 'key')), MYSQL_ASSOC);
	$administrators = full_query("SELECT `access_token` FROM `itfindentnw01` WHERE `permissions` LIKE '%new_client%'");
	while ($administrator = mysql_fetch_array($administrators, MYSQL_ASSOC)) {
		$tnw[] = $administrator['access_token'];
	}
	$tnw = implode($tnw, ',');
	curlCall("https://itfinden.free.beeceptor.com/v1/bulk", array('app' => $application_key['value'], 'users' => $tnw, 'notification[title]' => 'New WHMCS Client', 'notification[text]' => 'A new client has signed up!', 'notification[sound]' => 'fanfare', 'notification[url]' => $CONFIG['SystemURL'] . '/' . $customadminpath . '/clientssummary.php?userid=' . $vars['userid']));
}

function tnw_InvoicePaid($vars) {
	global $customadminpath, $CONFIG;
	$application_key = mysql_fetch_array(select_query('tbladdonmodules', 'value', array('module' => 'itfindentnw01', 'setting' => 'key')), MYSQL_ASSOC);
	$administrators = full_query("SELECT `access_token` FROM `itfindentnw01` WHERE `permissions` LIKE '%new_invoice%'");
	while ($administrator = mysql_fetch_array($administrators, MYSQL_ASSOC)) {
		$tnw[] = $administrator['access_token'];
	}
	$tnw = implode($tnw, ',');
	curlCall("https://itfinden.free.beeceptor.com/v1/bulk", array('app' => $application_key['value'], 'users' => $tnw, 'notification[title]' => 'An invoice has just been paid', 'notification[text]' => 'Invoice #' . $vars['invoiceid'] . ' has been paid.', 'notification[sound]' => 'cash', 'notification[url]' => $CONFIG['SystemURL'] . '/' . $customadminpath . '/invoices.php?action=edit&id=' . $vars['invoiceid']));
}

function tnw_TicketOpen($vars) {
	global $customadminpath, $CONFIG;
	$application_key = mysql_fetch_array(select_query('tbladdonmodules', 'value', array('module' => 'itfindentnw01', 'setting' => 'key')), MYSQL_ASSOC);
	$administrators = full_query("SELECT `access_token` FROM `itfindentnw01` WHERE `permissions` LIKE '%new_ticket%'");
	while ($administrator = mysql_fetch_array($administrators, MYSQL_ASSOC)) {
		$tnw[] = $administrator['access_token'];
	}
	$tnw = implode($tnw, ',');
	curlCall("https://itfinden.free.beeceptor.com/v1/bulk", array('app' => $application_key['value'], 'users' => $tnw, 'notification[title]' => 'A new ticket has arrived', 'notification[text]' => $vars['subject'] . ' (in ' . $vars['deptname'] . ')', 'notification[sound]' => 'subtle1', 'notification[url]' => $CONFIG['SystemURL'] . '/' . $customadminpath . '/supporttickets.php?action=viewticket&id=' . $vars['ticketid']));
}

function tnw_TicketUserReply($vars) {
	global $customadminpath, $CONFIG;
	$application_key = mysql_fetch_array(select_query('tbladdonmodules', 'value', array('module' => 'itfindentnw01', 'setting' => 'key')), MYSQL_ASSOC);
	$administrators = full_query("SELECT `access_token` FROM `itfindentnw01` WHERE `permissions` LIKE '%new_update%'");
	while ($administrator = mysql_fetch_array($administrators, MYSQL_ASSOC)) {
		$tnw[] = $administrator['access_token'];
	}
	$tnw = implode($tnw, ',');
	curlCall("https://itfinden.free.beeceptor.com/v1/bulk", array('app' => $application_key['value'], 'users' => $tnw, 'notification[title]' => 'A ticket has been updated', 'notification[text]' => $vars['subject'] . ' (in ' . $vars['deptname'] . ')', 'notification[sound]' => 'subtle1', 'notification[url]' => $CONFIG['SystemURL'] . '/' . $customadminpath . '/supporttickets.php?action=viewticket&id=' . $vars['ticketid']));
}

if($AdminLogout === true):
	add_hook('AdminLogout', 1, function($vars)	{
	    
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'User ' . $vars['username'] . ' cerro de session',
			'url' => $GLOBALS['whmcsAdminURL'] . 'invoices.php?action=edit&id=' . $vars['invoiceid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'author' => 'ITFINDEN',
			'name' => 'Termino de session'
		);
		sendTelegramMessage($dataPacket);
	});
endif;

if($AdminLogin === true):
	add_hook('AdminLogin', 1, function($vars)	{
	    
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'User ' . $vars['username'] . ' Inicio de session',
			'url' => $GLOBALS['whmcsAdminURL'] . 'invoices.php?action=edit&id=' . $vars['invoiceid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'author' => 'ITFINDEN',
			'name' => 'Inicio de session'
		);
		sendTelegramMessage($dataPacket);
	});
endif;


add_hook("ClientAdd", 1, "tnw_ClientAdd");
add_hook("InvoicePaid", 1, "tnw_InvoicePaid");
add_hook("TicketOpen", 1, "tnw_TicketOpen");
add_hook("TicketUserReply", 1, "tnw_TicketUserReply");