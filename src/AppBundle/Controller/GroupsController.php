<?php
/**
 * Created by PhpStorm.
 * User: pushpe
 * Date: 4/30/18
 * Time: 9:01 PM
 */

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class GroupsController
{
    /**
     * @Route("/api/group/create", name="createGroup")
     */
    public function createGroup(Request $request){
        $data = array(
            'User'      => 'winnie',
            'Password'  => 'the-pooh',
            'Name'      => 'Tubby Bears',
            'Note'      => 'A bear, however hard he tries, grows tubby without exercise',
        );

        $curl = curl_init('https://app.eztexting.com/groups?format=json');
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
                'Group ID : ' . $json->Entry->ID . "\n" .
                'Name: ' . $json->Entry->Name . "\n" .
                'Note: ' . $json->Entry->Note . "\n" .
                'Number of Contacts: ' . $json->Entry->ContactCount . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/group/update", name="updateGroup")
     */
    public function updateGroup(Request $request){
        $data = array(
            'User'      => 'winnie',
            'Password'  => 'the-pooh',
            'Name'      => 'Tubby Bears',
            'Note'      => 'A bear, however hard he tries, grows tubby without exercise',
        );

        $curl = curl_init('https://app.eztexting.com/groups/162467?format=json');
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
                'Group ID : ' . $json->Entry->ID . "\n" .
                'Name: ' . $json->Entry->Name . "\n" .
                'Note: ' . $json->Entry->Note . "\n" .
                'Number of Contacts: ' . $json->Entry->ContactCount . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/group/delete", name="deleteGroup")
     */
    public function deleteGroup(Request $request){
        $data = array(
            'User'      => 'winnie',
            'Password'  => 'the-pooh',
        );

        $curl = curl_init('https://app.eztexting.com/groups/162467?format=json&_method=DELETE');
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
     * @Route("/api/group/getAll", name="getAllGroups")
     */
    public function getAllGroups(Request $request){
        $data = array(
            'User'          => 'winnie',
            'Password'      => 'the-pooh',
            'sortBy'        => 'Name',
            'sortDir'       => 'asc',
            'itemsPerPage'  => '10',
            'page'          => '3',
        );

        $curl = curl_init('https://app.eztexting.com/groups?format=json&' . http_build_query($data));
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

            foreach ( $json->Entries as $group ) {
                echo 'Group ID : ' . $group->ID . "\n" .
                    'Name: ' . $group->Name . "\n" .
                    'Note: ' . $group->Note . "\n" .
                    'Number of Contacts: ' . $group->ContactCount . "\n\n";
            }
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }

    /**
     * @Route("/api/group/getOne", name="getOneGroup")
     */
    public function getOneGroup(Request $request){
        $data = array(
            'User'      => 'winnie',
            'Password'  => 'the-pooh',
        );

        $curl = curl_init('https://app.eztexting.com/groups/162467?format=json&' . http_build_query($data));
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
                'Group ID : ' . $json->Entry->ID . "\n" .
                'Name: ' . $json->Entry->Name . "\n" .
                'Note: ' . $json->Entry->Note . "\n" .
                'Number of Contacts: ' . $json->Entry->ContactCount . "\n";
        }
        $serverResponse = array('status' => 'OK');
        return new JsonResponse($serverResponse);
    }
}