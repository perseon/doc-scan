@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <iframe id="docscan-frame" style="border: none;" allow="camera" src="{{ $iframeUrl }}" height="500%" width="100%"></iframe>
        </div>
    </div>
</div>
@endsection
