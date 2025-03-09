@extends('layouts.app')
@section('sidebar')
 @include('layouts.sidebar')
@endsection

@section('content')
 @include('layouts.topbar')
    <h2 class="mb-3">Tokens for {{ $user->name }}</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0 col-6">
            <form action="{{ route('generate.tokens', $user->id) }}" method="POST" class="mb-3">
                @csrf
                <label for="token_count" class="form-label">Enter Number of Tokens:</label>
                <input type="number" name="token_count" id="token_count" class="form-control mb-2" min="1" max="500" required>
                <label for="token_count" class="form-label">Enter Google Auth Code:</label>
                <input type="number" name="google_auth_code" class="form-control mb-2" min="1"  required >
                <button type="submit" class="btn btn-primary">Generate Tokens</button>
            </form>
        </div>
    </div>


    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Token</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($tokens as $index => $token)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $token->token }}</td>
                    <td>
                        <span class="badge {{ $token->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($token->status) }}
                        </span>
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $tokens->links() }}
    </div>
    @endsection
