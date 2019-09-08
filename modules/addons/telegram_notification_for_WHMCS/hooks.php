<?php

////////////////////////// Configuration Area //////////////////////////
// Configure the below variables to allow the script to work correct and connect to both your WHMCS install and Telegram Bot.
// date(DateTime::ISO8601)
$GLOBALS['telegram_bot'] = "364508222:AAH4U4SRhuhk2bKJSlznSwIfAEPQtrVXAH0";
$GLOBALS['telegram_chat'] = "-360580051";
#$GLOBALS['telegram_date'] = date(DateTime::ISO8601);
$GLOBALS['telegram_date'] = date("d-m-Y H:i:s");


#$GLOBALS['telegram_chat'] = "-283356249";


$GLOBALS['telegram_url'] = "https://comunica.itfinden.com/commands/process";
// Your Discord WebHook URL.
// Note: Please be aware that the channel that you select when creating the web hook will be where the messages are sent.

// Your WHMCS Admin URL.
$GLOBALS['whmcsAdminURL'] = "https://customer.itfinden.com/gestion/";
// Note: Please include the end / on your URL. An example of an accepted link would be: https://account.whmcs.com/admin/

// Your Company Name.
$GLOBALS['companyName'] = "ITFINDEN CORP";
// Note: This will be the name of the user that sends the message in the Discord channel.

// Discord Message Color
$GLOBALS['discordColor'] = hexdec("");
// Note: The color code format within this script is standard hex. Exclude the beginning # character if one is present.

// Note: If you'd like to have a specific group pinged on each message, please place the ID here. An example of a group ID is: <@&343029528563548162>

#$GLOBALS['logo'] = "https://www.itfinden.com/wp-content/uploads/2015/02/team_pic_4.jpg";
$GLOBALS['logo'] = "";

// (OPTIONAL SETTING) Your desired Webhook Avatar. Please make sure you enter a direct link to the image (E.G. https://example.com/iownpaypal.png).


////////////////////////// Notification Area //////////////////////////
// Configure the below notification settings to meet the requirements of your team and what you wish to send to the Discord channel. 'true' = enabled, 'false' = disabled

// Invoice Notifications
$invoicePaid = true; // Invoice Paid Notification
$InvoiceUnpaid = true ; // Invoice unPaid Notification
$invoiceRefunded = true; // Invoice Refunded Notification
$invoiceLateFee = true; // Invoice Late Fee Notification

// Order Notifications
$orderAccepted = true; // Order Accepted Notification
$orderCancelled = true; // Order Cancelled Notification
$orderCancelledRefunded = true; // Order Cancelled & Refunded Notification
$orderFraud = true; // Order Marked As Fraud Notification

// Network Issue Notifications
$networkIssueAdd = true; // New Network Issue Added Notification
$networkIssueEdit = true; // Network Issue Edited Notification
$networkIssueClosed = true; // Network Issue Closed Notification

// Ticket Notifications
$ticketOpened = true; // New Ticket Opened Notification
$ticketUserReply = true; // Ticket User Reply Received Notification
$ticketFlagged = true; // Ticket Flagged To Staff Member Notification
$ticketNewNote = true; // New Note Added To Ticket Notification

// Miscellaneous Notifications
$cancellationRequest = true; // New Cancellation Request Received Notification

///////////////////////////////////////////////////////////////////////
$AdminLogin=true ; 
$AdminLogout=true;



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
		processNotification($dataPacket);
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
		processNotification($dataPacket);
	});
endif;


if($InvoiceUnpaid === true):
	add_hook('InvoiceUnpaid', 1, function($vars)	{
	    
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'Invoice ' . $vars['invoiceid'] . ' Has Been Paid',
			'url' => $GLOBALS['whmcsAdminURL'] . 'invoices.php?action=edit&id=' . $vars['invoiceid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'author' => 'ITFINDEN',
			'name' => 'Invoice unPaid'
		);
		processNotification($dataPacket);
	});
endif;

if($invoicePaid === true):
	add_hook('InvoicePaid', 1, function($vars)	{
	    
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'Invoice ' . $vars['invoiceid'] . ' Has Been Paid',
			'url' => $GLOBALS['whmcsAdminURL'] . 'invoices.php?action=edit&id=' . $vars['invoiceid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'author' => 'ITFINDEN',
			'name' => 'Invoice Paid'
		);
		processNotification($dataPacket);
	});
endif;
		
if($invoiceRefunded === true):
	add_hook('InvoiceRefunded', 1, function($vars)	{
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],			 
			'title' => 'Invoice ' . $vars['invoiceid'] . ' Has Been Refunded',
			'url' => $GLOBALS['whmcsAdminURL'] . 'invoices.php?action=edit&id=' . $vars['invoiceid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Invoice Refunded'
		);
		processNotification($dataPacket);
	});
endif;

if($invoiceLateFee === true):
	add_hook('AddInvoiceLateFee', 1, function($vars) {
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'Invoice ' . $vars['invoiceid'] . ' Has Had A Late Fee Added',
			'url' => $GLOBALS['whmcsAdminURL'] . 'invoices.php?action=edit&id=' . $vars['invoiceid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Invoice Late Fee Added'
		);
		processNotification($dataPacket);
	});
endif;

if($orderAccepted === true):
	add_hook('AcceptOrder', 1, function($vars)	{
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'Order ' . $vars['orderid'] . ' Has Been Accepted',
			'url' => $GLOBALS['whmcsAdminURL'] . 'orders.php?action=view&id=' . $vars['orderid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Order Accepted'
	
		);
		processNotification($dataPacket);
	});
endif;

if($orderCancelled === true):
	add_hook('CancelOrder', 1, function($vars) {
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'Order ' . $vars['orderid'] . ' Has Been Cancelled',
			'url' => $GLOBALS['whmcsAdminURL'] . 'orders.php?action=view&id=' . $vars['orderid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Order Cancelled'
		);
		processNotification($dataPacket);
	});
endif;

if($orderCancelledRefunded === true):
	add_hook('CancelAndRefundOrder', 1, function($vars) {
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'Order ' . $vars['orderid'] . ' Has Been Cancelled & Refunded',
			'url' => $GLOBALS['whmcsAdminURL'] . 'orders.php?action=view&id=' . $vars['orderid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Order Cancelled & Refunded'
		);
		processNotification($dataPacket);
	});
endif;

if($orderFraud === true):
	add_hook('FraudOrder', 1, function($vars)	{
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'Order ' . $vars['orderid'] . ' Has Been Marked As Fraudulent',
			'url' => $GLOBALS['whmcsAdminURL'] . 'orders.php?action=view&id=' . $vars['orderid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Order Marked As Fraud'
		);
		processNotification($dataPacket);
	});
endif;

if($networkIssueAdd === true):
	add_hook('NetworkIssueAdd', 1, function($vars) {
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'A New Network Issue Has Been Created',
			'url' => $GLOBALS['whmcsAdminURL'] . 'networkissues.php?action=manage&id=' . $vars['id'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => simpleFix($vars['description']),
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'New Network Issue',
			'Start_Date' => $vars['startdate'],
			'End_Date' => $vars['enddate'],
			'Evento' => simpleFix($vars['title']),
			'Priority' => $vars['priority']
		);
		processNotification($dataPacket);
	});
endif; 

if($networkIssueEdit === true):
	add_hook('NetworkIssueEdit', 1, function($vars) {
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'A Network Issue Has Been Edited',
			'url' => $GLOBALS['whmcsAdminURL'] . 'networkissues.php?action=manage&id=' . $vars['id'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => simpleFix($vars['description']),
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Network Issue Edited',
			'Start Date' => $vars['startdate'],
			'End Date' => $vars['enddate'],
			'Evento' => simpleFix($vars['title']),
			'Priority' => $vars['priority']
		);
		processNotification($dataPacket);
	});
endif; 

if($networkIssueClosed === true):
	add_hook('NetworkIssueClose', 1, function($vars) {
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'A Network Issue Has Been Closed',
			'url' => $GLOBALS['whmcsAdminURL'] . 'networkissues.php?action=manage&id=' . $vars['id'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Network Issue Closed'

		);
		processNotification($dataPacket);
	});
endif;

if($ticketOpened === true):
	add_hook('TicketOpen', 1, function($vars)	{
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => '#' . $vars['ticketmask'] . ' - ' . simpleFix($vars['subject']),
			'url' => $GLOBALS['whmcsAdminURL'] . 'supporttickets.php?action=view&id=' . $vars['ticketid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => simpleFix($vars['message']),
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'New Support Ticket',
			'Priority' => $vars['priority'],
			'Department' => $vars['deptname'],
			'Ticket_ID' => '#' . $vars['ticketmask']
		);
		processNotification($dataPacket);
	});
endif;

if($ticketUserReply === true):
	add_hook('TicketUserReply', 1, function($vars)	{
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => simpleFix($vars['subject']),
			'url' => $GLOBALS['whmcsAdminURL'] . 'supporttickets.php?action=view&id=' . $vars['ticketid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => simpleFix($vars['message']),
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'New Ticket Reply',
			'Priority' => $vars['priority'],
			'Department' => $vars['deptname']

		);
		processNotification($dataPacket);
	});
endif;

if($ticketFlagged === true):
	add_hook('TicketFlagged', 1, function($vars)	{
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'A ticket has been flagged to ' . $vars['adminname'],
			'url' => $GLOBALS['whmcsAdminURL'] . 'supporttickets.php?action=view&id=' . $vars['ticketid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => '',
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Ticket Flagged'
		);
		processNotification($dataPacket);
	});
endif;

if($ticketNewNote === true):
	add_hook('TicketAddNote', 1, function($vars)	{
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'A Ticket Note Has Been Added',
			'url' => $GLOBALS['whmcsAdminURL'] . 'supporttickets.php?action=view&id=' . $vars['ticketid'],
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => simpleFix($vars['message']),
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'Ticket Note Added'
		);
		processNotification($dataPacket);
	});
endif;

if($cancellationRequest === true):
	add_hook('CancellationRequest', 1, function($vars)	{
		$dataPacket = array(
			'content' => $GLOBALS['telegram_chat'],
			'companyName' => $GLOBALS['companyName'],
			'avatar_url' => $GLOBALS['logo'],
			'title' => 'A Cancellation Request Has Been Received',
			'url' => $GLOBALS['whmcsAdminURL'] . 'cancelrequests.php',
			'timestamp' => $GLOBALS['telegram_date'],
			'description' => simpleFix($vars['reason']),
			'color' => $GLOBALS['discordColor'],
			'author' => 'ITFINDEN',
			'name' => 'New Cancellation Request',
			'Cancellation_Type' => $vars['type']
		);
		processNotification($dataPacket);
	});
endif;

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


function processNotification_xxx($dataPacket)	{
    

    itfinden_salida($dataPacket);
    
   
     
    $msg['message'] = [
        'text' => 'api',
        'chat' => [
            'id' =>  $GLOBALS['telegram_chat']
            ],
        'bot' =>  $GLOBALS['telegram_bot'],
        'content' => $dataPacket
        ];
        

    
   
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $GLOBALS['telegram_url']);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($msg));
    
    
    
    
    
    $output = curl_exec($curl);
    $output = json_decode($output, true);
	
    if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 204) {
        logModuleCall('Telegram Notifications', 'Notification Sending Failed', json_encode($msg), print_r($output, true));
    } else {
		logModuleCall('Telegram Notifications', 'Notification Successfully Sent', json_encode($msg), print_r($output, true));
	}
	itfinden_salida($output);
    curl_close($curl);

    
}


function simpleFix($value){
	if(strlen($value) > 150) {
		$value = trim(preg_replace('/\s+/', ' ', $value));
		$valueTrim = explode( "\n", wordwrap( $value, 150));
		$value = $valueTrim[0] . '...';
	}
	$value = mb_convert_encoding($value, "UTF-8", "HTML-ENTITIES"); // Allows special characters to be displayed on Discord.
	return $value;
}


