@if(auth()->user()->role == 'admin')
    <h1>Welcome, Admin!</h1>
@else
    <h1>Access Denied</h1>
@endif