@extends('layouts.app')
@section('sidebar')
 @include('layouts.sidebar')
@endsection

@section('content')
 @include('layouts.topbar')



<div class="row mt-4">
    <div class="col-12 mb-4">
        <div class="card bg-yellow-100 border-0 shadow">
            <div class="card-header d-sm-flex flex-row align-items-center flex-0">
                <div class="d-block mb-3 mb-sm-0">
                    <div class="fs-5 fw-normal mb-2"></div>
                    <h2 class="fs-3 fw-extrabold">Welcome, {{auth()->user()->role}}</h2>

                </div>

            </div>
            <div class="card-body p-2">
                <div class="container ref">
                    
                    <label>Your Referral Link</label>
                    <input type="text" id="urlInput" class="form-control" placeholder="Enter a URL here" value="{{ $refLink }}" readonly>

                    <button type="button" id="copyButton" class="btn btn-primary d-inline-flex align-items-center">
                        Copy URL
                        <svg class="icon icon-xxs ms-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd"></path></svg>
                    </button>
                    
            
                    <div id="urlDisplay" class="url-display"></div>
                </div>    
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-xl-6 mb-6">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="h5">My Token</h2>
                            <h3 class="fw-extrabold mb-1">{{$myTokens}}</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-gray-400 mb-0">My Token</h2>
                            <h3 class="fw-extrabold mb-2">{{$myTokens}}</h3>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-xl-6 mb-6">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="fw-extrabold h5">My Wallet</h2>
                            <h3 class="mb-1">{{$myWallet->balance ?? 0}}</h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h6 text-gray-400 mb-0">My Wallet</h2>
                            <h3 class="fw-extrabold mb-2">{{$myWallet->balance ?? 0}}</h3>
                        </div>
                       
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="fs-5 fw-bold mb-0">Activations</h2>
                                </div>
                                <div class="col text-end">
                                    <a href="#" class="btn btn-sm btn-primary">See all</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th class="border-bottom" scope="col">User name</th>
                                    <th class="border-bottom" scope="col">Whats app</th>
                                    <th class="border-bottom" scope="col">Need Tokens</th>
                                    <th class="border-bottom" scope="col">Action</th>
    
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activations as $activation)
                                   
                                    <tr>
                                        <td>{{ $activation->user->name ?? 'Unknown User' }}</td>
                                        <td>{{ $activation->user->whatsapp_number }}</td>

                                        <td><span class="badge bg-success">{{ $activation->package - ($activation->package * ($feePercentage/100)) }}</span></td>
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
                
               
            </div>
        </div>

    </div>

</div>

<div class="theme-settings card bg-gray-800 pt-2 collapse" id="theme-settings">
<div class="card-body bg-gray-800 text-white pt-4">
<button type="button" class="btn-close theme-settings-close" aria-label="Close" data-bs-toggle="collapse"
href="#theme-settings" role="button" aria-expanded="false" aria-controls="theme-settings"></button>
<div class="d-flex justify-content-between align-items-center mb-3">
<p class="m-0 mb-1 me-4 fs-7">Open source <span role="img" aria-label="gratitude">💛</span></p>
<a class="github-button" href="https://github.com/themesberg/volt-bootstrap-5-dashboard"
    data-color-scheme="no-preference: dark; light: light; dark: light;" data-icon="octicon-star"
    data-size="large" data-show-count="true"
    aria-label="Star themesberg/volt-bootstrap-5-dashboard on GitHub">Star</a>
</div>
<a href="https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard" target="_blank"
class="btn btn-secondary d-inline-flex align-items-center justify-content-center mb-3 w-100">
Download 
<svg class="icon icon-xs ms-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd"></path></svg>
</a>
<p class="fs-7 text-gray-300 text-center">Available in the following technologies:</p>
<div class="d-flex justify-content-center">
<a class="me-3" href="https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard"
    target="_blank">
    <img src="../../assets/img/technologies/bootstrap-5-logo.svg" class="image image-xs">
</a>
<a href="https://demo.themesberg.com/volt-react-dashboard/#/" target="_blank">
    <img src="../../assets/img/technologies/react-logo.svg" class="image image-xs">
</a>
</div>
</div>
</div>



@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function redirectToTokens() {
        var userId = document.getElementById("user_id").value;
        if (userId) {
            window.location.href = "/view-tokens/" + userId;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please select a user before proceeding.'
            });
        }
    }

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
                    // Show SweetAlert for success
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Package updated successfully!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Reload the page after clicking OK
                        }
                    });
                    // Optionally, refresh the table or make other UI updates
                },
                error: function(xhr, status, error) {
                    // Show SweetAlert for error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating package.'
                    });
                }
            });
        });
    });
</script>

@endsection