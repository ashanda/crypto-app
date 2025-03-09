@extends('layouts.app')
@section('sidebar')
 @include('layouts.sidebar')
@endsection

@section('content')
 @include('layouts.topbar')
<div class="container text-center">
    @if(auth()->user()->google2fa_secret == null)
        <h2>Setup Google Authenticator</h2>
        <p>All Ready Setup Google Authenticator </p>

    @else
    <h2>Setup Google Authenticator</h2>
    <p>Scan the QR code below with your Google Authenticator app.</p>

    <img src="{{ $qrCodeImageBase64 }}" alt="Google Authenticator QR Code" class="img-fluid">

    <p><strong>Secret Key:</strong> {{ $secret }}</p>
    <p>Use this key if you cannot scan the QR code.</p>
    @endif

    
</div>
@endsection