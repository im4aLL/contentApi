@if (session('alert-success'))
    <div class="alert alert-success">
        {{ session('alert-success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@elseif (session('alert-info'))
    <div class="alert alert-info">
        {{ session('alert-info') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@elseif (session('alert-warning'))
    <div class="alert alert-warning">
        {{ session('alert-warning') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@elseif (session('alert-danger'))
    <div class="alert alert-danger">
        {{ session('alert-danger') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif
