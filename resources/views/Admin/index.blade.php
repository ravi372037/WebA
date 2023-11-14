@extends('layout.main')
@section('title', 'Customer')
@section('content')
    <h1 class="text-center">Welcome! {{ Auth::user()->name }} <a href="{{ route('logout') }}" style="float: right"><img
                src="{{ asset('logout.png') }}" style="height: 50px" alt=""></a></h1>
    <div class="container">
<hr>

        <div class="row my-5 justify-content-center">
            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-header">
                        Total Customer :
                    </div>
                    <div class="card-body">
                        <h1>{{ $users->count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-header">
                        Verfied Customer :
                    </div>
                    <div class="card-body">
                        <h1>{{ $verified_users }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-header">
                        Pending Customer :
                    </div>
                    <div class="card-body">
                        <h1>{{ $pending_users }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-header">
                        Rejected Customer :
                    </div>
                    <div class="card-body">
                        <h1>{{ $rejected_users }}</h1>
                    </div>
                </div>
            </div>
        </div>
<hr>
        <div class="row my-5">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Success</strong> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Failed</strong> {{ session('error') }}
                </div>
            @endif
            <h3 class="text-center">Customer List</h3>
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>


                        @php
                            $i = 1;
                        @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>
                                    <textarea readonly cols="30" rows="3">{{ $user->address }}</textarea>
                                </td>
                                <td>
                                    @if ($user->status == 0)
                                        <span class="badge text-bg-warning"><i class="fa fa-clock" aria-hidden="true"></i>
                                            Pending</span>
                                    @elseif ($user->status == 1)
                                        <span class="badge text-bg-success"> <i class="fa fa-check"></i> Verified</span>
                                    @elseif ($user->status == 2)
                                        <span class="badge text-bg-danger"><i class="fa fa-xmark"></i> Rejected</span>
                                    @endif
                                </td>
                                <td>

                                    @if ($user->status != 1)
                                    <a href="{{ route('change_status', ['status' => 1, 'id' => $user->id]) }}"
                                        class="btn btn-success"
                                        onclick="return confirm('Are you sure you want to verified this?');"> <i
                                            class="fa fa-check"></i></a>
                                    @endif
                                    @if ($user->status != 2)
                                        <a href="{{ route('change_status', ['status' => 2, 'id' => $user->id]) }}"
                                            class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to rejected this?');"> <i
                                                class="fa fa-xmark"></i></a>
                                    @endif

                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#updateUserModal" data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}"
                                        data-user-mobile="{{ $user->mobile }}" data-user-address="{{ $user->address }}">
                                        <i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Details Update MOdal -->
    <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Details:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateUserForm" action="{{ route('update_customer') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
</script>

    <script>
        $(document).ready(function() {
            @if ($errors->any())
                $('#updateUserModal').modal('show');
            @endif
            $('#updateUserModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var userId = button.data('user-id');
                var userName = button.data('user-name');
                var userEmail = button.data('user-email');
                var userMobile = button.data('user-mobile');
                var userAddress = button.data('user-address');

                $('#user_id').val(userId);
                $('#name').val(userName);
                $('#email').val(userEmail);
                $('#mobile').val(userMobile);
                $('#address').val(userAddress);


            });
        });
    </script>

@endsection
