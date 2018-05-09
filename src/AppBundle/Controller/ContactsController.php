<?php
/**
 * Created by PhpStorm.
 * User: pushpe
 * Date: 4/30/18
 * Time: 9:01 PM
 */

namespace AppBundle\Controller;

use AppBundle\Config\Configuration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ContactsController
{
    /**
     * @Route("/api/contact/create", name="createContact")
     */
    public function createContact(Request $request){
        $data = array(
            'User'        => 'winnie',
            'Password'    => 'the-pooh',
            'PhoneNumber' => '2123456785',
            'FirstName'   => 'Piglet',
            'LastName'    => 'P.',
            'Email'       => 'piglet@small-animals-alliance.org',
            'Note'        => 'It is hard to be brave, when you are only a Very Small Animal.',
            'Groups'      => array('Friends', 'Neighbors')
        );

        $curl = curl_init('https://app.eztexting.com/contacts?format=json');
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
            $groups = array();
            if ( !empty($json->Entry->Groups) ) {
                $groups = $json->Entry->Groups;
            }

            echo 'Status: ' . $json->Status . "\n" .
                'Contact ID : ' . $json->Entry->ID . "\n" .
                'Phone Number: ' . $json->Entry->PhoneNumber . "\n" .
                'First Name: ' . $json->Entry->FirstName . "\n" .
                'Last Name: ' . $json->Entry->LastName . "\n" .
                'Email: ' . $json->Entry->Email . "\n" .
                'Note: ' . $json->Entry->Note . "\n" .
                'Source: ' . $json->Entry->Source . "\n" .
                'Groups: ' . implode(', ' , $groups) . "\n" .
                'CreatedAt: ' . $json->Entry->CreatedAt . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/contact/update", name="updateContact")
     */
    public function updateContact(Request $request){
        $data = array(
            'User'        => 'winnie',
            'Password'    => 'the-pooh',
            'PhoneNumber' => '2123456785',
            'FirstName'   => 'Piglet',
            'LastName'    => 'P.',
            'Email'       => 'piglet@small-animals-alliance.org',
            'Note'        => 'It is hard to be brave, when you are only a Very Small Animal.',
            'Groups'      => array('Friends', 'Neighbors')
        );

        $curl = curl_init('https://app.eztexting.com/contacts/4f0b5720734fada368000000?format=json');
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
            $groups = array();
            if ( !empty($json->Entry->Groups) ) {
                $groups = $json->Entry->Groups;
            }

            echo 'Status: ' . $json->Status . "\n" .
                'Contact ID : ' . $json->Entry->ID . "\n" .
                'Phone Number: ' . $json->Entry->PhoneNumber . "\n" .
                'First Name: ' . $json->Entry->FirstName . "\n" .
                'Last Name: ' . $json->Entry->LastName . "\n" .
                'Email: ' . $json->Entry->Email . "\n" .
                'Note: ' . $json->Entry->Note . "\n" .
                'Source: ' . $json->Entry->Source . "\n" .
                'Groups: ' . implode(', ' , $groups) . "\n" .
                'CreatedAt: ' . $json->Entry->CreatedAt . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    public function updateContact_Normal($id, $userName, $password, $phoneNumber, $firstName, $lastName, $email, $note,$array){
        $data = array(
            'User'        => $userName,
            'Password'    => $password,
            'PhoneNumber' => $phoneNumber,
            'FirstName'   => $firstName,
            'LastName'    => $lastName,
            'Email'       => $email,
            'Note'        => $note,
            'Groups'      => $array
        );

        $curl = curl_init('https://app.eztexting.com/contacts/'.$id.'?format=json');
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
            return false;
        } else {
            $groups = array();
            if ( !empty($json->Entry->Groups) ) {
                $groups = $json->Entry->Groups;
            }

            echo 'Status: ' . $json->Status . "\n" .
                'Contact ID : ' . $json->Entry->ID . "\n" .
                'Phone Number: ' . $json->Entry->PhoneNumber . "\n" .
                'First Name: ' . $json->Entry->FirstName . "\n" .
                'Last Name: ' . $json->Entry->LastName . "\n" .
                'Email: ' . $json->Entry->Email . "\n" .
                'Note: ' . $json->Entry->Note . "\n" .
                'Source: ' . $json->Entry->Source . "\n" .
                'Groups: ' . implode(', ' , $groups) . "\n" .
                'CreatedAt: ' . $json->Entry->CreatedAt . "\n";
            return true;
        }
    }

    /**
     * @Route("/api/contact/delete", name="deleteContact")
     */
    public function deleteContact(Request $request){
        $data = array(
            'User'     => 'winnie',
            'Password' => 'the-pooh'
        );

        $curl = curl_init('https://app.eztexting.com/contacts/4f0b52fd734fada068000000?format=json&_method=DELETE');
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

    /**
     * @Route("/api/contact/getAll", name="getAllContacts")
     */
    public function getAllContacts(Request $request){
        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password,
            'source'        => 'upload',
            'optout'        => false,
            'group'         => 'MARCH 18',
            'sortBy'        => 'PhoneNumber',
            'sortDir'       => 'asc',
            'itemsPerPage'  => Configuration::maxItemsPerPage,
            'page'          => '1',
        );

        $curl = curl_init('https://app.eztexting.com/contacts?format=json&' . http_build_query($data));
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
        } elseif ( empty($json->Entries) ) {
            echo 'Status: ' . $json->Status . "\n" .
                'Search has returned no results' . "\n";
        } else {
            echo 'Status: ' . $json->Status . "\n" .
                'Total results: ' . count($json->Entries) . "\n\n";

//            foreach ( $json->Entries as $contact ) {
//                $groups = array();
//                if ( !empty($contact->Groups) ) {
//                    $groups = $contact->Groups;
//                }
//
//                echo 'Contact ID : ' . $contact->ID . "\n" .
//                    'Phone Number: ' . $contact->PhoneNumber . "\n" .
//                    'First Name: ' . $contact->FirstName . "\n" .
//                    'Last Name: ' . $contact->LastName . "\n" .
//                    'Email: ' . $contact->Email . "\n" .
//                    'Note: ' . $contact->Note . "\n" .
//                    'Source: ' . $contact->Source . "\n" .
//                    'Opted Out: ' . ($contact->OptOut ? 'true' : 'false') . "\n" .
//                    'Groups: ' . implode(', ' , $groups) . "\n" .
//                    'CreatedAt: ' . $contact->CreatedAt . "\n\n";
//            }
        }
        $serverResponse = $json->Entries;
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/contact/getOne", name="getOneContact")
     */
    public function getOneContact(Request $request){
        $data = array(
            'User'     => Configuration::userName,
            'Password' => Configuration::password
        );

        $curl = curl_init('https://app.eztexting.com/contacts/4f0b52fd734fada068000000?format=json&' . http_build_query($data));
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
            $groups = array();
            if ( !empty($json->Entry->Groups) ) {
                $groups = $json->Entry->Groups;
            }

            echo 'Status: ' . $json->Status . "\n" .
                'Contact ID : ' . $json->Entry->ID . "\n" .
                'Phone Number: ' . $json->Entry->PhoneNumber . "\n" .
                'First Name: ' . $json->Entry->FirstName . "\n" .
                'Last Name: ' . $json->Entry->LastName . "\n" .
                'Email: ' . $json->Entry->Email . "\n" .
                'Note: ' . $json->Entry->Note . "\n" .
                'Source: ' . $json->Entry->Source . "\n" .
                'Opted Out: ' . ($json->Entry->OptOut ? 'true' : 'false') . "\n" .
                'Groups: ' . implode(', ' , $groups) . "\n" .
                'CreatedAt: ' . $json->Entry->CreatedAt . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    public function getOneContact_Normal($id, $userName, $password){
        $data = array(
            'User'     => $userName,
            'Password' => $password
        );

        $readContact = array(
            'data' => false
        );

        $curl = curl_init('https://app.eztexting.com/contacts/'.$id.'?format=json&' . http_build_query($data));
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
            $groups = array();
            if ( !empty($json->Entry->Groups) ) {
                $groups = $json->Entry->Groups;
            }
            $contact = array(
                'data' => true,
                'contactID' => $json->Entry->ID,
                'phoneNumber' => $json->Entry->PhoneNumber,
                'firstName' => $json->Entry->FirstName,
                'lastName' => $json->Entry->LastName,
                'email' => $json->Entry->Email,
                'note' => $json->Entry->Note,
                'groups' => $groups
            );

            $readContact = $contact;

        }
        return $readContact;
    }
}