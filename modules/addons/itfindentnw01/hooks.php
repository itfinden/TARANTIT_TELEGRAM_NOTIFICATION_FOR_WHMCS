<?php include 'lib/config.php';?>
<?php include 'lib/function.php';?>
<?php include 'lib/action.php';?>


<?php




if($AdminLogout === true):
	add_hook('AdminLogout', 1, "itfinden_AdminLogout");
endif;

if($AdminLogin === true):
	add_hook('AdminLogin', 1, "itfinden_AdminLogin");
endif;

if($InvoiceUnpaid === true):
	add_hook('InvoiceUnpaid', 1, "itfinden_InvoiceUnpaid");
endif;

if($invoicePaid === true):
	add_hook('InvoicePaid', 1, "itfinden_InvoicePaid");
endif;
		
if($invoiceRefunded === true):
	add_hook('InvoiceRefunded', 1, "itfinden_InvoiceRefunded");
endif;

if($invoiceLateFee === true):
	add_hook('AddInvoiceLateFee', 1, "itfinden_AddInvoiceLateFee");
endif;

if($orderAccepted === true):
	add_hook('AcceptOrder', 1, "itfinden_AcceptOrder");
endif;

if($orderCancelled === true):
	add_hook('CancelOrder', 1, "itfinden_CancelOrder");
endif;

if($orderCancelledRefunded === true):
	add_hook('CancelAndRefundOrder', 1, "itfinden_CancelAndRefundOrder");
endif;

if($orderFraud === true):
	add_hook('FraudOrder', 1, "itfinden_FraudOrder");
endif;

if($networkIssueAdd === true):
	add_hook('NetworkIssueAdd', 1, "itfinden_NetworkIssueAdd");
endif; 

if($networkIssueEdit === true):
	add_hook('NetworkIssueEdit', 1, "itfinden_NetworkIssueEdit");
endif; 

if($networkIssueClosed === true):
	add_hook('NetworkIssueClose', 1, "itfinden_NetworkIssueClose");
endif;

if($ticketOpened === true):
	add_hook('TicketOpen', 1, "itfinden_TicketOpen");
endif;

if($ticketUserReply === true):
	add_hook('TicketUserReply', 1, "itfinden_TicketUserReply");
endif;

if($ticketFlagged === true):
	add_hook('TicketFlagged', 1, "itfinden_TicketFlagged");
endif;

if($ticketNewNote === true):
	add_hook('TicketAddNote', 1, "itfinden_TicketAddNote");
endif;

if($cancellationRequest === true):
	add_hook('CancellationRequest', 1, "itfinden_CancellationRequest");
endif;

