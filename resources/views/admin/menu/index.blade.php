@extends('admin.layout.master')
@section('title', 'Manage menus')

@section('content')
    <h2 class="hl-primary">Manage menus</h2>

    <div class="table-bar">
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">Add menu</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="35"><input type="checkbox" id="selectall"></th>
                    <th>Name</th>
                    <th>Parent of</th>
                    <th>Slug</th>
                    <th class="text-center">Last modified at</th>
                    <th class="text-center">Published?</th>
                </tr>
            </thead>
            <tbody>
            @if( count($menus) == 0 )
                <tr>
                    <td colspan="6">No record found!</td>
                </tr>
            @else
                @foreach($menus as $menu)
                    <tr{!! $menu->state == 0 ? ' class="warning"' : '' !!}>
                        <td><input type="checkbox" name="select[]" value="{{ $menu->id }}"></td>
                        <td><a href="{{ route('admin.menu.edit', ['menu' => $menu->id]) }}">{{ $menu->name }}</a></td>
                        <td>{{ $menu->parent_id != 0 ? $menus->where('id', $menu->parent_id)->first()->name : '-' }}</td>
                        <td>{{ ($menu->slug == '/') ? '/' : '/'. $menu->slug  }}</td>
                        <td class="text-center">
                            @if ($menu->updated_at == $menu->created_at)
                                Never
                            @else
                                {{ $menu->updated_at->diffForHumans() }}
                            @endif
                        </td>
                        <td class="text-center">{!! $menu->state == 1 ? '<i class="glyphicon glyphicon-ok"></i>' : '<i class="glyphicon glyphicon-time"></i>' !!}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="table-bar table-bar-secondary">
            <button type="button" class="btn btn-default" data-ajax-submit="publish" data-ajax-route="{{ route('admin.menu.publish') }}">Publish selected</button>
            <button type="button" class="btn btn-default" data-ajax-submit="unpublish" data-ajax-route="{{ route('admin.menu.unpublish') }}">Unpublish selected</button>
            <button type="button" class="btn btn-default" data-ajax-submit="delete" data-ajax-route="{{ route('admin.menu.delete') }}">Delete selected</button>
        </div>
    </div>
@endsection
