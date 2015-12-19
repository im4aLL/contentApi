<header class="header clearfix">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <a href="{{ route('admin.root') }}" class="header-logo"><h3>Dashboard <small>v1.0.0</small></h3></a>
            </div>
            <div class="col-sm-6">

                <div class="btn-group pull-right header-quick-menu">
                    <button type="button" class="btn btn-default">Welcome, {{ auth()->user()->name }}!</button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Change password</a></li>
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</header>
