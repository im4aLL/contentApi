@extends('admin.layout.master')
@section('title', 'Home')

@section('content')
    <h2 class="hl-primary">Change password</h2>
    {!! Form::open(['url' => route('admin.usersettings'), 'method' => 'PUT']) !!}

    <div class="block">
        <div class="block-header">
            <button type="submit" class="btn btn-primary">Save and change password</button>
        </div>
        <div class="block-body">
            <div class="row">
                <div class="col-sm-12 col-lg-6">

                    <div class="form-group">
                        <label for="oldpassword">Current password</label>
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Your current password">
                    </div>

                    <div class="form-group">
                        <label for="password">New password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Your new password">
                    </div>

                    <div class="form-group">
                        <label for="repassword">Retype your new password</label>
                        <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Retype your new password">
                    </div>

                </div>
            </div>
        </div>
        <div class="block-footer">
            <button type="submit" class="btn btn-primary">Save and change password</button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
