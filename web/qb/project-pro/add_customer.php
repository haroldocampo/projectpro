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

// QuickBooks queueing class
$Queue = new QuickBooks_WebConnector_Queue('mysqli://root:haroldhir@localhost/projectpro');
	
// Queue it up!
$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, 4);


