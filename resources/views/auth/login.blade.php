@extends('master')
@section('title', 'Authentication')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-4 col-md-offset-4">

            <div class="login">
                <form method="POST" action="/auth/login" class="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>

        </div>
    </div>
@endsection
