<?php
/**
 * Created by PhpStorm.
 * User: pushpe
 * Date: 4/30/18
 * Time: 9:00 PM
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CreditsController
{
    /**
     * @Route("/api/credit/balance", name="checkCreditBalance")
     */
    public function checkCreditBalance(Request $request){
        $data = array(
            'User'     => 'winnie',
            'Password' => 'the-pooh'
        );

        $curl = curl_init('https://app.eztexting.com/billing/credits/get?format=json&' . http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
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
            echo 'Status: ' . $json->Status . "\n" .
                'Plan credits: ' . $json->Entry->PlanCredits . "\n" .
                'Anytime credits: ' . $json->Entry->AnytimeCredits . "\n" .
                'Total: ' . $json->Entry->TotalCredits . "\n";
        }

        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/credit/buy/stored", name="buyCreditWithStoredCard")
     */
    public function buyCreditWithStoredCard(Request $request){
        $data = array(
            'User'             => 'winnie',
            'Password'         => 'the-pooh',
            'NumberOfCredits'  => '1000',
            'CouponCode'       => 'honey2011',
            'StoredCreditCard' => '1111'
        );

        $curl = curl_init('https://app.eztexting.com/billing/credits?format=json');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
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
            echo 'Status: ' . $json->Status . "\n" .
                'Credits purchased: ' . $json->Entry->BoughtCredits . "\n" .
                'Amount charged, $: ' . sprintf("%01.2f", $json->Entry->Amount) . "\n" .
                'Discount, $: ' . sprintf("%01.2f", $json->Entry->Discount) . "\n" .
                'Plan credits: ' . $json->Entry->PlanCredits . "\n" .
                'Anytime credits: ' . $json->Entry->AnytimeCredits . "\n" .
                'Total: ' . $json->Entry->TotalCredits . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/credit/buy/non-stored", name="buyCreditWithNonStoredCard")
     */
    public function buyCreditWithNonStoredCard(Request $request){
        $data = array(
            'User'             => 'winnie',
            'Password'         => 'the-pooh',
            'NumberOfCredits'  => '1000',
            'CouponCode'       => 'honey2011',
            'FirstName'        => 'Winnie',
            'LastName'         => 'The Pooh',
            'Street'           => 'Hollow tree, under the name of Mr. Sanders',
            'City'             => 'Hundred Acre Woods',
            'State'            => 'New York',
            'Zip'              => '12345',
            'Country'          => 'US',
            'CreditCardTypeID' => 'Visa',
            'Number'           => '4111111111111111',
            'SecurityCode'     => '123',
            'ExpirationMonth'  => '10',
            'ExpirationYear'   => '2017'
        );

        $curl = curl_init('https://app.eztexting.com/billing/credits?format=json');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
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
            echo 'Status: ' . $json->Status . "\n" .
                'Credits purchased: ' . $json->Entry->BoughtCredits . "\n" .
                'Amount charged, $: ' . sprintf("%01.2f", $json->Entry->Amount) . "\n" .
                'Discount, $: ' . sprintf("%01.2f", $json->Entry->Discount) . "\n" .
                'Plan credits: ' . $json->Entry->PlanCredits . "\n" .
                'Anytime credits: ' . $json->Entry->AnytimeCredits . "\n" .
                'Total: ' . $json->Entry->TotalCredits . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }
}
