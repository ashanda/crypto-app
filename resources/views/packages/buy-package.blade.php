@extends('layouts.app')
@section('sidebar')
 @include('layouts.sidebar')
@endsection

@section('content')
 @include('layouts.topbar')


<main>
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
<div class="container">
    <div class="row justify-content-center form-bg-image">
        
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                
                  

    <form action="{{ route('buy.packages') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="package">Choose your package</label>
            
            <input type="hidden" name="newUserID" value="{{ $id }}">
            <select name="package" class="form-control" required>
                <option value="">Select Package</option>
                @foreach ($package as $pack) 
                    <option value="{{ $pack->price }}" {{ old('package') == $pack->price ? 'selected' : '' }}>{{ $pack->name }} USD</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <h3>Upliner Activation</h3>
            
                 Binance ID: {{ $parentData->user->binance_pay_id }}
         
            <br>
            <i class="fab fa-whatsapp mt-2"></i> WhatsApp no: {{ $parentData->user->whatsapp_number }}
            <br>
            <!-- Call Now button with link -->
            <a href="tel:{{ $parentData->whatsapp_number }}" class="btn btn-success mt-2">
                <i class="fas fa-phone-alt"></i> Call Now
            </a>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Next</button>
    </form>
    <div class="form-group">
       
    </div> 
            </div>
        </div>
    </div>

</div>
@endsection
