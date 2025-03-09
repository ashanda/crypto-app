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
                <h1 class="h4">Buy Packages History</h1>
                
            </div>
           
        </div>
    </div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        @if (!$activePackage)
        <a class="btn btn-primary mb-4" href="{{ route('buy.package') }}">Buy Package</a>
        @endif
      
        <div class="table-responsive">
           
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                <tr>
                    <th class="border-bottom" scope="col">User name</th>
                    <th class="border-bottom" scope="col">Package</th>
                    <th class="border-bottom" scope="col">Earn</th>
                    <th class="border-bottom" scope="col">Buy Date</th>

                </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                   
                    <tr>
                        <td>{{ $package->user->name ?? 'Unknown User' }}</td>
                        <td>{{ $package->package }}</td>

                        <td><span class="badge bg-success">{{ $package->earn ?? 0 }}</span></td>
                        <td><span class="badge bg-info">{{ $package->created_at }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $packages->links() }}
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