<?php

namespace AppBundle\Controller;

use AppBundle\Config\Configuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/api/handle", name="ezTextingIndexAction")
     */
    public function ezTextingIndexAction(Request $request){
        $clientCount = sizeof(Configuration::$userNames);
        for ($i = 0; $i < $clientCount; $i++){
            $data = true;
            $index = 1;
            $serverResponse = array();
            $messageIds = array();
            $userName = Configuration::$userNames[$i];
            $password = Configuration::$passwords[$i];
            while ($data){

                $data = array(
                    'User'          => $userName,
                    'Password'      => $password,
                    'sortBy'        => 'PhoneNumber',
                    'sortDir'       => 'asc',
                    'itemsPerPage'  => Configuration::maxItemsPerPage,
                    'page'          => $index
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
                    $totalResults = count($json->Entries);
                    echo 'Status: ' . $json->Status . "\n" .
                        'Total results: ' . $totalResults . "\n\n";
                    foreach ( $json->Entries as $message ) {
                        if($message->FolderID == 0){
                            array_push($serverResponse, $message);
                            array_push($messageIds, $message->ID);
                            $contactID = $message->ContactID;
                            $contactController = new ContactsController();
                            $contact = $contactController->getOneContact_Normal($contactID, $userName, $password);

                            if ($contact['data'] && sizeof($contact['groups']) > 0){
                                $id = $contact['contactID'];
                                $phoneNumber= $contact['phoneNumber'];
                                $firstName= $contact['firstName'];
                                $lastName= $contact['lastName'];
                                $email= $contact['email'];
                                $note= $contact['note'];
                                $array= array('None');
                                $contactController->updateContact_Normal($id, $userName, $password, $phoneNumber, $firstName, $lastName, $email, $note,$array);
                            }
                        }
                    }

                    if($totalResults == Configuration::maxItemsPerPage){
                        $index++;
                    } else {
                        $data = false;
                    }
                }
            }

            $managingInboxController = new ManagingInboxController();
            $managingInboxController->moveMessageToFolder_Normal($messageIds, $userName, $password,Configuration::moveFolderId);
        }

        $res = array('status'=>'OK', 'messageCount' => count($serverResponse));
        return new JsonResponse($res);
    }
}
