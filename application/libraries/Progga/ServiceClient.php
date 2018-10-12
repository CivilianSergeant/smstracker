<?php
require_once 'TextMessageRequest.php';
require_once 'GatewayResponse.php';
require_once 'GatewayResponseCodes.php';
require_once 'Messages.php';
require_once 'Recipient.php';
require_once 'CampaignRequest.php';

class ServiceClient
{
    public $BaseAddress = '';

    public $UserName = '';

    public $Password = '';
    


    public function __construct($baseAddress, $userName, $password)
    {
        $this->BaseAddress = $baseAddress;
        $this->UserName = $userName;
        $this->Password = $password;
    }

    public function getUniqId()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), // 32 bits for "time_low"
            mt_rand(0, 0xffff), // 16 bits for "time_mid"
            mt_rand(0, 0x0fff) | 0x4000, // 16 bits for "time_hi_and_version", four most significant bits holds version number 4
            mt_rand(0, 0x3fff) | 0x8000, // 16 bits, 8 bits for "clk_seq_hi_res", 8 bits for "clk_seq_low", two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff) // 48 bits for "node"
        );
    }
    
    private function Validate()
    {
        return true;
    }
    
    public function ChangePassword($oldPassword, $newPassword)
    {
        if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');
        $data = array(
        'Username' => $this->UserName,
        'Password' => $this->Password,
        'NewPassword' => $newPassword   
        );
        return json_decode($this->CallRequest($data, "ChangePassword"));
    }
    
    public function GetAllIncomingMessages()
    {
        if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');
        $data = array(
                    'Username' => $this->UserName,
                    'Password' => $this->Password
        );
        return json_decode($this->CallRequest($data, "GetAllIncomingRequest"));
    }
    
    public function GetListByName($listName)
    {
        if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');
        if (!empty($listName) && !is_null($listName))
        {
            $data = array( 
                    'Username' => $this->UserName,
                    'Password' => $this->Password,
                    'ListName' => $listName
            );
            return json_decode($this->CallRequest($data, "GetListByName"));
        }
        else
            throw new Exception("Invalid List Name");
    } 
    
    public function GetListByID($listID)
    {
        if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');
        if (!empty($listID) && !is_null($listID))
        {
            $data = array( 
                    'Username' => $this->UserName,
                    'Password' => $this->Password,
                    'ListID' => $listID
            );
            return json_decode($this->CallRequest($data, "GetList"));
        }
        else
            throw new Exception("Invalid List ID");
    }
    
    public function CreateList($listName)
    {
        $response= new GatewayResponse();

        if (!empty($listName) && !is_null($listName)) 
        {
            $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'ListName' => $listName
            );

            return json_decode($this->CallRequest($data, "CreateList"));
        } 
        else {
            $response->Code = (int)GatewayResponseCodes::InvalidListName;
            $response->Message = Messages::notification_InvalidListName;
            return $response;
        }
    }
        
    public function EditList($listID, $newListName)
    {
        if (!$this->Validate()) 
            throw new Exception('Base address or username or password is invalid');
        
        if (empty($listID))
            throw new Exception("Invalid List ID");

        $response = new GatewayResponse();

        if (!empty($newListName) && !is_null($newListName))
        {
            $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'ListID' => $listID,
                'NewListName' => $newListName
            );
            
            return json_decode($this->CallRequest($data, "EditList"));
        }
        else
        {
            $response->Code = (int)GatewayResponseCodes::InvalidListName;
            $response->Message = Messages::notification_InvalidListName;
            return $response;
        }
    }
    
     public function DeleteList($listID)
    {
        if (!$this->Validate())
        throw new Exception('Base address or username or password is invalid');
        
        if (!empty($listID) && !is_null($listID)) 
        {
            $data = array( 
                    'Username' => $this->UserName,
                    'Password' => $this->Password,
                    'ListID' => $listID
            );
            return json_decode($this->CallRequest($data, "DeleteList"));  
        }
        else
            throw new Exception("Invalid List ID");
    }
    
    public function GetAllLists()
    {
        if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');
        $data = array( 
                    'Username' => $this->UserName,
                    'Password' => $this->Password
        );
        return json_decode($this->CallRequest($data, "GetAllLists")); 
    }
    
    public function CreateTemplate($templateName, $templateBody)
    {
        if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');
        $response = new GatewayResponse();
        if (!empty($templateName) && !empty($templateBody) && !is_null($templateName) && !is_null($templateBody)) {
            $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'TemplateName' => $templateName,
                'TemplateBody'=> $templateBody
            );
            return json_decode($this->CallRequest($data, "CreateTemplate"));
        } else {
            $response->Code = (int)GatewayResponseCodes::InvalidTemplate;
            $response->Message = Messages::notification_InvalidTemplate;
            return $response;
        }
    } 
    
    public function GetTemplateByName($templateName)
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');

        if (!empty($templateName) && !is_null($templateName)) 
        {
            $data = array( 
                    'Username' => $this->UserName,
                    'Password' => $this->Password,
                    'TemplateName' => $templateName
            );
            return json_decode($this->CallRequest($data, "GetTemplateByName"));
        }
        else
            throw new Exception(" Invalid Template Name");
    }
    
    public function GetTemplateByID($templateID)
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');

        if (!empty($templateID))
        {
            $data = array( 
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'TemplateID' => $templateID
                );

            return json_decode($this->CallRequest($data, "GetTemplate"));
        }
        else
            throw new Exception("Invalid Template ID");
    }
    
    public function DeleteTemplate($templateID)
    {
        if (!$this->Validate())
        throw new Exception('Base address or username or password is invalid');
        $data = array(
            'Username' => $this->UserName,
            'Password' => $this->Password,
            'TemplateID' => $templateID
        );

        return json_decode($this->CallRequest($data, "DeleteTemplate"));
    } 
    
    public function EditTemplate($templateID, $newTemplateName, $newTemplateBody)
    {
       if (!$this->Validate()) 
            throw new Exception('Base address or username or password is invalid');

        if (empty($templateID))
            throw new Exception('Template ID missing');

        $response = new GatewayResponse();
        if (!empty($newTemplateName) && !is_null($newTemplateName)) 
        {
            $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'TemplateID' => $templateID,
                'NewTemplateName' => $newTemplateName,
                'NewMessageBody' => $newTemplateBody
            );
            
            return json_decode($this->CallRequest($data, "EditTemplate"));
        }
        else
        {
            $response->Code = (int)GatewayResponseCodes::InvalidTemplateName;
            $response->Message = Messages::notification_InvalidTemplateName;
            return $response;
        }
        
    } 
    
    public function GetAllTemplates()
    {
        if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');
        $data = array( 
                'Username' => $this->UserName,
                'Password' => $this->Password
        );
        return json_decode($this->CallRequest($data, "GetAllTemplates"));
    }
    
    public function AddRecipientToList(Recipient $contact)
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');

        $response = new GatewayResponse();
        if (!is_null($contact) && !empty($contact->MobileNumber) && !is_null($contact->MobileNumber))
        {
            $data = array( 
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'ListID' => $contact->ListID,
                'MobileNumber' => $contact->MobileNumber,
                'AdditionalKeyItems' => $contact->AdditionalFields->AdditionalKeyItems,
                'AdditionalValueItems' => $contact->AdditionalFields->AdditionalValueItems
            );
            return json_decode($this->CallRequest($data, "AddRecipientToList"));
        }
        else
        {
            $response->Code = (int)GatewayResponseCodes::InvalidRequest;
            $response->Message = Messages::exception_InvalidRequest;
            return $response;
        }

    }

    public function AddRecipientsToList($contacts)
    {
        if (!$this->Validate())
            throw new Exception('InvalidOperationException');

        $response = new GatewayResponse();
        if ($contacts != null && count($contacts) > 0) {
            try {
		$mobContacts = array();
		foreach ($contacts as $contact) {
		    $object = new stdClass();
		    $object->ListID = $contact->ListID;
		    $object->MobileNumber = $contact->MobileNumber;
		    $object->AdditionalKeyItems = $contact->AdditionalFields->AdditionalKeyItems;
		    $object->AdditionalValueItems = $contact->AdditionalFields->AdditionalValueItems;
		    $mobContacts[] = $object;
		}
                $data = array(
                    'Username' => $this->UserName,
                    'Password' => $this->Password,
                    'MobileContacts' => $mobContacts
                );
                return json_decode($this->CallRequest($data, "AddRecipientsToList"));
            } 
            catch (Exception $e) {
                $response->Code = (int)GatewayResponseCodes::InvalidRequest;
                $response->Message = Messages::exception_InvalidRequest;
                return $response;
            }
        } else {
            $response->Code = (int)GatewayResponseCodes::InvalidRequest;
            $response->Message = Messages::exception_InvalidRequest;
            return $response;
        }
    }

    
    public function GetRecipient($recipientID)
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');

        if (!empty($recipientID))
        {
            $data = array( 
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'RecipientID' => $recipientID
            );
            return json_decode($this->CallRequest($data, "GetRecipient"));
        }
        else
            throw new Exception("Invalid Recipient ID");
    }
    
    public function EditRecipient(Recipient $contact)
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');

        $response = new GatewayResponse();
        if (!is_null($contact) && !empty($contact->MobileNumber) && !is_null($contact->MobileNumber))
        {
            $data = array( 
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'RecipientID' => $contact->ID,
                'ListID' => $contact->ListID,
                'MobileNumber' => $contact->MobileNumber,
                'AdditionalKeyItems' => $contact->AdditionalFields->AdditionalKeyItems,
                'AdditionalValueItems' => $contact->AdditionalFields->AdditionalValueItems
            );
           return json_decode($this->CallRequest($data, "EditRecipient"));
        }
        else
        {
            $response->Code = (int)GatewayResponseCodes::InvalidRequest;
            $response->Message = Messages::exception_InvalidRequest;
            return $response;
        }
    }
    
    public function GetAllRecipientsFromList($listID)
    {
        if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');
        
        if (!empty($listID))
        {    
            $data = array( 
                        'Username' => $this->UserName,
                        'Password' => $this->Password,
                        'ListID' => $listID
                    ); 
            return json_decode($this->CallRequest($data, "GetAllListRecipients")); 
        }
        else
        throw new Exception("Invalid List ID");
        
    } 
     
    public function DeleteRecipient($recipientID)
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');
        if (!empty($recipientID))
        { 
            $data = array( 
                    'Username' => $this->UserName,
                    'Password' => $this->Password,
                    'RecipientID' => $recipientID
            );
            return json_decode($this->CallRequest($data, "DeleteRecipient"));
        }
        else
        throw new Exception("Invalid Recipient ID");
    }
   
    public function CreateCustomField($customFieldName) 
    {
        if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');

        $response = new GatewayResponse();
        if (!is_null($customFieldName) && !empty($customFieldName))
        {
            $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'CustomFieldName' => $customFieldName
            );
            return json_decode($this->CallRequest($data, "CreateCustomField"));
        }
        else
        {
            $response->Code = (int)GatewayResponseCodes::InvalidTemplate;
            $response->Message = Messages::notification_InvalidTemplate;
            return $response;
        }
    }
    
    public function EditCustomField($customFieldID, $newCustomFieldName) 
    {
        if (!$this->Validate()) 
            throw new Exception('Base address or username or password is invalid');

        $response = new GatewayResponse();
        if (!empty($customFieldID) && !empty($newCustomFieldName) && !is_null($customFieldID) && !is_null($newCustomFieldName))
        {
            $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'CustomFieldID' => $customFieldID,
                'CustomFieldName' => $newCustomFieldName     
            );
            return json_decode($this->CallRequest($data, "EditCustomField"));
        }
        else
        {
            $response->Code = (int)GatewayResponseCodes::InvalidCustomField;
            $response->Message = Messages::notification_InvalidCustomField;
            return $response;
        }
    }
    
    public function DeleteCustomField($customFieldID)
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');
        
        $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'CustomFieldID' => $customFieldID    
        );
        return json_decode($this->CallRequest($data, "DeleteCustomField"));
    }
    
    public function GetAllCustomFields()
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');
        
        $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password  
        );
        return json_decode($this->CallRequest($data, "GetAllCustomFields"));
    }
    
    public function GetCustomField($customFieldID)
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');
        $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'CustomFieldID' => $customFieldID
        );
        return json_decode($this->CallRequest($data, "GetCustomField"));
    }
    
    public function GetCost($listID, $templateID)
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');
        
        $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password,
                'ListID' => $listID,
                'TemplateID' => $templateID
            
        );
        return json_decode($this->CallRequest($data, "GetCost"));
    }

    public function SendSingleSMS(TextMessageRequest $request)
    {
       
        if ($request == null)
            throw new Exception("No msg to send");

        if (!$this->Validate())
            throw new Exception("Invalid Request");

        $response = $request->Validate(100);
        if ($response->Code != (int)GatewayResponseCodes::Success)
        {
            return $response;
        }

        $data = array(
            'Username' => $this->UserName,
            'Password' => $this->Password,
            'MobileNumber' => $request->MobileNumber,
            'MessageBody' => $request->MessageBody,
            'ID' => $request->ID,
            'SendTime' => $request->SendTime
            );
        return json_decode($this->CallRequest($data, "SendSingleSMS"));
    }
    
    
   public function SendMultiSMS(MultiSMSRequest $request)
    {
       if ($request == null)
        throw new Exception("No msg to send");

        if (!$this->Validate())
        throw new Exception("Invalid Request");

        $response = $request->Validate();
        if ($response->Code != (int)GatewayResponseCodes::Success) {
            return $response;
        }

        $data = array(
            'Username' => $this->UserName,
            'Password' => $this->Password,
            'SendTime' => $request->SendTime,
            'SenderIDs' => $request->SenderIDs,
            'MobileNumbers' => $request->MobileNumbers,
            'MessageIDs' => $request->MessageIDs,
            'CampaignTitle' => $request->CampaignTitle,
            'Messages' => $request->Messages,
            'ContentType' => $request->ContentType

            ); 
        return json_decode($this->CallRequest($data, "SendMultiSMSWithSender"));

    }

    public function SendSMSCampaign(CampaignRequest $request)
    {
       if (!$this->Validate())
            throw new Exception('Base address or username or password is invalid');

        $response = $request->Validate();
        if ($response->Code != (int)GatewayResponseCodes::Success) {
            return $response;
        }
        
        $data = array( 
            'Username' => $this->UserName,
            'Password' => $this->Password,
            'CampaignTitle' => $request->CampaignTitle,
            'TemplateID' => $request->TemplateID,
            'ListID' => $request->ListID,
            'SendTime' => $request->SendTime 
        );
        return json_decode($this->CallRequest($data, "SendSMSCampaign"));
    }
    
    public function GetAllCampaigns()
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');
        
        $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password
            
        );
        return json_decode($this->CallRequest($data, "GetAllCampaigns"));
    }
   
    public function GetBalance()
    {
        if (!$this->Validate()) 
        throw new Exception('Base address or username or password is invalid');
        
        $data = array(
                'Username' => $this->UserName,
                'Password' => $this->Password
            
        );
        return json_decode($this->CallRequest($data, "GetBalance"));
    }
 
    private function CallRequest($callParameters, $callMethod)
    {
        $jsonData = str_replace('\\/', '/', json_encode($callParameters));
        $ch = curl_init($this->BaseAddress . "/" . $callMethod);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($jsonData))                                                                       
        );                                                                                                                   

        $result = curl_exec($ch);
        return json_decode($result);
    }

}