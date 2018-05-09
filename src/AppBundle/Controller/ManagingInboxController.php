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

class ManagingInboxController
{

    /**
     * @Route("/api/inbox/delete", name="deleteInboxMessage")
     */
    public function deleteInboxMessage(Request $request)
    {
        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password
        );

        $curl = curl_init('https://app.eztexting.com/incoming-messages/123?format=json&_method=DELETE');
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
     * @Route("/api/inbox/getAll", name="getAllInboxMessages")
     */
    public function getAllInboxMessages(Request $request){
        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password,
            'sortBy'        => 'PhoneNumber',
            'sortDir'       => 'asc',
            'itemsPerPage'  => Configuration::maxItemsPerPage,
            'page'          => '1'
        );

        $curl = curl_init('https://app.eztexting.com/incoming-messages?format=json&' . http_build_query($data));
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
        }

        $serverResponse = $json->Entries;
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/inbox/getOne", name="getOneInboxMessages")
     */
    public function getOneInboxMessage(Request $request){
        $data = array(
            'User'     => Configuration::userName,
            'Password' => Configuration::password
        );

        $curl = curl_init('https://app.eztexting.com/incoming-messages/123?format=json&' . http_build_query($data));
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
                'Message ID : ' . $json->Entry->ID . "\n" .
                'Phone Number: ' . $json->Entry->PhoneNumber . "\n" .
                'Subject: ' . $json->Entry->Subject . "\n" .
                'Message: ' . $json->Entry->Message . "\n" .
                'New: ' . $json->Entry->New . "\n" .
                'Folder ID: ' . $json->Entry->FolderID . "\n" .
                'Contact ID: ' . $json->Entry->ContactID . "\n" .
                'Received On: ' . $json->Entry->ReceivedOn . "\n\n";
        }

        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/inbox/move", name="moveMessageToFolder")
     */
    public function moveMessageToFolder(Request $request){
        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password,
            'ID'        => array(12, 13),
            'FolderID'  => 57
        );

        $curl = curl_init('https://app.eztexting.com/incoming-messages/?format=json&_method=move-to-folder');
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

    public function moveMessageToFolder_Normal($ids, $userName, $password, $folderId){
        $data = array(
            'User'          => $userName,
            'Password'      => $password,
            'ID'        => $ids,
            'FolderID'  => $folderId
        );

        $curl = curl_init('https://app.eztexting.com/incoming-messages/?format=json&_method=move-to-folder');
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
     * @Route("/api/inbox/folder/create", name="createInboxFolder")
     */
    public function createInboxFolder(Request $request){
        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password,
            'Name'     => 'Customers'
        );

        $curl = curl_init('https://app.eztexting.com/messages-folders?format=json');
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
                'Folder ID : ' . $json->Entry->ID . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/inbox/folder/update", name="updateInboxFolder")
     */
    public function updateInboxFolder(Request$request){
        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password,
            'Name'          => 'Customers'
        );

        $curl = curl_init('https://app.eztexting.com/messages-folders/123?format=json');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        if (!empty($response)) {
            $json = json_decode($response);
            $json = $json->Response;

            if ('Failure' == $json->Status) {
                $errors = array();
                if (!empty($json->Errors)) {
                    $errors = $json->Errors;
                }

                echo 'Status: ' . $json->Status . "\n" .
                    'Errors: ' . implode(', ', $errors) . "\n";
            }
        } else {
            echo 'Status: Success' . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/inbox/folder/delete", name="deleteInboxFolder")
     */
    public function deleteInboxFolder(Request $request){
        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password
        );

        $curl = curl_init('https://app.eztexting.com/messages-folders/123?format=json&_method=DELETE');
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
     * @Route("/api/inbox/folder/getAll", name="getAllInboxFolders")
     */
    public function getAllInboxFolders(Request $request){
        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password
        );

        $curl = curl_init('https://app.eztexting.com/messages-folders?format=json&' . http_build_query($data));
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

            foreach ( $json->Entries as $folder ) {
                echo 'ID : ' . $folder->ID . "\n" .
                    'Name: ' . $folder->Name . "\n\n";
            }
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/inbox/folder/getOne", name="getOneInboxFolder")
     */
    public function getOneInboxFolder(Request $request){
        $data = array(
            'User'          => Configuration::userName,
            'Password'      => Configuration::password,
        );

        $curl = curl_init('https://app.eztexting.com/messages-folders/123?format=json&' . http_build_query($data));
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
                'Folder Name: ' . $json->Entry->Name . "\n";
        }

        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }
}