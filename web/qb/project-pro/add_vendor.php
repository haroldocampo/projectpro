<?php

/**
 * Example integration with an application
 * 
 * The idea behind the action queue is basically just that you want to add an 
 * action/ID pair to the queue whenever something happens in your application 
 * that you need to tell QuickBooks about. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */
 
// Error reporting for easier debugging
ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);
 
// Require the queueuing class
require_once '../QuickBooks.php';


if (isset($_GET['name'])) {
// QuickBooks queueing class
    $Queue = new QuickBooks_WebConnector_Queue('mysqli://root:haroldhir@localhost/projectpro');
	
// Queue it up!
    $Queue->enqueue(QUICKBOOKS_ADD_VENDOR, 10, 0, ['name' => $_GET['name']], null, null, true);
}

// Also note the that ->enqueue() method supports some other parameters: 
// 	string $action				The type of action to queue up
//	mixed $ident = null			Pass in the unique primary key of your record here, so you can pull the data from your application to build a qbXML request in your request handler
//	$priority = 0				You can assign priorities to requests, higher priorities get run first
//	$extra = null				Any extra data you want to pass to the request/response handler
//	$user = null				If you're using multiple usernames, you can pass the username of the user to queue this up for here
//	$qbxml = null				
//	$replace = true
