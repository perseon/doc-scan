<?php

namespace App\Http\Controllers;

use App\Invite;
use Illuminate\Http\Request;
use Yoti\DocScan\DocScanClient;
use Yoti\DocScan\Session\Create\Check\RequestedDocumentAuthenticityCheckBuilder;
use Yoti\DocScan\Session\Create\Check\RequestedFaceMatchCheckBuilder;
use Yoti\DocScan\Session\Create\Check\RequestedLivenessCheckBuilder;
use Yoti\DocScan\Session\Create\SdkConfigBuilder;
use Yoti\DocScan\Session\Create\SessionSpecificationBuilder;
use Yoti\DocScan\Session\Create\Task\RequestedTextExtractionTaskBuilder;


class Application extends Controller
{
    //
    public function show($appid, Request $request, DocScanClient $client){


        $invite = Invite::where('tracking_id',$appid)->first();

        if($invite){
            $invite->link_accessed=true;
            $invite->save();

            $sessionSpec = (new SessionSpecificationBuilder())
                ->withClientSessionTokenTtl(600)
                ->withResourcesTtl(90000)
                ->withUserTrackingId($appid)
                ->withRequestedCheck(
                    (new RequestedDocumentAuthenticityCheckBuilder())
                        ->build()
                )
                ->withRequestedCheck(
                    (new RequestedLivenessCheckBuilder())
                        ->forZoomLiveness()
                        ->build()
                )
                ->withRequestedCheck(
                    (new RequestedFaceMatchCheckBuilder())
                        ->withManualCheckFallback()
                        ->build()
                )
                ->withRequestedTask(
                    (new RequestedTextExtractionTaskBuilder())
                        ->withManualCheckAlways()
                        ->build()
                )
                ->withSdkConfig(
                    (new SdkConfigBuilder())
                        ->withAllowsCameraAndUpload()
                        ->withPrimaryColour('#2d9fff')
                        ->withSecondaryColour('#FFFFFF')
                        ->withFontColour('#FFFFFF')
                        ->withLocale('en-GB')
                        ->withPresetIssuingCountry('GBR')
                        ->withSuccessUrl(config('app.url') . '/success')
                        ->withErrorUrl(config('app.url') . '/error')
                        ->build()
                )
                ->build();

            $session = $client->createSession($sessionSpec);

            $request->session()->put('YOTI_SESSION_ID', $session->getSessionId());
            $request->session()->put('YOTI_SESSION_TOKEN', $session->getClientSessionToken());

            return view('home', [
                'iframeUrl' => config('yoti')['doc.scan.iframe.url'] . '?' . http_build_query([
                        'sessionID' => $session->getSessionId(),
                        'sessionToken' => $session->getClientSessionToken(),
                    ])
            ]);

        }
        else{
            return 'No data!';
        }

    }
}
