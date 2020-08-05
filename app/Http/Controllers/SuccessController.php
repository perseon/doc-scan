<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Mail\SendResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Util\Json;
use Yoti\DocScan\DocScanClient;

class SuccessController extends Controller
{
    //
    public function show(Request $request, DocScanClient $client)
    {
        $result = $client->getSession($request->session()->get('YOTI_SESSION_ID'));

        $invite = Invite::where('tracking_id',$result->getUserTrackingId())->first();
        $application = new \App\Application();
        $application->state = $result->getState();
        $application->session_id = $result->getSessionId();
        $application->user_tracking_id = $result->getUserTrackingId();
        $application->client_session_token = $result->getClientSessionToken() ?? '';
        //dd($result);

        $checks = [];
        $docs = [];
        $tasks = [];
        if(count($result->getChecks()) > 0){
            if(count($result->getAuthenticityChecks()) > 0){
                foreach($result->getAuthenticityChecks() as $check){
                   $checks[] =  ['check' => $check->getState()];
                }
            }
            if(count($result->getTextDataChecks()) > 0){
                foreach($result->getTextDataChecks() as $check){
                    $checks[] =  ['check' => $check->getState()];
                }
            }
            if(count($result->getFaceMatchChecks()) > 0){
                foreach($result->getFaceMatchChecks() as $check){
                    $checks[] =  ['check' => $check->getState()];
                }
            }
            if(count($result->getLivenessChecks()) > 0){
                foreach($result->getLivenessChecks() as $check){
                    $checks[] =  ['check' => $check->getState()];
                }
            }
        }

        if (count($result->getResources()->getIdDocuments()) > 0){
            foreach ($result->getResources()->getIdDocuments() as $docNum => $document){
                $fields = [];
                if ($document->getDocumentFields()){
                    if ($document->getDocumentFields()->getMedia()){
                        $fields = [
                           'id'=> $document->getDocumentFields()->getMedia()->getId()
                        ];
                    }
                    if (count($document->getTextExtractionTasks()) > 0){
                        foreach ($document->getTextExtractionTasks() as $task){
                            $chks = [];
                            if (count($task->getGeneratedTextDataChecks()) > 0){
                                foreach ($task->getGeneratedTextDataChecks() as $check){
                                    $chks[] = ['id'=>$check->getId()];
                                }
                            }
                            $tasks[] = ['task' => $task->getState(),'checks'=>$chks];
                        }
                    }
                }
                $docs[] = [
                    'type'=>$document->getDocumentType(),
                    'issuingCountry'=>$document->getIssuingCountry(),
                    'fields'=>$fields
                ];
            }
        }

        $application->resources =  json_encode((object)[$checks,$docs,$tasks]);

        if($invite){
            $entry = $invite->applications()->save($application);
            //dd($entry);
            Mail::to('info@atftax.co.uk')
                ->cc('atftaxconsultancy@gmail.com')
                ->cc('manta.ovidiu@gmail.com')->send(new SendResults($invite->email, ['invid'=>$invite->id,'appid'=> $entry->id]));
        }



        //dd($request->session()->get('YOTI_SESSION_ID'));

        return view('success', [
            'sessionResult' => $client->getSession($request->session()->get('YOTI_SESSION_ID')),
        ]);
    }
}
