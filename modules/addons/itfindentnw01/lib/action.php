<?PHP

function itfinden_AddInvoicePayment($vars) {
	global $customadminpath, $CONFIG;
	$ip=$_SERVER['REMOTE_ADDR'];
	itfinden_dump($vars);
	Gen_Message("se agrego pago a factura :<BREAKLINE> ----------------------------- <BREAKLINE> El $vars[admin_username] ha iniciado session <BREAKLINE> desde la ip $ip");
}

function itfinden_AdminLogout($vars) {

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
}

function itfinden_AdminLogin($vars) {
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
}
function itinden_InvoiceUnpaid($vars) {

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
}


function itfinden_InvoicePaid ($vars) {
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
}

function itfinden_InvoiceRefunded ($vars) {
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
}
function itfinden_AddInvoiceLateFee ($vars) {
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
}
function itfinden_AcceptOrder ($vars) {
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
}
function itfinden_CancelOrder ($vars) {
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
}
function itfinden_CancelAndRefundOrder ($vars) {
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
}
function itfinden_FraudOrder ($vars) {
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
}

function itfinden_NetworkIssueAdd ($vars) {
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
}
function itfinden_NetworkIssueEdit ($vars) {
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
}
function itfinden_NetworkIssueClose ($vars) {
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
}
function itfinden_TicketOpen ($vars) {
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
}
function itfinden_TicketUserReply ($vars) {
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
}
function itfinden_TicketFlagged ($vars) {
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
}
function itfinden_TicketAddNote ($vars) {
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

}
function itfinden_CancellationRequest ($vars) {
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
}




?>