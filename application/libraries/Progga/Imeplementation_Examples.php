<?php
require_once 'ServiceClient.php';
require_once 'TextMessageRequest.php';
require_once 'Recipient.php';
require_once 'CustomFieldNameValueContainer.php';
require_once 'CampaignRequest.php';
require_once 'SMSTypes.php';
require_once 'MultiSMSRequest.php';

$serviceClient = new ServiceClient('http://www.sms4bd.net/OutboundChannel.svc', 'username', 'password');
$uniqId = $serviceClient->getUniqId();
date_default_timezone_set('UTC');
$sendTime = gmmktime(hour,minute,second,month,date,year);

//Change Your Password Here
/*
$oldPassword = "";
$newPassword = "";
echo $serviceClient->ChangePassword($oldPassword, $newPassword);
 */

//Get All IncomingMessages
//print_r($serviceClient->GetAllIncomingMessages()); 
//Status: Array()

//Get List By Name
//$listName = "MunMun's Client";
//print_r($serviceClient->GetListByName($listName));
//Status: stdClass Object ( [ID] => 3911d009-0f74-cd29-5192-08cfa5930db9 [Name] => Priti's Client [CreateDate] => /Date(1355215549155)/ [ClientID] => a1dd1b56-eda7-ca35-ea43-08cea6829f0a [ContactsCount] => 0 [LastModified] => /Date(1355215549155)/ ) 

//Get List By ID
//$listID = "3911d009-0f74-cd29-5192-08cfa5930db9";
//print_r($serviceClient->GetListByID($listID));
//Status: stdClass Object ( [ID] => 3911d009-0f74-cd29-5192-08cfa5930db9 [Name] => Priti's Client [CreateDate] => /Date(1355215549155)/ [ClientID] => a1dd1b56-eda7-ca35-ea43-08cea6829f0a [ContactsCount] => 0 [LastModified] => /Date(1355215549155)/ ) 

// Create List
//$listName = "MunMun's Client";
//print_r($serviceClient->CreateList($listName));
//Status: stdClass Object ( [Message] => Create operation successful. [Code] => 120 ) 

// Edit List
//$listID = "41fa39e1-a8ab-cca8-bb32-08cfa59691f3";
//$newListName = "MunMun's Client";
//print_r($serviceClient->EditList($listID, $newListName));
//Status: stdClass Object ( [Message] => Edit operation successful. [Code] => 132 ) 

// Get All List
//print_r($serviceClient->GetAllLists());
//Status: Array ( [0] =>  [2] => stdClass Object ( [ID] => 019dcfb9-5be5-ce35-71d8-08cfa70c8988 [Name] => MunMun's Client [CreateDate] => /Date(1355377677139)/ [ClientID] => a1dd1b56-eda7-ca35-ea43-08cea6829f0a [ContactsCount] => 0 [LastModified] => /Date(1355377677139)/ ) ) 


// Delete List
//$listID = "41fa39e1-a8ab-cca8-bb32-08cfa59691f3"; // "MunMun's Client";
//print_r($serviceClient->DeleteList($listID));
//Status: stdClass Object ( [Message] => Delete operation Successful. [Code] => 130 ) 


// Create Template
//$templateName = "Eid-Ul-Azha";
//$templateBody = "Eid Mubarak to all";
//print_r($serviceClient->CreateTemplate($templateName, $templateBody));
//Status: stdClass Object ( [Message] => Create operation successful. [Code] => 120 ) 


 //Get Template By Name
//$templateName = "Eid-Ul-Azha";
//print_r($serviceClient->GetTemplateByName($templateName));
//stdClass Object ( [ID] => 66fc548e-011e-c754-0926-08cfa599b1e1 [Name] => Eid-Ul-Azha [Body] => Eid Mubarak to all [CreateDate] => /Date(1355218401542)/ [LastModified] => /Date(1355218401542)/ [ClientID] => a1dd1b56-eda7-ca35-ea43-08cea6829f0a ) 


// Get Template By ID
//$templateID = "66fc548e-011e-c754-0926-08cfa599b1e1";
//print_r($serviceClient->GetTemplateByID($templateID));
//Satus: stdClass Object ( [ID] => 66fc548e-011e-c754-0926-08cfa599b1e1 [Name] => Eid-Ul-Azha [Body] => Eid Mubarak to all [CreateDate] => /Date(1355218401542)/ [LastModified] => /Date(1355218401542)/ [ClientID] => a1dd1b56-eda7-ca35-ea43-08cea6829f0a ) 

// Get All Template
//print_r($serviceClient->GetAllTemplates());
//Satus: Array ( [0] => stdClass Object ( [Name] => Test template [Body] => Hello @@First Name@@ @@Last Name@@, Welcome to SMS4BD [CreateDate] => /Date(1354061841610)/ [ClientID] => a1dd1b56-eda7-ca35-ea43-08cea6829f0a [Client] => [LastModified] => /Date(1354061841610)/ [ID] => 55dbce89-b715-c28d-3354-08cf9b47290b ) [1] => stdClass Object ( [Name] => Eid-Ul-Azha [Body] => Eid Mubarak to all [CreateDate] => /Date(1355218401542)/ [ClientID] => a1dd1b56-eda7-ca35-ea43-08cea6829f0a [Client] => [LastModified] => /Date(1355218401542)/ [ID] => 66fc548e-011e-c754-0926-08cfa599b1e1 ) ) 

// Edit Template
//$templateID = "66fc548e-011e-c754-0926-08cfa599b1e1";
//$newTemplateName = "Eid 2"; 
//$newTemplateBody = "Eid wishes for all";
//print_r($serviceClient->EditTemplate($templateID, $newTemplateName, $newTemplateBody));
//Satus: stdClass Object ( [Message] => Edit operation successful. [Code] => 132 ) 

// Delete Template
//$templateID = "66fc548e-011e-c754-0926-08cfa599b1e1";
//print_r($serviceClient->DeleteTemplate($templateID));
//Satus: stdClass Object ( [Message] => Delete operation Successful. [Code] => 130 ) 


//Add Single Recipient to List
//$custom = new CustomFieldNameValueContainer();
//$custom->AddItem('FirstName', 'Sabina')->AddItem('LastName', 'Yasmin');
//$contact = new Recipient();
//$contact->MobileNumber = "01915750937";
//$contact->AdditionalFields = $custom;
//$contact->ListID = "019dcfb9-5be5-ce35-71d8-08cfa70c8988"; // Pritis Client
//print_r($serviceClient->AddRecipientToList($contact));
//Satus:  stdClass Object ( [Message] => Create operation successful. [Code] => 120 )  //Not adding the firstname and lastname



//Add  Recipients to List

//$contactArray = array();
//
//$custom1 = new CustomFieldNameValueContainer();
//$custom1->AddItem('FirstName', 'Shovon')->AddItem('LastName', 'Junayed');
//
//$contact1 = new Recipient();
//$contact1->MobileNumber = "01916750937";
//$contact1->ListID = "019dcfb9-5be5-ce35-71d8-08cfa70c8988"; // Munmun's Client
//$contact1->AdditionalFields = $custom1;
//$contactArray[] = $contact1;
//
//$custom2 = new CustomFieldNameValueContainer();
//$custom2->AddItem('FirstName', 'Bushra')->AddItem('LastName', 'Afroze');
//
//$contact2 = new Recipient();
//$contact2->MobileNumber = "01914168573";
//$contact2->ListID = "019dcfb9-5be5-ce35-71d8-08cfa70c8988"; // Pritis Client
//$contact2->AdditionalFields = $custom2;
//
//$contactArray[] = $contact2;
//
//$custom3 = new CustomFieldNameValueContainer();
//$custom3->AddItem('FirstName', 'Bulbul')->AddItem('LastName', 'Mamun');
//
//$contact3 = new Recipient();
//$contact3->MobileNumber = "01923617988";
//$contact3->ListID = "019dcfb9-5be5-ce35-71d8-08cfa70c8988"; // Pritis Client
//$contact3->AdditionalFields = $custom3;
//
//$contactArray[] = $contact3;
////
//print_r($serviceClient->AddRecipientsToList($contactArray));
//Satus:  Array ( [0] => stdClass Object ( [ID] => 6a50f533-0baa-c25d-8984-08cfa72eda9d [MobileNumber] => 8801911850937 [ListID] => 019dcfb9-5be5-ce35-71d8-08cfa70c8988 [AdditionalFields] => stdClass Object ( [CurrentIndex] => 0 [AdditionalKeyItems] => Array ( ) [AdditionalValueItems] => Array ( ) ) ) [1] => stdClass Object ( [ID] => 951933f0-f927-c15b-ada5-08cfa72edaa4 [MobileNumber] => 8801924617988 [ListID] => 019dcfb9-5be5-ce35-71d8-08cfa70c8988 [AdditionalFields] => stdClass Object ( [CurrentIndex] => 0 [AdditionalKeyItems] => Array ( ) [AdditionalValueItems] => Array ( ) ) ) [2] => stdClass Object ( [ID] => 8b14797c-bb87-cab3-ada5-08cfa72edaa4 [MobileNumber] => 8801914128573 [ListID] => 019dcfb9-5be5-ce35-71d8-08cfa70c8988 [AdditionalFields] => stdClass Object ( [CurrentIndex] => 0 [AdditionalKeyItems] => Array ( ) [AdditionalValueItems] => Array ( ) ) ) )



// Get All Recipient
//$listID = "019dcfb9-5be5-ce35-71d8-08cfa70c8988"; // Munmun's Client
//print_r($serviceClient->GetAllRecipientsFromList($listID));
//Status:Array ( [0] => stdClass Object ( [ID] => 698fa7d9-9aa7-c5a7-cdc2-08cfa71938d6 [MobileNumber] => 8801967526984 [ListID] => 019dcfb9-5be5-ce35-71d8-08cfa70c8988 [AdditionalFields] => stdClass Object ( [CurrentIndex] => 0 [AdditionalKeyItems] => Array ( ) [AdditionalValueItems] => Array ( ) ) ) [1] => stdClass Object ( [ID] => 65c49c1d-4732-c417-8e7f-08cfa7194e77 [MobileNumber] => 8801717579731 [ListID] => 019dcfb9-5be5-ce35-71d8-08cfa70c8988 [AdditionalFields] => stdClass Object ( [CurrentIndex] => 0 [AdditionalKeyItems] => Array ( ) [AdditionalValueItems] => Array ( ) ) ) )


// Get SIngle Recipient
//$recipientID = "863d240d-26ad-48ca-ae58-fc089991f4d0"; // Anindya
//print_r($serviceClient->GetRecipient($recipientID));
//Status: Array ( [0] => stdClass Object ( [ID] => a85c0c40-5ff0-c8d9-f49e-08cfa59e6198 [MobileNumber] => 8801716275838 [ListID] => 3911d009-0f74-cd29-5192-08cfa5930db9 [AdditionalFields] => stdClass Object ( [CurrentIndex] => 0 [AdditionalKeyItems] => Array ( ) [AdditionalValueItems] => Array ( ) ) ) )


// Edit a specific recipient
//$contact = new Recipient();
//$custom = new CustomFieldNameValueContainer();
//$custom->AddItem('FirstName', 'Anindya')->AddItem('LastName', 'Roy');
//$contact->MobileNumber = "01717579731";
//$contact->AdditionalFields = $custom;
//$contact->ListID = "3911d009-0f74-cd29-5192-08cfa5930db9"; // Priti's Client list
//$contact->ID = "a85c0c40-5ff0-c8d9-f49e-08cfa59e6198"; // Anindya
//print_r($serviceClient->EditRecipient($contact));
//Status: stdClass Object ( [Message] => Edit operation successful. [Code] => 132 ) 


// Delete a specific recipient
//$recipientID = "206e028c-27d3-c8ed-f471-08cfa72cbdba"; // Anindya
//print_r($serviceClient->DeleteRecipient($recipientID));
//Status: stdClass Object ( [Message] => Delete operation Successful. [Code] => 130 ) 

// Create a custom field
//$customFieldName = "Colour"; // Anindya
//print_r($serviceClient->CreateCustomField($customFieldName));
//Status: stdClass Object ( [Message] => Create operation successful. [Code] => 120 )  

// Edit a custom field
//$customFieldID ="dedf7d20-5371-ce64-7cd7-08cfa5a5eb11";
//$newCustomFieldName = "RONG";
//print_r($serviceClient->EditCustomField($customFieldID, $newCustomFieldName));
//Status: stdClass Object ( [Message] => Edit operation successful. [Code] => 132 ) 


// Delete a custom field
//$customFieldID ="dedf7d20-5371-ce64-7cd7-08cfa5a5eb11";
//print_r($serviceClient->DeleteCustomField($customFieldID));
//Status: stdClass Object ( [Message] => Delete operation Successful. [Code] => 130 ) 

// Get a specific custom field
//$customFieldID = "49d3314d-6dd7-c1d9-8f46-08cfa5a74eac";
//print_r($serviceClient->GetCustomField($customFieldID));
//Status: stdClass Object ( [ID] => 49d3314d-6dd7-c1d9-8f46-08cfa5a74eac [Name] => Colour ) 


// Get all custom field
//print_r($serviceClient->GetAllCustomFields());
//Status: Array ( [0] => stdClass Object ( [Name] => Colour [ClientID] => a1dd1b56-eda7-ca35-ea43-08cea6829f0a [Client] => [ID] => dedf7d20-5371-ce64-7cd7-08cfa5a5eb11 ) ) 


// Get Cost
//$listID = "3911d009-0f74-cd29-5192-08cfa5930db9";
//$templateID = " 31b03635-1548-c613-68b6-08cfa5a9de05";
//print_r($serviceClient->GetCost($listID, $templateID));
//Status: 1


// Send Single SMS

//$request = new TextMessageRequest($uniqId, 'Your Phone Number Here', "Hello recipient", $sendTime);
//
//$result = $serviceClient->SendSingleSMS($request);
//print_r($result);


// Send Multiple SMS

//$campaignTitle = "Your Campaign Title";
//$messageIDs = array ("GUID", "GUID");
//$senderIDs = array ("Sender ID", "Sender ID");
//$mobileNumbers = array ("Mobile Number", "Mobile Number");
//$messages = array ("Message Body", "Message Body");
//$contentType = (int)  SMSTypes::PlainText;
//$request = new MultiSMSRequest($campaignTitle, $sendTime, $messageIDs, $senderIDs, $mobileNumbers, $messages, $contentType);
//$result = $serviceClient->SendMultiSMS($request);
//print_r($result);


// Get All Campign
//print_r($serviceClient->GetAllCampaigns()); 
//
//Status : stdClass Object ( [Message] => Create operation successful. 
//[Code] => 120 ) Array ( [0] => stdClass Object ( [ID] => 7d37e977-8a9d-c4dd-82a6-08cf9b494154 
//[CampaignTitle] => Test [Template] => Hello @@First Name@ @@Last Name@@, Welcome to SMS4BD 
//[SendTime] => /Date(1354062749000)/ [TotalSent] => 2 [TotalCost] => 2 
//[TotalSentSuccess] => 2 [Canceled] => ) 
//[1] => stdClass Object ( [ID] => 725a2898-f4d0-cf44-a4e0-08cf9b4cdb54 
//[CampaignTitle] => Test 3 [Template] => Hello @@First Name@ @@Last Name@@, Welcome to SMS4BD 
//[SendTime] => /Date(1354064280000)/ [TotalSent] => 2 [TotalCost] => 2 
//[TotalSentSuccess] => 2 [Canceled] => ) [2] => 
//stdClass Object ( [ID] => e078202d-dfc3-cf6d-b6f4-08cf9b5d38fb
// [CampaignTitle] => Test 6 [Template] => Hello @@First Name@ @@Last Name@@, Welcome to SMS4BD 
// [SendTime] => /Date(1354071331000)/ [TotalSent] => 2 [TotalCost] => 2 [TotalSentSuccess] => 2 [Canceled] => ) [3] => stdClass Object ( [ID] => 7520da12-cd1b-cc31-7742-08cf9f734219 
// [CampaignTitle] => Test [Template] => Hello @@First Name@@ @@Last Name@@, Welcome to SMS4BD [SendTime] => /Date(1354520567000)/ [TotalSent] => 1 [TotalCost] => 1 [TotalSentSuccess] => 1 [Canceled] => ) [4] => stdClass Object ( [ID] => eb1a3813-5294-cab2-5251-08cfa26c325d [CampaignTitle] => Test 3 [Template] => Hello @@First Name@@ @@Last Name@@, Welcome to SMS4BD [SendTime] => /Date(1354847397000)/ [TotalSent] => 0 [TotalCost] => 0 [TotalSentSuccess] => 0 [Canceled] => ) [5] => stdClass Object ( [ID] => 17dd3230-5f9e-ca5f-8752-08cfa26c77ea [CampaignTitle] => Test 4 [Template] => Hello @@First Name@@ @@Last Name@@, Welcome to SMS4BD [SendTime] => /Date(1354847467000)/ [TotalSent] => 1 [TotalCost] => 1 [TotalSentSuccess] => 1 [Canceled] => ) [6] => stdClass Object ( [ID] => 9de56cbe-a40e-cf93-2fff-08cfa71a4b77 [CampaignTitle] => Test ABC [Template] => Eid Mubarak to all [SendTime] => /Date(1355383573)/ [TotalSent] => 2 [TotalCost] => 2 [TotalSentSuccess] => 2 [Canceled] => ) ) 


//Get Balance
//echo $serviceClient->GetBalance();


