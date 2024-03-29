<?php include 'lib/config.php';?>


<?php

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