@component('mail::message')
# Rezultate



@component('mail::table')
|Session ID|{{ $sessionResult->getSessionId() }}|
|State|{{ $sessionResult->getState() }}|
@endcomponent
@if (count($sessionResult->getChecks()) > 0)
@component('mail::panel')
Checks
@endcomponent
@if (count($sessionResult->getAuthenticityChecks()) > 0)
- Authenticity Checks
@foreach($sessionResult->getAuthenticityChecks() as $check)
@include('partial/check', ['check' => $check])
@endforeach
@endif
@if (count($sessionResult->getTextDataChecks()) > 0)
- Text Data Checks
@foreach($sessionResult->getTextDataChecks() as $check)
@include('partial/check', ['check' => $check])
@endforeach
@endif
@if (count($sessionResult->getFaceMatchChecks()) > 0)
- FaceMatch Checks
@foreach ($sessionResult->getFaceMatchChecks() as $check)
@include('partial/check', ['check' => $check])
@endforeach
@endif
@if (count($sessionResult->getLivenessChecks()) > 0)
- Liveness Checks
@foreach ($sessionResult->getLivenessChecks() as $check)
@include('partial/check', ['check' => $check])
@endforeach
@endif
@endif
@if (count($sessionResult->getResources()->getIdDocuments()) > 0)
@component('mail::panel')
ID Documents
@endcomponent
@foreach ($sessionResult->getResources()->getIdDocuments() as $docNum => $document)
- {{ $document->getDocumentType() }} - {{ $document->getIssuingCountry() }}
@if ($document->getDocumentFields())
- Document Fields
@if ($document->getDocumentFields()->getMedia())
-- Media
@component('mail::table')
|ID|<a href="/media/{{ $document->getDocumentFields()->getMedia()->getId() }}">{{ $document->getDocumentFields()->getMedia()->getId() }}</a>|
@endcomponent
@endif
@endif
@if (count($document->getTextExtractionTasks()) > 0)
-- Text Extraction Tasks
@foreach ($document->getTextExtractionTasks() as $task)
@include('partial/task', ['task' => $task])
@if (count($task->getGeneratedTextDataChecks()) > 0)
-- Generated Text Data Checks
@foreach ($task->getGeneratedTextDataChecks() as $check)
@component('mail::table')
|ID||{{ $check->getId() }}|
@endcomponent
@endforeach
@endif
@if (count($task->getGeneratedMedia()) > 0)
-- Generated Media
@foreach ($task->getGeneratedMedia() as $media)
@component('mail::table')
|ID|<a href="/media/{{ $media->getId() }}">{{ $media->getId() }}</a>
|Type|{{ $media->getType() }}|
@endcomponent
@endforeach
@endif
@endforeach
@endif
@if (count($document->getPages()) > 0)
-- Pages
@foreach ($document->getPages() as $page)
@if ($page->getMedia())
<p>Method: {{ $page->getCaptureMethod() }}</p>
@endif
@endforeach
@endif
@endforeach
@endif
@if (count($sessionResult->getResources()->getZoomLivenessResources()) > 0)
 @component('mail::panel')
 Zoom Liveness Resources
 @endcomponent
@foreach ($sessionResult->getResources()->getZoomLivenessResources() as $livenessNum => $livenessResource)
@component('mail::table')
|ID|{{ $livenessResource->getId() }}|
@endcomponent
@if ($livenessResource->getFaceMap())
- Face Map
@if ($livenessResource->getFaceMap()->getMedia())
-- Media
@component('mail::table')
|ID|<a href="/media/{{ $livenessResource->getFaceMap()->getMedia()->getId() }}?base64=1">{{ $livenessResource->getFaceMap()->getMedia()->getId() }}
</a>|
@endcomponent
@endif
@endif
@if (count($livenessResource->getFrames()) > 0)
- Frames
@foreach ($livenessResource->getFrames() as $frame)
@if ($frame->getMedia())
- Frame
@endif
@endforeach
@endif
@endforeach
@endif
@endcomponent
