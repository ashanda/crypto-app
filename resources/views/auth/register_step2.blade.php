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
                <h1 class="h3 mb-4">Step 2: Select a Package</h1>


    <form action="{{ route('register.processStep2') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="package">Choose your package</label>
            
            <input type="hidden" name="newUserID" value="{{ $id }}">
            <select name="package" class="form-control" required>
                <option value="">Select Package</option>
                <option value="10" {{ old('package') == 10 ? 'selected' : '' }}>10 USD</option>
                <option value="20" {{ old('package') == 20 ? 'selected' : '' }}>20 USD</option>
                <option value="50" {{ old('package') == 50 ? 'selected' : '' }}>50 USD</option>
                <option value="100" {{ old('package') == 100 ? 'selected' : '' }}>100 USD</option>
                <option value="500" {{ old('package') == 500 ? 'selected' : '' }}>500 USD</option>
                <option value="1000" {{ old('package') == 1000 ? 'selected' : '' }}>1000 USD</option>
                <option value="2500" {{ old('package') == 2500 ? 'selected' : '' }}>2500 USD</option>
                <option value="5000" {{ old('package') == 5000 ? 'selected' : '' }}>5000 USD</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Next</button>
    </form>
            </div>
        </div>
    </div>

</div>
@endsection
