<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Messages
 *
 * @author sabina
 */
class Messages {
    //put your code here
         const  notification_NoMessageToSend = "There is no message to send.";
         const  notification_FailedToSend = "Message sending failed.";
         const  notification_SomeMessagesFailed = "Failed to send some messages.";
         const  notification_AcceptedForDelivery = "Message accepted for delivery.";
         const  notification_InvalidLogin = "Invalid login information.";
         const  notification_StateIsUnknown = "The state is unknown.";
         const  notification_InvalidCharacterInMessage = "There is invalid character in some of the messages.";
         const  notification_InvalidMobielNumber = "Some or all of the mobile numbers has invalid format for current campaign type.";
         const  notification_DuplicateID = "ID is duplicate, it must be unique for each message.";
         const  notification_InsufficientBalance = "Your balance is not sufficient for sending all SMS.";
         const  notification_InvalidMessageLength = "Message text is either empty or too long.";
         const  notification_IDNotSet = "ID is not set, each message must have an unique ID.";
         const  notification_ValidationSuccessful = "Request validation is successful.";
         const  notification_InvalidUsername = "Username is invalid.";
         const  notification_InvalidPassword = "Password is invalid.";
         const  notification_ServerError = "There was an unknown server error, please contact administrator.";
         const  notification_InvalidSendTime = "Invalid schedule time.";
         const  notification_Success = "Sending successful.";
         const  notification_InvalidTemplateID = "Invalid template ID.";
         const  notification_InvalidListID = "Invalid list ID.";
         const  notification_InvalidTitle = "Invalid campaign title.";
         const  notification_CreateSuccessfull = "Create operation successfull.";
         const  notification_CreateFailed = "Create operation Failed.";
         const  notification_DuplicateListName = "Duplicate contact list name detected.";
         const  notification_InvalidListName = "Invalid contact list name detected";
         const  notification_InvalidTemplate = "Invalid template name/body";

         const  exception_InvalidRequest = "Base address or username or password is invalid.";
         const  exception_InvalidTemplateName = "Template name is invalid.";
}

