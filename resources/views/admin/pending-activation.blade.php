@extends('layouts.app')
@section('sidebar')
 @include('layouts.sidebar')
@endsection

@section('content')
 @include('layouts.topbar')
    

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="py-4">

        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Pending Activations</h1>
                
            </div>
          
        </div>
    </div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                <tr>
                    <th class="border-bottom" scope="col">User name</th>
                    <th class="border-bottom" scope="col">Whats app</th>
                    <th class="border-bottom" scope="col">Need Tokens</th>
                    <th class="border-bottom" scope="col">Package Value</th>
                    <th class="border-bottom" scope="col">Action</th>

                </tr>
                </thead>
                <tbody>
                    @foreach ($activations as $activation)
                   
                    <tr>
                        <td>{{ $activation->user->name ?? 'Unknown User' }}</td>
                        <td>{{ $activation->user->whatsapp_number }}</td>

                        <td><span class="badge bg-success">{{ $activation->userpackage->price - ($activation->userpackage->price * ($feePercentage/100)) }} </span></td>
                        <td>{{ $activation->userpackage->price }}</td>
                        <td>
                            <button class="btn btn-primary active-package" data-id="{{ $activation->id }}">Active</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $activations->links() }}
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Listen for clicks on the "Update" button
        $('.active-package').on('click', function() {
            // Get the package ID from the button's data-id attribute
            var packageId = $(this).data('id');

            // Send the AJAX request to the server
            $.ajax({
                url: '/active-package', // Replace with your route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    package_id: packageId // Pass the package ID
                },
                success: function(response) {
                    // Show SweetAlert for success with the response message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Package updated successfully!' // Use the response message if available
                    }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Reload the page after clicking OK
                        }
                    });

                    // Optionally, refresh the table or make other UI updates
                },
                error: function(xhr, status, error) {
                    // Show SweetAlert for error with the error message from the server
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.message || 'Error updating package.' // Use the error message from the response if available
                    });
                }
            });
        });
    });
</script>

@endsection