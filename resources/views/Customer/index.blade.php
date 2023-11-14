@extends('layout.main')
@section('title', 'Customer')
@section('content')
    <h1 class="text-center">Welcome! {{ Auth::user()->name }} <a href="{{ route('logout') }}" style="float: right"><img
                src="{{ asset('logout.png') }}" style="height: 50px" alt=""></a></h1>

    <div class="container">
        <hr>
        <div class="row my-5 justify-content-center">
            <div class="col-md-5 ">
                <div class="card">
                    <div class="card-header">
                        Profile Details :
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ Auth::user()->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ Auth::user()->address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
