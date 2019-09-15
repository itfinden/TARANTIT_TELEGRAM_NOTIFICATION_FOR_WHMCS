<?php

$GLOBALS['telegram_bot'] = "364508222:AAH4U4SRhuhk2bKJSlznSwIfAEPQtrVXAH0";
$GLOBALS['telegram_chat'] = "-360580051";
#$GLOBALS['telegram_date'] = date(DateTime::ISO8601);
$GLOBALS['telegram_date'] = date("d-m-Y H:i:s");
$GLOBALS['telegram_url'] = "https://comunica.itfinden.com/commands/process";
$GLOBALS['whmcsAdminURL'] = "https://customer.itfinden.com/gestion/";
$GLOBALS['companyName'] = "ITFINDEN CORP";
$GLOBALS['discordColor'] = hexdec("");
$GLOBALS['logo'] = "";



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

// Login Notifications 
$AdminLogin=true ; 
$AdminLogout=true;

///////////////////////////////////////////////////////////////////////

?>