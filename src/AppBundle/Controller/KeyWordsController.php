<?php
/**
 * Created by PhpStorm.
 * User: pushpe
 * Date: 4/30/18
 * Time: 8:59 PM
 */

namespace AppBundle\Controller;
use AppBundle\Config\Configuration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class KeyWordsController
{

    /**
     * @Route("/api/keyword/check", name="checkKeywordAvailability")
     */
    public function checkKeywordAvailability(Request $request)
    {
        $data = array(
            'User'     => Configuration::userName,
            'Password' => Configuration::password,
            'Keyword'  => 'honey'
        );

        $curl = curl_init('https://app.eztexting.com/keywords/new?format=json&' . http_build_query($data));
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
                'Keyword: ' . $json->Entry->Keyword . "\n" .
                'Availability: ' . (int) $json->Entry->Available . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/keyword/rent/stored", name="rentKeywordWithStoredCard")
     */
    public function rentKeywordWithStoredCard(Request $request){
        $data = array(
            'User'             => 'winnie',
            'Password'         => 'the-pooh',
            'Keyword'          => 'honey',
            'StoredCreditCard' => '1111'
        );

        $curl = curl_init('https://app.eztexting.com/keywords?format=json');
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
                'Keyword ID: ' . $json->Entry->ID . "\n" .
                'Keyword: ' . $json->Entry->Keyword . "\n" .
                'Is double opt-in enabled: ' . (int) $json->Entry->EnableDoubleOptIn . "\n" .
                'Confirm message: ' . $json->Entry->ConfirmMessage . "\n" .
                'Join message: ' . $json->Entry->JoinMessage . "\n" .
                'Forward email: ' . $json->Entry->ForwardEmail . "\n" .
                'Forward url: ' . $json->Entry->ForwardUrl . "\n" .
                'Groups: ' . implode(', ' , $json->Entry->ContactGroupIDs) . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/keyword/rent/non-stored", name="rentKeywordWithNonStoredCard")
     */
    public function rentKeywordWithNonStoredCard(Request $request){
        $data = array(
            'User'             => 'winnie',
            'Password'         => 'the-pooh',
            'Keyword'          => 'honey',
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

        $curl = curl_init('https://app.eztexting.com/keywords?format=json');
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
                'Keyword ID: ' . $json->Entry->ID . "\n" .
                'Keyword: ' . $json->Entry->Keyword . "\n" .
                'Is double opt-in enabled: ' . (int) $json->Entry->EnableDoubleOptIn . "\n" .
                'Confirm message: ' . $json->Entry->ConfirmMessage . "\n" .
                'Join message: ' . $json->Entry->JoinMessage . "\n" .
                'Forward email: ' . $json->Entry->ForwardEmail . "\n" .
                'Forward url: ' . $json->Entry->ForwardUrl . "\n" .
                'Groups: ' . implode(', ' , $json->Entry->ContactGroupIDs) . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/keyword/setup", name="setupKeyword")
     */
    public function setupKeyword(Request $request){
        $data = array(
            'User'              => 'winnie',
            'Password'          => 'the-pooh',
            'EnableDoubleOptIn' => true,
            'ConfirmMessage'    => 'Reply Y to join our sweetest list',
            'JoinMessage'       => 'The only reason for being a bee that I know of, is to make honey. And the only reason for making honey, is so as I can eat it.',
            'ForwardEmail'      => 'honey@bear-alliance.co.uk',
            'ForwardUrl'        => 'http://bear-alliance.co.uk/honey-donations/',
            'ContactGroupIDs'   => array('honey lovers')
        );

        $curl = curl_init('https://app.eztexting.com/keywords/honey?format=json');
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
                'Keyword ID: ' . $json->Entry->ID . "\n" .
                'Keyword: ' . $json->Entry->Keyword . "\n" .
                'Is double opt-in enabled: ' . (int) $json->Entry->EnableDoubleOptIn . "\n" .
                'Confirm message: ' . $json->Entry->ConfirmMessage . "\n" .
                'Join message: ' . $json->Entry->JoinMessage . "\n" .
                'Forward email: ' . $json->Entry->ForwardEmail . "\n" .
                'Forward url: ' . $json->Entry->ForwardUrl . "\n" .
                'Groups: ' . implode(', ' , $json->Entry->ContactGroupIDs) . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/keyword/cancel", name="cancelKeyword")
     */
    public function cancelKeyword(Request $request){
        $data = array(
            'User'     => 'winnie',
            'Password' => 'the-pooh'
        );

        $curl = curl_init('https://app.eztexting.com/keywords/honey?format=json&_method=DELETE');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        if ( !empty($response) ) {
            $json = json_decode($response);
            $json = $json->Response;

            if ( 'Failure' == $json->Status ) {
                $errors = array();
                if ( !empty($json->Errors) ) {
                    $errors = $json->Errors;
                }

                echo 'Status: ' . $json->Status . "\n" .
                    'Errors: ' . implode(', ' , $errors) . "\n";
            }
        } else {
            echo 'Status: Success' . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }
}