<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of function_helper
 *
 * @author Himel
 */
if ( ! function_exists('generateClientId'))
{
    function generateClientId()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz.0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $token1 = ""; $token2 = ""; $token3 = "";    

        for ($p = 0; $p < 20; $p++) {

            $token1 .= $characters[mt_rand(0, strlen($characters)-1)];

            $token2 .= $characters[mt_rand(0, strlen($characters)-1)];

            $token3 .= $characters[mt_rand(0, strlen($characters)-1)];

        }
        return substr($token1.$token2.$token3,0,19);
    }
    
}

if ( ! function_exists('generateAccessToken'))
{
    
    
}


