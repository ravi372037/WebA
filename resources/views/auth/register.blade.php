@extends('layout.main')
@section('title', 'Register')
@section('content')
    <div class="row  justify-content-center">
        <div class="col-md-5 my-5">
            <div class="card">
                <div class="card-header">
                    Fill Details :
                </div>
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="msg_box"
                        style="display: none;">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>Success</strong> <span id="msg"></span>
                    </div>
                    <form id="userForm" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <span id="name-error" class="text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <span id="email-error" class="text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile:</label>
                            <input type="text" maxlength="10" name="mobile" id="mobile" class="form-control">
                            <span id="mobile-error" class="text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea name="address" id="address" class="form-control"></textarea>
                            <span id="address-error" class="text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <span id="password-error" class="text-danger"></span>
                        </div>
                        <br>
                        <button type="button" id="submitForm" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-danger">Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#submitForm').on('click', function() {
                $.ajax({
                    url: '{{ route('registerCustomer') }}',
                    type: 'POST',
                    data: $('#userForm').serialize(),
                    success: function(response) {
                        $('#userForm').trigger('reset');
                        $('#msg_box').show();
                        $('#msg').text(response.message);



                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        console.error(errors);


                        $.each(errors, function(key, value) {
                            $('#' + key + '-error').text(value[0]);
                        });
                    }
                });
            });
        });
    </script>
@endsection
