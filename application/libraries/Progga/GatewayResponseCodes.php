<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GatewayResponseCodes
 *
 * @author sabina
 */
class GatewayResponseCodes
{
    //put your code here
    CONST Success = 100,
        AcceptedForDelivery = 101,
        NoMessage = 102,
        PartialFail = 103,
        FullFail= 104,
        InsufficientBalance= 105,
        InvalidID= 106,
        InvalidUsername= 107,
        InvalidPassword= 108,
        InvalidSendTime= 109,
        InvalidRequest= 110,
        InvalidLogin= 111,
        InvalidCharacterInMessage= 112,
        InvalidMobileNumber= 113,
        InvalidTitle= 114,
        InvalidMessageLength= 115,
        InvalidTemplateID= 116,
        InvalidListID= 117,
        DuplicateID= 118,
        DuplicateListName= 119,
        CreateSuccessfull= 120,
        CreateFailed= 121,
        InvalidListName= 122,
        InvalidTemplate= 123,
        DuplicateCustomField= 124,
        InvalidCustomField= 125,
        DuplicateMobileNumber= 126,
        ServerError= 127,
        UnknownState= 128,
        DeleteFailed= 129,
        DeleteSuccessful= 130,
        EditFailed= 131;
}
