@extends('layouts.app')
@section('sidebar')
 @include('layouts.sidebar')
@endsection

@section('content')
 @include('layouts.topbar')


    <!-- Section -->
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            
            <div class="row justify-content-center form-bg-image" >
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h1 class="mb-0 h3">Share Token</h1>
                            <p>My Token : {{$tokens}}</a
                        </div>
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form class="mt-4" action="{{ route('token.shares') }}" method="POST">
                            <!-- Form -->
                            @csrf
                            <div class="form-group mb-4">
                                <label for="text">Tokens Value</label>
                                <div class="input-group">
                                   
                                    <input type="number" max="{{ $tokens }}" min="1" class="form-control" placeholder="10" id="tokenValue" name= "tokenValue" autofocus required>
                                </div>  
                            </div>
                            <!-- End of Form -->
                            <div class="form-group">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="user_id">User ID</label>
                                    <div class="input-group">
                                        
                                        <input type="number" placeholder="User ID" class="form-control" id="user_id" name="user_id" required>
                                    </div>  
                                </div>
                                <!-- End of Form -->
                                
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gray-800">Send Tokens</button>
                            </div>
                        </form>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>


    
    
    
    @endsection
