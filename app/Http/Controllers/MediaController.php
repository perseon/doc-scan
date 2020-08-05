<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yoti\DocScan\DocScanClient;

class MediaController extends Controller
{
    //
    public function show(string $sessid, string $id, Request $request, DocScanClient $client)
    {
        //dd($client->getSession($sessid));
        $media = $client->getMediaContent($sessid, $id);

        $content = $media->getContent();
        $contentType = $media->getMimeType();

        if ($request->get('base64') === '1' && $contentType === 'application/octet-stream') {
            $content = base64_decode($content, true);
            $contentType = (new \finfo(FILEINFO_MIME))->buffer($content);
        }

        return response($content, 200)->header('Content-Type', $contentType);
    }
}
