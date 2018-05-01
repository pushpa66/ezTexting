<?php
/**
 * Created by PhpStorm.
 * User: pushpe
 * Date: 4/30/18
 * Time: 8:58 PM
 */

namespace AppBundle\Controller;


use AppBundle\Config\Configuration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SendingSmsMessageController
{
    /**
     * @Route("/api/sms/send", name="sendSmsMessage")
     */
    public function sendSmsMessage(Request $request){

        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password,
            'PhoneNumbers'  => array('2123456785', '2123456786', '2123456787', '2123456788'),
            'Groups'        => array('honey lovers'),
            'Subject'       => 'From Winnie',
            'Message'       => 'I am a Bear of Very Little Brain, and long words bother me',
            'StampToSend'   => '1305582245',
            'MessageTypeID' => 1
        );

        $curl = curl_init('https://app.eztexting.com/sending/messages?format=json');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // If you experience SSL issues, perhaps due to an outdated SSL cert
        // on your own server, try uncommenting the line below
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);

        $json = json_decode($response);
        $json = $json->Response;

        if ( 'Failure' == $json->Status ) {
            $errors = array();
            if ( !empty($json->Errors) ) {
                $errors = $json->Errors;
            }

            echo 'Status: ' . $json->Status . "\n" .
                'Errors: ' . implode(', ' , $errors) . "\n";
        } else {
            $phoneNumbers = array();
            if ( !empty($json->Entry->PhoneNumbers) ) {
                $phoneNumbers = $json->Entry->PhoneNumbers;
            }

            $localOptOuts = array();
            if ( !empty($json->Entry->LocalOptOuts) ) {
                $localOptOuts = $json->Entry->LocalOptOuts;
            }

            $globalOptOuts = array();
            if ( !empty($json->Entry->GlobalOptOuts) ) {
                $globalOptOuts = $json->Entry->GlobalOptOuts;
            }

            $groups = array();
            if ( !empty($json->Entry->Groups) ) {
                $groups = $json->Entry->Groups;
            }

            echo 'Status: ' . $json->Status . "\n" .
                'Message ID : ' . $json->Entry->ID . "\n" .
                'Subject: ' . $json->Entry->Subject . "\n" .
                'Message: ' . $json->Entry->Message . "\n" .
                'Message Type ID: ' . $json->Entry->MessageTypeID . "\n" .
                'Total Recipients: ' . $json->Entry->RecipientsCount . "\n" .
                'Credits Charged: ' . $json->Entry->Credits . "\n" .
                'Time To Send: ' . $json->Entry->StampToSend . "\n" .
                'Phone Numbers: ' . implode(', ' , $phoneNumbers) . "\n" .
                'Groups: ' . implode(', ' , $groups) . "\n" .
                'Locally Opted Out Numbers: ' . implode(', ' , $localOptOuts) . "\n" .
                'Globally Opted Out Numbers: ' . implode(', ' , $globalOptOuts) . "\n";
        }

        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }
}