<?php

use AppBundle\Entity\TransactionType;

function pathUrl()
{
	$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
	return $root;
}

function _quickbooks_items_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
    // REFERENCE COSTCODEDESCRIPTION
	// $costCodeFullName = $extra['code_number'] . ' ' . $extra['description'];
	$costCodeFullName = $extra['code_number'];
	$xml = '<?xml version="1.0" encoding="utf-8"?>
    <?qbxml version="7.0"?>
    <QBXML>
      <QBXMLMsgsRq onError="continueOnError">
        <ItemServiceAddRq requestID="' . $requestID . '" >
          <ItemServiceAdd>
            <Name>' . $costCodeFullName . '</Name>
            <SalesOrPurchase>
              <Desc>' . $costCodeFullName . '</Desc>
              <Price>' . $extra['budget_amount'] . '</Price>
              <AccountRef>
                <FullName>Utilities</FullName>
              </AccountRef>
            </SalesOrPurchase>
          </ItemServiceAdd>
        </ItemServiceAddRq>
      </QBXMLMsgsRq>
    </QBXML>';

	return $xml;
}

function _quickbooks_items_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
	// Great, customer $ID has been added to QuickBooks with a QuickBooks 
	//	ListID value of: $idents['ListID']
	// 
	// We probably want to store that ListID in our database, so we can use it 
	//	later. (You'll need to refer to the customer by either ListID or Name 
	//	in other requests, say, to update the customer or to add an invoice for 
	//	the customer. 
	
	/*
	mysql_query("UPDATE your_customer_table SET quickbooks_listid = '" . mysql_escape_string($idents['ListID']) . "' WHERE your_customer_ID_field = " . (int) $ID);
	 */
}

function _quickbooks_account_query_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// REFERENCE COSTCODEDESCRIPTION
	//$costCodeFullName = $extra['code_number'] . ' ' . $extra['description'];
	$qbxml = '<?xml version="1.0" encoding="utf-8"?>
	<?qbxml version="13.0"?>
	<QBXML>
	  <QBXMLMsgsRq onError="continueOnError">
		<AccountQueryRq>
		</AccountQueryRq>
	  </QBXMLMsgsRq>
	</QBXML>';

	return $qbxml;
}

function _quickbooks_account_query_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{
	//$constring = 'mysqli://root:haroldhir@localhost/projectpro';
	$constring = 'mysqli://whtjbcmxca2mva1a:da7ow979nv0c9cge@a07yd3a6okcidwap.cbetxkdyhwsb.us-east-1.rds.amazonaws.com/yjk65kqfblljtc6t'; // staging
	//$constring = 'mysqli://projectpro:CDE%234rfv@projectpro.ckmlnd5q6yq4.us-east-1.rds.amazonaws.com/projectpro'; // live

	//$fp = fopen('log.txt', 'w');
	// $fp = fopen('log.txt', 'w');
	////$constring = 'mysqli://root:ha($fp, print_r($user, true));
	// fclose($fp);

	$result = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($result);
	$response = json_decode($json, true);

	//$xmlResponse = print_r($response, true);
	//$fp = fopen('log.txt', 'w');
	//fwrite($fp, print_r($response, true));
	//fclose($fp);
	$Queue = new QuickBooks_WebConnector_Queue($constring);
	//fwrite($fp, print_r($user, true));

	$availableAccounts = $response['QBXMLMsgsRs']['AccountQueryRs']['AccountRet'];
	$listAccountNames = [];


	foreach ($availableAccounts as $a) {
		$accountNumber = isset($a['AccountNumber']) ? $a['AccountNumber'] : '';
		$accountNumber = str_replace(chr(194), '', $accountNumber);
		$fullName = str_replace(chr(194), '',strtoupper(trim($a['FullName'])));
		$listAccountNames[] = ['FullName' => $fullName, 'Name' => strtoupper(trim($a['Name'])), 'Number' => $accountNumber, 'NameWithNumber' => $accountNumber . ' - ' . strtoupper(trim($a['Name']))];
		//$listAccountNames[] = ['FullName' => (trim($accountNumber . ' ' . $a['FullName'])), 'Name' => strtoupper($a['Name']), 'Number' => $accountNumber];
		//$listAccountNames[] = ['FullName' => (trim($a['AccountNumber'] . ' ' . $a['Name'])), 'Name' => $a['Name'], 'Number' => ''];
	}

	$extra['accounts'] = $listAccountNames;

	$Queue->enqueue(QUICKBOOKS_QUERY_VENDOR, 'vendor_' . 1, 2, $extra, $user, null, true);
	//fclose($fp);
}

function _quickbooks_vendor_query_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// REFERENCE COSTCODEDESCRIPTION
	//$costCodeFullName = $extra['code_number'] . ' ' . $extra['description'];
	$qbxml = '<?xml version="1.0" encoding="utf-8"?>
	<?qbxml version="7.0"?>
	<QBXML>
	  <QBXMLMsgsRq onError="continueOnError">
		<VendorQueryRq>
		</VendorQueryRq>
	  </QBXMLMsgsRq>
	</QBXML>';

	return $qbxml;
}

function _quickbooks_vendor_query_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{
	//$constring = 'mysqli://root:haroldhir@localhost/projectpro';
	$constring = 'mysqli://whtjbcmxca2mva1a:da7ow979nv0c9cge@a07yd3a6okcidwap.cbetxkdyhwsb.us-east-1.rds.amazonaws.com/yjk65kqfblljtc6t'; // staging
	//$constring = 'mysqli://projectpro:CDE%234rfv@projectpro.ckmlnd5q6yq4.us-east-1.rds.amazonaws.com/projectpro'; // live
	//$fp = fopen('log.txt', 'w');

	$result = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($result);
	$response = json_decode($json, true);


	//$xmlResponse = print_r($response, true);
	//$fp = fopen('log.txt', 'w');
	//fwrite($fp, print_r($response, true));
	//fclose($fp);
	$Queue = new QuickBooks_WebConnector_Queue($constring);

	$availableVendors = $response['QBXMLMsgsRs']['VendorQueryRs']['VendorRet'];
	$listVendorNames = [];

	foreach ($availableVendors as $v) {
		$listVendorNames[] = strtoupper($v['Name']);
	}

	$extra['vendors'] = $listVendorNames;

	$Queue->enqueue(QUICKBOOKS_QUERY_CLASS, 'class_' . 1, 2, $extra, $user, null, true);
	//fclose($fp);
}

function _quickbooks_class_query_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// REFERENCE COSTCODEDESCRIPTION
	//$costCodeFullName = $extra['code_number'] . ' ' . $extra['description'];
	$qbxml = '<?xml version="1.0" encoding="utf-8"?>
	<?qbxml version="7.0"?>
	<QBXML>
	  <QBXMLMsgsRq onError="continueOnError">
		<ClassQueryRq>
		</ClassQueryRq>
	  </QBXMLMsgsRq>
	</QBXML>';

	return $qbxml;
}

function _quickbooks_class_query_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{
	//$constring = 'mysqli://root:haroldhir@localhost/projectpro';
	$constring = 'mysqli://whtjbcmxca2mva1a:da7ow979nv0c9cge@a07yd3a6okcidwap.cbetxkdyhwsb.us-east-1.rds.amazonaws.com/yjk65kqfblljtc6t'; // staging
	//$constring = 'mysqli://projectpro:CDE%234rfv@projectpro.ckmlnd5q6yq4.us-east-1.rds.amazonaws.com/projectpro'; // live
	//$fp = fopen('log.txt', 'w');

	$result = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($result);
	$response = json_decode($json, true);


	//$xmlResponse = print_r($response, true);
	//$fp = fopen('log.txt', 'w');
	//fwrite($fp, print_r($response, true));
	//fclose($fp);
	$Queue = new QuickBooks_WebConnector_Queue($constring);

	$availableEntities = $response['QBXMLMsgsRs']['ClassQueryRs']['ClassRet'];
	$listEntityNames = [];

	foreach ($availableEntities as $e) {
		$listEntityNames[] = strtoupper($e['Name']);
	}

	$extra['classes'] = $listEntityNames;
	
	//$Queue->enqueue(QUICKBOOKS_QUERY_CUSTOMER, 'customer_' . 1, 2, $extra, $user, null, true);
	$extra['customers'] = []; // REVERT THISS
	$Queue->enqueue(QUICKBOOKS_QUERY_ITEM, 'item_' . 1, 2, $extra, $user, null, true);
	//fclose($fp);
}

function _quickbooks_customer_query_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// REFERENCE COSTCODEDESCRIPTION
	//$costCodeFullName = $extra['code_number'] . ' ' . $extra['description'];
	$qbxml = '<?xml version="1.0" encoding="utf-8"?>
	<?qbxml version="7.0"?>
	<QBXML>
	  <QBXMLMsgsRq onError="continueOnError">
		<CustomerQueryRq>
		</CustomerQueryRq>
	  </QBXMLMsgsRq>
	</QBXML>';

	return $qbxml;
}

function _quickbooks_customer_query_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{
	//$constring = 'mysqli://root:haroldhir@localhost/projectpro';
	$constring = 'mysqli://whtjbcmxca2mva1a:da7ow979nv0c9cge@a07yd3a6okcidwap.cbetxkdyhwsb.us-east-1.rds.amazonaws.com/yjk65kqfblljtc6t'; // staging
	//$constring = 'mysqli://projectpro:CDE%234rfv@projectpro.ckmlnd5q6yq4.us-east-1.rds.amazonaws.com/projectpro'; // live
	//$fp = fopen('log.txt', 'w');

	$result = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($result);
	$response = json_decode($json, true);


	//$xmlResponse = print_r($response, true);
	//$fp = fopen('log.txt', 'w');
	//fwrite($fp, print_r($response, true));
	//fclose($fp);
	$Queue = new QuickBooks_WebConnector_Queue($constring);

	$availableEntities = $response['QBXMLMsgsRs']['CustomerQueryRs']['CustomerRet'];
	$listEntityNames = [];

	foreach ($availableEntities as $e) {
		$customerJobName = $e['Name'];
		if (isset($e['ParentRef'])) {
			$customerJobName = ($e['ParentRef']['FullName'] . ':' . $customerJobName);
		}

		$listEntityNames[] = strtoupper($customerJobName);
	}

	$extra['customers'] = $listEntityNames;

	$Queue->enqueue(QUICKBOOKS_QUERY_ITEM, 'item_' . 1, 2, $extra, $user, null, true);
	//fclose($fp);
}

function _quickbooks_item_query_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// REFERENCE COSTCODEDESCRIPTION
	//$costCodeFullName = $extra['code_number'] . ' ' . $extra['description'];
	$qbxml = '<?xml version="1.0" encoding="utf-8"?>
	<?qbxml version="7.0"?>
	<QBXML>
	  <QBXMLMsgsRq onError="continueOnError">
		<ItemQueryRq>
		</ItemQueryRq>
	  </QBXMLMsgsRq>
	</QBXML>';

	return $qbxml;
}

function _quickbooks_item_query_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{
	//$constring = 'mysqli://root:haroldhir@localhost/projectpro';
	$constring = 'mysqli://whtjbcmxca2mva1a:da7ow979nv0c9cge@a07yd3a6okcidwap.cbetxkdyhwsb.us-east-1.rds.amazonaws.com/yjk65kqfblljtc6t'; // staging
	//$constring = 'mysqli://projectpro:CDE%234rfv@projectpro.ckmlnd5q6yq4.us-east-1.rds.amazonaws.com/projectpro'; // live
	//$fp = fopen('log.txt', 'w');

	$result = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($result);
	$response = json_decode($json, true);

	$purchases = $extra['purchases'];
	$listVendors = $extra['vendors'];
	$listClasses = $extra['classes'];
	$listCustomers = $extra['customers'];
	$listAccounts = $extra['accounts'];
	$employeeId = $extra['employeeId'];
	$companyId = $extra['companyId'];

	//$xmlResponse = print_r($response, true);


	$Queue = new QuickBooks_WebConnector_Queue($constring);

	$listItemNames = [];
	$purchaseIds = [];

	// GET COST CODES
	$listItemNames = getAllAvailableCostCodes($response);


	foreach ($purchases as $purchase) {
		
		$countPurchaseItems = count($purchase['values']); 
		$purchaseItems = $purchase['values'];

		
		// Get Transaction Type of Purchase
		$transactionType = validate_transaction_type($purchaseItems);

		// Mark Positive or Negative
		$isTotalAmountNegative = mark_absolute($purchaseItems);

		// Check if Purchase Item has valid cost code, if not delete
		validate_paymenttypes($listAccounts, $purchaseItems, $transactionType);

		// Check if vendor matches in QB or vendor has value in project pro
		validate_vendor($listVendors, $purchaseItems);

		// Check if Purchase Item has valid cost code, if not delete
		validate_cost_items($listItemNames, $listAccounts, $purchaseItems);

		// Check if classes are valid
		validate_class($listClasses, $purchaseItems);

		// Check if Customer Exist
		//validate_customer($listCustomers, $purchaseItems);

		

		//$fp = fopen('log.txt', 'w');
		//fwrite($fp, print_r($purchaseItems, true));
		//fclose($fp);

		// Only Import Items with no Exceptions
		$purchaseItemsFiltered = filter_items_with_exception($purchaseItems);
		

		//$fp = fopen('log.txt', 'w');
		//fwrite($fp, print_r($purchaseItems, true));
		//fclose($fp);

		if (count($purchaseItemsFiltered) >= $countPurchaseItems) { // If Purchase Items Exist and are Validated proceed to Add Bill
			$purchaseIds[] = $purchase['key']; // This Mark Purchase as Imported, if it passes through import

			if ($transactionType == 'BILL') {
				if(!$isTotalAmountNegative){
					$Queue->enqueue(QUICKBOOKS_ADD_BILL, 'purchase_' . $purchase['key'], 1, $purchaseItemsFiltered, $user, null, true);
				} else {
					$Queue->enqueue(QUICKBOOKS_ADD_VENDORCREDIT, 'purchase_' . $purchase['key'], 1, $purchaseItemsFiltered, $user, null, true);
				}
			} else if ($transactionType == 'CREDIT CARD') {
				if(!$isTotalAmountNegative){
					$Queue->enqueue(QUICKBOOKS_ADD_CREDITCARDCHARGE, 'purchase_' . $purchase['key'], 1, $purchaseItemsFiltered, $user, null, true);
				} else {
					$Queue->enqueue(QUICKBOOKS_ADD_CREDITCARDCREDIT, 'purchase_' . $purchase['key'], 1, $purchaseItemsFiltered, $user, null, true);
				}
			} else { // Transaction Type neither BILL or CREDIT?
				// DO NOT IMPORT TO QUICKBOOKS.. :)
			}

		}
	}
	email_import_report($companyId, $employeeId, $purchaseIds);
}

function getAllAvailableCostCodes(&$response)
{
	$listItemNames = [];

	$availableCostCodesSections = $response['QBXMLMsgsRs']['ItemQueryRs'];

	foreach ($availableCostCodesSections as $section) {
		if (isset($c['requestID'])) {
			continue;
		}

		foreach ($section as $c) {
			$listItemNames[] = ['name' => trim(strtoupper($c['FullName'])), 'account' => $c['SalesOrPurchase']['AccountRef']['FullName']];
		}
	}
	return $listItemNames;
}

function mark_absolute(&$purchaseItems)
{
	$isNegative = false;

	foreach ($purchaseItems as &$pi) {
		$isNegative = $pi['total_amount'] < 0;
		if ($isNegative == true) {
			$pi['amount'] *= -1;
		} else {

		}
	}

	return $isNegative;
}


function filter_items_with_exception($purchaseItems)
{
	$result = [];
	foreach ($purchaseItems as $pi) {
		if (!$pi['is_exception']) { // If no exceptions, include in import
			$result[] = $pi;
		}
	}

	return $result;
}

function validate_transaction_type(&$purchaseItems)
{
	$result = null;
	foreach ($purchaseItems as &$pi) {
		$transactionType = $pi['transaction_type'];
		if ($transactionType == null) {
			$errorMessage = ('Missing Transaction Type. Go to ProjectPro > Administration > Payment Types. Make sure each payment type has a transaction type selected.');
			report_exception($pi['id'], 1, $errorMessage);
			$pi['is_exception'] = true;
		} else {
			$result = $transactionType;
		}
	}

	return $result;
}

function validate_vendor($availableVendors, &$purchaseItems)
{
	//$fp = fopen('log.txt', 'w');


	foreach ($purchaseItems as &$pi) {

		if ($pi['vendor'] == null) {
			$errorMessage = ('Vendor not found. The Web Connector could not find the vendor in ProjectPro. Go to ProjectPro > Administration > Vendors. Make sure the spelling is identical in ProjectPro and QB.');
			report_exception($pi['id'], 2, $errorMessage);
			$pi['is_exception'] = true;
			continue;
		}

		if (in_array(strtoupper($pi['vendor']), $availableVendors)) {
			//$result[] = $pi;
		} else {
			//$fp = fopen('log.txt', 'w');
			//fwrite($fp, print_r($pi['vendor'], true));
			//fclose($fp);
			//fwrite($fp, print_r($availableVendors, true));
			$errorMessage = ('Vendor ' . strtoupper($pi['vendor']) . ' not found. The Web Connector could not find the vendor in QB. Go to ProjectPro > Administration > Vendors. Make sure the spelling is identical in ProjectPro and QB.');
			report_exception($pi['id'], 2, $errorMessage);
			$pi['is_exception'] = true;
			continue;
		}
	}
	//fclose($fp);
}

function validate_class($availableClasses, &$purchaseItems)
{
	foreach ($purchaseItems as &$pi) {
		if(!isset($pi['purchase_class'])){
			continue;
		}

		if (in_array(strtoupper($pi['purchase_class']), $availableClasses)) {
			//$result[] = $pi;
		} else {
			$errorMessage = ('Class ' . strtoupper($pi['purchase_class']) . ' not found. The Web Connector could not find the class in QB. Either add the class to QB or remove the class from ProjectPro');
			report_exception($pi['id'], 7, $errorMessage);
			$pi['is_exception'] = true;
			continue;
		}
	}
}

function validate_customer($availableCustomers, &$purchaseItems)
{
	//fwrite($fp, print_r($availableCustomers, true));
	foreach ($purchaseItems as &$pi) {
		if (in_array(strtoupper($pi['project']), $availableCustomers)) {
			//$result[] = $pi;
		} else {
			$errorMessage = ('Project ' . strtoupper($pi['project']) . ' not found. Either the Web Connector could not find the project in QB or there are multiple jobs in QB with this name. Go to ProjectPro > Administration > Projects > Edit/View the project listed & correct the spelling of the project name. Then go to QB and make sure that each job name is unique.');
			report_exception($pi['id'], 4, $errorMessage);
			$pi['is_exception'] = true;
			continue;
		}
	}
}



function validate_cost_items($availableCostCodes, $listAccounts, &$purchaseItems)
{
	//$fp = fopen('log.txt', 'w');
		//fwrite($fp, print_r($availableCostCodes, true));
	foreach ($purchaseItems as &$pi) {
		if ($pi['cost_class'] == 'EXPENSE') {
			// Get Expense Account Reference
			$pi['expense_account'] = get_expense_account($pi, $listAccounts);
			continue;
		}

		$costCode = trim(strtoupper($pi['cost_code']));
		if (array_search($costCode, array_column($availableCostCodes, 'name')) !== false) {
			// continue
		} else {
			//fwrite($fp, print_r($costCode, true));
			$errorMessage = ('Cost Code Item ' . $costCode . ' not found. The Web Connector could not find the cost code in QB. Go to ProjectPro > Administration > Projects > Edit/View the project listed. Delete or disable the cost code from the project so it does not get used in future purchases.');
			report_exception($pi['id'], 3, $errorMessage);
			$pi['is_exception'] = true;
		}
	}
	
		//fclose($fp);
}

function get_expense_account(&$pi, $availableAccounts)
{
	foreach ($availableAccounts as $c) {
		if (trim(strtoupper($c['FullName'])) == trim(strtoupper($pi['cost_code']))) {
			return $c['FullName'];
		}


		if($c['Number'] == ''){
			continue;
		}
		if (trim(strtoupper($c['Number'] . ' - ' . $c['FullName'])) == trim(strtoupper($pi['cost_code']))) { // Check with Account Number
			return $c['FullName'];
		}
		
		if (trim(strtoupper($c['Number'] . ' - ' . $c['Name'])) == trim(strtoupper($pi['cost_code']))) { // Check with Account Number
			return $c['FullName'];
		}
	}

	// If Expense Account not Found Throw Exception
	$errorMessage = ('Expense Account ' . strtoupper($pi['cost_code']) . ' not found in Quickbooks. The Web Connector could not find the expense account in QB. Go to ProjectPro > Administration > Projects > Edit/View the project listed. Delete or disable the cost code from the project so it does not get used in future purchases, or add ' . strtoupper($pi['cost_code']) . ' to Quickbooks Chart of Accounts.');
	report_exception($pi['id'], 3, $errorMessage);
	$pi['is_exception'] = true;
	return null;
}

function validate_paymenttypes($availableAccounts, &$purchaseItems, $transactionType)
{
	//$fp = fopen('log.txt', 'w');
	//fwrite($fp, print_r($availableAccounts, true));
	//fclose($fp);
	
	if ($transactionType != 'CREDIT CARD') {
		return;
		// ? LIMIT TO CREDIT, DISABLE FOR NOW
	}
	//$fp = fopen('log.txt', 'w');
	//fwrite($fp, print_r($availableAccounts, true));
	foreach ($purchaseItems as &$pi) {
		$pi['payment_type'] = str_replace(chr(194), '', $pi['payment_type']);
		if (array_search(strtoupper($pi['payment_type']), array_column($availableAccounts, 'Name')) !== false) {
			assign_account_fullname($pi, $availableAccounts);
		} else if (array_search(strtoupper($pi['payment_type']), array_column($availableAccounts, 'NameWithNumber')) !== false) {
			assign_account_fullname($pi, $availableAccounts);
		} else {
			$errorMessage = ('Credit card not found. The Web Connector could not find payment type ' . strtoupper($pi['payment_type']) . ' in QB. Go to your QB Chart of Accounts and either add the payment type as a credit card or correct the credit card account name  to match the one in ProjectPro.');
			report_exception($pi['id'], 6, $errorMessage);
			$pi['is_exception'] = true;
		}
	}
	//fclose($fp);
}

function assign_account_fullname(&$pi, $availableAccounts){
	$isValid = false;
	foreach($availableAccounts as $a){
		if(strtoupper($a['Name']) == strtoupper($pi['payment_type'])){
			$pi['payment_type'] = str_replace(chr(194), '', $a['FullName']);
			$isValid = true;
			break;
		} else if(strtoupper($a['NameWithNumber']) == strtoupper($pi['payment_type'])){
			$pi['payment_type'] = str_replace(chr(194), '', $a['FullName']);
			$isValid = true;
			break;
		}
	}

	if(!$isValid){
		$errorMessage = ('Credit card not found. The Web Connector could not find payment type ' . strtoupper($pi['payment_type']) . ' in QB. Go to your QB Chart of Accounts and either add the payment type as a credit card or correct the credit card account name  to match the one in ProjectPro.');
		report_exception($pi['id'], 6, $errorMessage);
		$pi['is_exception'] = true;
	}
}

function validate_accounts($availableAccounts, &$purchaseItems, $transactionType)
{
	if ($transactionType != 'CREDIT CARD') {
		return;
		// ? LIMIT TO CREDIT, DISABLE FOR NOW
	}

	foreach ($purchaseItems as &$pi) {
		if (in_array($pi['payment_type'], $availableAccounts)) {
			//$result[] = $pi;
		} else {
			$errorMessage = ('Payment Type ' . strtoupper($pi['payment_type']) . ' not found. The Web Connector could not find the credit card in QB. Either add the credit card to the chart of accounts in QB, correct the account name in QB or go to ProjectPro - Administration - Users > View/Edit each user > remove the listed payment type & add the payment type with the same spelling as listed in QB.');
			report_exception($pi['id'], 6, $errorMessage);
			$pi['is_exception'] = true;
		}
	}
}

function report_exception($purchaseItemId, $errorCode, $errorMessage)
{
	$url = pathUrl() . '/api/purchaseItems/' . $purchaseItemId . '/qbException';
	$data = array('errorCode' => $errorCode, 'errorMessage' => $errorMessage);
	$data_string = json_encode($data);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POSTREDIR, 3);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($curl);
	$err = curl_error($curl);

	// curl_close($curl);
	// //var_dump('post/put payment profile \n' . $response);
	// if ($err) {
	// 	return new Response("cURL Error #:" . $err, 500);
	// }

	// // use key 'http' even if you send the request to https://...
	// $options = array(
	// 	'http' => array(
	// 		'header'  => "Content-type: application/json",
	// 		'method'  => 'POST',
	// 		'content' => json_encode($data)
	// 	)
	// );
	// $context  = stream_context_create($options);
	// $result = file_get_contents($url, false, $context);
	// if ($result === FALSE) { /* Handle error */ }
}

function email_import_report($companyId, $employeeId, $purchases)
{
	$url = pathUrl() . '/api/company/' . $companyId . '/email/qbExceptions';
	$data = array('employeeId' => $employeeId, 'purchases' => $purchases);
	$data_string = json_encode($data);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POSTREDIR, 3);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($curl);
	$err = curl_error($curl);

	// use key 'http' even if you send the request to https://...
	// $options = array(
	// 	'http' => array(
	// 		'header'  => "Content-type: application/json",
	// 		'method'  => 'POST',
	// 		'content' => json_encode($data)
	// 	)
	// );
	// $context  = stream_context_create($options);
	// $result = file_get_contents($url, false, $context);
	// if ($result === FALSE) { /* Handle error */ }
}

function _quickbooks_projectpro_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
	// GLOBAL RESPONSE FOR ADDING, EDITING and DELETING
}

function _quickbooks_customer_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	$xml = '<?xml version="1.0" encoding="utf-8"?>
    <?qbxml version="7.0"?>
    <QBXML>
        <QBXMLMsgsRq onError="continueOnError">
            <CustomerAddRq requestID="' . $requestID . '">
                <CustomerAdd>
                    <Name>' . $extra['name'] . ' ' . $extra['number'] . '</Name>
                </CustomerAdd>
            </CustomerAddRq>
            
        </QBXMLMsgsRq>
    </QBXML>';

	return $xml;
}

function _quickbooks_class_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	$xml = '<?xml version="1.0" encoding="utf-8"?>
    <?qbxml version="7.0"?>
    <QBXML>
        <QBXMLMsgsRq onError="continueOnError">
            <ClassAddRq requestID="' . $requestID . '">
                <ClassAdd>
                    <Name>' . $extra['name'] . '</Name>
                </ClassAdd>
            </ClassAddRq>
            
        </QBXMLMsgsRq>
    </QBXML>';

	return $xml;
}

/**
 * Catch and handle a "that string is too long for that field" error (err no. 3070) from QuickBooks
 * 
 * @param string $requestID			
 * @param string $action
 * @param mixed $ID
 * @param mixed $extra
 * @param string $err
 * @param string $xml
 * @param mixed $errnum
 * @param string $errmsg
 * @return void
 */
function _quickbooks_error_stringtoolong($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	mail(
		'your-email@your-domain.com',
		'QuickBooks error occured!',
		'QuickBooks thinks that ' . $action . ': ' . $ID . ' has a value which will not fit in a QuickBooks field...'
	);
}

function addClassRefIfExisting($item)
{
	if (isset($item['purchase_class'])) {
		return '<ClassRef>
					<FullName>' . $item["purchase_class"] . '</FullName>
				</ClassRef>';
	} else {
		return '';
	}
}

function addCustomerRefIfExisting($item)
{
	if (isset($item['project'])) {
		return '<CustomerRef>
					<FullName>' . $item["project"] . '</FullName>
				</CustomerRef>';
	} else {
		return '';
	}
}

function addMemoExisting($item)
{
	if (isset($item['memo'])) {
		return '<Memo>' . $item["memo"] . '</Memo>';
	} else {
		return '';
	}
}

function addMemoDescExisting($item)
{
	if (isset($item['memo'])) {
		return '<Desc>' . $item["memo"] . '</Desc>';
	} else {
		return '';
	}
}

function _quickbooks_bill_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	$items = $extra;

	$itemString = '';
	$vendor = $items[0]['vendor'];
	$date = $items[0]['purchase_date'];
	$purchaseId = '2018-' . $items[0]['purchase_id'];

	uasort($items, function ($a, $b) {
		return strcmp($a['cost_class'], $b['cost_class']);
	});


	foreach ($items as $item) {
		$amount = number_format((float)$item["amount"], 2, '.', '');
		if ($item['cost_class'] == 'ITEM') {
			$itemString .= '
			<ItemLineAdd>
				<ItemRef>
					<FullName>' . $item["cost_code"] . '</FullName>
				</ItemRef>
				'. addMemoDescExisting($item) .'
				<Quantity>' . $item["quantity"] . '</Quantity>
				<Cost>00.00</Cost>
				<Amount>' . $amount . '</Amount>
				' . addCustomerRefIfExisting($item) . '
				' . addClassRefIfExisting($item) . '
			</ItemLineAdd>
			';
		} else { // EXPENSE
			$itemString .= '
			<ExpenseLineAdd>
				<AccountRef>
					<FullName>' . $item["expense_account"] . '</FullName>
				</AccountRef>
				<Amount>' . $amount . '</Amount>
				'. addMemoExisting($item) .'
				' . addCustomerRefIfExisting($item) . '
				' . addClassRefIfExisting($item) . '
			</ExpenseLineAdd>
			';
		}
	}

	// Create and return a qbXML request
	$qbxml = '<?xml version="1.0" ?>
	<?qbxml version="13.0"?>
	<QBXML>
		<QBXMLMsgsRq onError="continueOnError">
			<BillAddRq>
				<BillAdd>
					<VendorRef>
						<FullName>' . $vendor . '</FullName>
					</VendorRef>
					<TxnDate>' . $date . '</TxnDate>
					<DueDate />
					<RefNumber>' . $purchaseId . '</RefNumber>
					<TermsRef>
						<FullName>Net 30</FullName>
					</TermsRef>
					<Memo />
					' . $itemString . '
				</BillAdd>
			</BillAddRq>
		</QBXMLMsgsRq>
    </QBXML>';
    
    /* EXPENSE ITEM
        <ExpenseLineAdd>
            <AccountRef>
                <FullName>Automobile Expense</FullName>
            </AccountRef>
            <Amount>1000.00</Amount>
            <Memo>Test Comments</Memo>
        </ExpenseLineAdd>
	 */

	 //<BillableStatus>Billable</BillableStatus>

	return xmlEscape($qbxml);
}

function _quickbooks_credit_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	$items = $extra;

	$itemString = '';
	$vendor = $items[0]['vendor'];
	$purchaseId = '2018-' . $items[0]['purchase_id'];
	$date = $items[0]['purchase_date'];

	uasort($items, function ($a, $b) {
		return strcmp($a['cost_class'], $b['cost_class']);
	});

	foreach ($items as $item) {
		$amount = number_format((float)$item["amount"], 2, '.', '');
		if ($item['cost_class'] == 'ITEM') {
			$itemString .= '
			<ItemLineAdd>
				<ItemRef>
					<FullName>' . $item["cost_code"] . '</FullName>
				</ItemRef>
				'. addMemoDescExisting($item) .'
				<Quantity>' . $item["quantity"] . '</Quantity>
				<Amount>' . $amount . '</Amount>
				' . addCustomerRefIfExisting($item) . '
				' . addClassRefIfExisting($item) . '
			</ItemLineAdd>
			';
		} else { // EXPENSE
			$itemString .= '
			<ExpenseLineAdd>
				<AccountRef>
					<FullName>' . $item["expense_account"] . '</FullName>
				</AccountRef>
				<Amount>' . $amount . '</Amount>
				'. addMemoExisting($item) .'
				' . addCustomerRefIfExisting($item) . '
				' . addClassRefIfExisting($item) . '
			</ExpenseLineAdd>
			';
		}
	}

	// Create and return a qbXML request
	$qbxml = '<?xml version="1.0" ?>
	<?qbxml version="13.0"?>
	<QBXML>
		<QBXMLMsgsRq onError="continueOnError">
			<VendorCreditAddRq>
				<VendorCreditAdd>
					<VendorRef>
						<FullName>' . $vendor . '</FullName>
					</VendorRef>
					<TxnDate>' . $date . '</TxnDate>
					<RefNumber>' . $purchaseId . '</RefNumber>
					<Memo />
					' . $itemString . '
				</VendorCreditAdd>
			</VendorCreditAddRq>
		</QBXMLMsgsRq>
    </QBXML>';
    
    /* EXPENSE ITEM
        <ExpenseLineAdd>
            <AccountRef>
                <FullName>Automobile Expense</FullName>
            </AccountRef>
            <Amount>1000.00</Amount>
            <Memo>Test Comments</Memo>
        </ExpenseLineAdd>
	 */

	 //<BillableStatus>Billable</BillableStatus>
	return xmlEscape($qbxml);
}

function _quickbooks_creditcardcharge_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	$items = $extra;

	$itemString = '';
	$paymentType = str_replace(chr(194), "", $items[0]['payment_type']);
	$vendor = $items[0]['vendor'];
	$purchaseId = '2018-' . $items[0]['purchase_id'];
	$date = $items[0]['purchase_date'];

	uasort($items, function ($a, $b) {
		return strcmp($a['cost_class'], $b['cost_class']);
	});

	foreach ($items as $item) {
		$amount = number_format((float)$item["amount"], 2, '.', '');
		if ($item['cost_class'] == 'ITEM') {
			$itemString .= '
			<ItemLineAdd>
				<ItemRef>
					<FullName>' . $item["cost_code"] . '</FullName>
				</ItemRef>
				'. addMemoDescExisting($item) .'
				<Quantity>' . $item["quantity"] . '</Quantity>
				<Amount>' . $amount . '</Amount>
				' . addCustomerRefIfExisting($item) . '
				' . addClassRefIfExisting($item) . '
			</ItemLineAdd>
			';
		} else { // EXPENSE
			$itemString .= '
			<ExpenseLineAdd>
				<AccountRef>
					<FullName>' . $item["expense_account"] . '</FullName>
				</AccountRef>
				<Amount>' . $amount . '</Amount>
				'. addMemoExisting($item) .'
				' . addCustomerRefIfExisting($item) . '
				' . addClassRefIfExisting($item) . '
			</ExpenseLineAdd>
			';
		}
	}

	// Create and return a qbXML request
	$qbxml = '<?xml version="1.0" ?>
	<?qbxml version="13.0"?>
	<QBXML>
		<QBXMLMsgsRq onError="continueOnError">
			<CreditCardChargeAddRq>
				<CreditCardChargeAdd>
					<AccountRef>
						<FullName>' . $paymentType . '</FullName>
					</AccountRef>
					<PayeeEntityRef>
						<FullName>' . $vendor . '</FullName>
					</PayeeEntityRef>
					<TxnDate>' . $date . '</TxnDate>
					<RefNumber>' . $purchaseId . '</RefNumber>
					<Memo />
					' . $itemString . '
				</CreditCardChargeAdd>
			</CreditCardChargeAddRq>
		</QBXMLMsgsRq>
    </QBXML>';
    
    /* EXPENSE ITEM
        <ExpenseLineAdd>
            <AccountRef>
                <FullName>Automobile Expense</FullName>
            </AccountRef>
            <Amount>1000.00</Amount>
            <Memo>Test Comments</Memo>
        </ExpenseLineAdd>
	 */

	 //<BillableStatus>Billable</BillableStatus>
	return xmlEscape($qbxml);
}

function _quickbooks_creditcardcredit_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	$items = $extra;

	$itemString = '';
	$paymentType = str_replace(chr(194), '', $items[0]['payment_type']);
	$vendor = $items[0]['vendor'];
	$purchaseId = '2018-' . $items[0]['purchase_id'];
	$date = $items[0]['purchase_date'];

	uasort($items, function ($a, $b) {
		return strcmp($a['cost_class'], $b['cost_class']);
	});

	foreach ($items as $item) {
		$amount = number_format((float)$item["amount"], 2, '.', '');
		if ($item['cost_class'] == 'ITEM') {
			$itemString .= '
			<ItemLineAdd>
				<ItemRef>
					<FullName>' . $item["cost_code"] . '</FullName>
				</ItemRef>
				'. addMemoDescExisting($item) .'
				<Quantity>' . $item["quantity"] . '</Quantity>
				<Amount>' . $amount . '</Amount>
				' . addCustomerRefIfExisting($item) . '
				' . addClassRefIfExisting($item) . '
			</ItemLineAdd>
			';
		} else { // EXPENSE
			$itemString .= '
			<ExpenseLineAdd>
				<AccountRef>
					<FullName>' . $item["expense_account"] . '</FullName>
				</AccountRef>
				<Amount>' . $amount . '</Amount>
				'. addMemoExisting($item) .'
				' . addCustomerRefIfExisting($item) . '
				' . addClassRefIfExisting($item) . '
			</ExpenseLineAdd>
			';
		}
	}

	// Create and return a qbXML request
	$qbxml = '<?xml version="1.0" ?>
	<?qbxml version="13.0"?>
	<QBXML>
		<QBXMLMsgsRq onError="continueOnError">
			<CreditCardCreditAddRq>
				<CreditCardCreditAdd>
					<AccountRef>
						<FullName>' . $paymentType . '</FullName>
					</AccountRef>
					<PayeeEntityRef>
						<FullName>' . $vendor . '</FullName>
					</PayeeEntityRef>
					<TxnDate>' . $date . '</TxnDate>
					<RefNumber>' . $purchaseId . '</RefNumber>
					<Memo />
					' . $itemString . '
				</CreditCardCreditAdd>
			</CreditCardCreditAddRq>
		</QBXMLMsgsRq>
    </QBXML>';
    
    /* EXPENSE ITEM
        <ExpenseLineAdd>
            <AccountRef>
                <FullName>Automobile Expense</FullName>
            </AccountRef>
            <Amount>1000.00</Amount>
            <Memo>Test Comments</Memo>
        </ExpenseLineAdd>
	 */

	 //<BillableStatus>Billable</BillableStatus>
	return xmlEscape($qbxml);
}

function _quickbooks_vendor_add_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{

	$qbxml = '<?xml version="1.0" ?>
	<?qbxml version="7.0"?>
	<QBXML>
		<QBXMLMsgsRq onError="continueOnError">
			<VendorAddRq requestID="' . $requestID . '">
				<VendorAdd>
					<Name>' . $extra["name"] . '</Name>
					<IsActive>1</IsActive>
				</VendorAdd>
			</VendorAddRq>
		</QBXMLMsgsRq>
	</QBXML>';

	return $qbxml;
}




/**
 * Receive a response from QuickBooks 
 * 
 * @param string $requestID					The requestID you passed to QuickBooks previously
 * @param string $action					The action that was performed (CustomerAdd in this case)
 * @param mixed $ID							The unique identifier of the record
 * @param array $extra			
 * @param string $err						An error message, assign a valid to $err if you want to report an error
 * @param integer $last_action_time			A unix timestamp (seconds) indicating when the last action of this type was dequeued (i.e.: for CustomerAdd, the last time a customer was added, for CustomerQuery, the last time a CustomerQuery ran, etc.)
 * @param integer $last_actionident_time	A unix timestamp (seconds) indicating when the combination of this action and ident was dequeued (i.e.: when the last time a CustomerQuery with ident of get-new-customers was dequeued)
 * @param string $xml						The complete qbXML response
 * @param array $idents						An array of identifiers that are contained in the qbXML response
 * @return void
 */
function _quickbooks_bill_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{
}

/** 
 * Try to handle an error 
 * 
 * @param string $requestID
 * @param string $user         This is the username of the connected Web Connector user
 * @param string $action       The action type that experienced an error (i.e. QUICKBOOKS_ADD_CUSTOMER, or QUICKBOOKS_QUERY_CUSTOMER, or etc.)
 * @param string $ID           The $ID value of the record that experienced an error (usually your primary key for this record)
 * @param array $extra 
 * @param string $err          If an error occurs **within the error handler**, put an error message here (i.e. if your error handler experienced an internal error), otherwise, leave this NULL
 * @param string $xml
 * @param string $errnum       The error number or error code which occurred
 * @param string $errmsg       The error message received from QuickBooks 
 * @return boolean             Return TRUE if the error was handled and you want to continue processing records, or FALSE otherwise
 */
function projectpro_error_handler($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
    // ...
	return true;     // return TRUE if you want the Web Connector to continue to process requests
    // return false;    // return FALSE if you want the Web Connector to stop processing requests and report the error
}

function xmlEscape($string) {
    return str_replace(array("&", "'"), array('&amp;','&apos;'), $string);
}