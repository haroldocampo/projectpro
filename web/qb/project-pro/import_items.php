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
require 'qb_commands.php';

$_POST = json_decode(file_get_contents('php://input'), true);
//$constring = 'mysqli://root:haroldhir@localhost/projectpro';
$constring = 'mysqli://whtjbcmxca2mva1a:da7ow979nv0c9cge@a07yd3a6okcidwap.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306/yjk65kqfblljtc6t'; // staging
//$constring = 'mysqli://projectpro:CDE%234rfv@projectpro.ckmlnd5q6yq4.us-east-1.rds.amazonaws.com/projectpro'; // live



if (isset($_POST['import'])) {
    $import_request = $_POST['import'];

    // Initialize creates the neccessary database schema for queueing up requests and logging
    $username = 'projectpro_' . $import_request['companyId'];
    $pass = 'projectpro';
    QuickBooks_Utilities::createUser($constring, $username, $pass); // This creates a username and password which is used by the Web Connector to authenticate

    // QuickBooks queueing class
    $Queue = new QuickBooks_WebConnector_Queue($constring);

    $projects = $import_request['projects'];
    //$costCodes = $import_request['cost_codes'];
    $classes = $import_request['classes'];
    //$purchaseItems = $import_request['purchase_items'];

    // Add Project
    foreach ($projects as $item) {
    //    $Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, ('project_' . $item['id']), 4, $item, $username, null, true);
    }

    // Add Cost Codes
    //foreach ($costCodes as $item) {
        //$Queue->enqueue(QUICKBOOKS_ADD_NONINVENTORYITEM, ('cost_' . $item['id']), 2, $item, $username, null, true); // Check Replace if its false instead of true now
    //}

    // Add Classes
    foreach ($classes as $item) {
        //$Queue->enqueue(QUICKBOOKS_ADD_CLASS, ('class_' . $item['id']), 4, $item, $username, null, true);
    }

    $filler = ['name' => 'Z_QB_FILLER', 'number' => '0', 'code_number' => '0', 'description' => 'Z_QB_FILLER', 'budget_amount' => 0];

    // ADD FILLERS
    if (true) {
        //$Queue->enqueue(QUICKBOOKS_ADD_CLASS, ('filler_class_0'), 4, $filler, $username, null, true);
        //$Queue->enqueue(QUICKBOOKS_ADD_VENDOR, ('filler_vendor_0'), 4, $filler, $username, null, true);
        //$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, ('filler_customer_0'), 4, $filler, $username, null, true);
        //$Queue->enqueue(QUICKBOOKS_ADD_NONINVENTORYITEM, ('filler_cost_item_0'), 4, $filler, $username, null, true);
    }

    $Queue->enqueue(QUICKBOOKS_QUERY_ACCOUNT, 'account_' . 1, 2, $import_request, $username, null, true);

    // Add Classes

    // Add Items in Bill
    //foreach($purchaseItems as $item){
    //$Queue->enqueue(QUICKBOOKS_ADD_BILL, 0, 1, $purchaseItems, $username, null, true);
    //}

}
    
    // Also note the that ->enqueue() method supports some other parameters: 
    // 	string $action				The type of action to queue up
    //	mixed $ident = null			Pass in the unique primary key of your record here, so you can pull the data from your application to build a qbXML request in your request handler
    //	$priority = 0				You can assign priorities to requests, higher priorities get run first
    //	$extra = null				Any extra data you want to pass to the request/response handler
    //	$user = null				If you're using multiple usernames, you can pass the username of the user to queue this up for here
    //	$qbxml = null				
    //	$replace = true
    