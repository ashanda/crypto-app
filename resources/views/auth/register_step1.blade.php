
@extends('layouts.app')

@section('content')
<main>
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
<div class="container">
    <div class="row justify-content-center form-bg-image">
        <p class="text-center"><a href="./sign-in.html" class="d-flex align-items-center justify-content-center">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            Back to log in
            </a>
        </p>
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                <h1 class="h3 mb-4">Step 1: Enter Your Details</h1>
    

    <form action="{{ route('register.processStep1') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="referral_code">Referral Code</label>
            <input type="text" name="referral_code" class="form-control" value="{{ request('ref') }}" readonly>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="whatsapp_number">WhatsApp Number</label>
            <input type="text" name="whatsapp_number" class="form-control" required value="{{ old('whatsapp_number') }}">
        </div>

        <div class="form-group">
            <label for="binance_pay_id">Binance Pay ID</label>
            <input type="text" name="binance_pay_id" class="form-control" required value="{{ old('binance_pay_id') }}">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Next</button>
    </form>
            </div>
        </div>
    </div>

</div>
@endsection
