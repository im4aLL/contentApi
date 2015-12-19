@extends('master')
@section('title', 'Manage categories')

@section('content')
    <h2 class="hl-primary">Categories</h2>

    <div class="table-bar">
        <a href="{{ route('admin.cat.create') }}" class="btn btn-primary">Add category</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="35"><input type="checkbox" id="selectall"></th>
                    <th>Name</th>
                    <th class="text-center">Last modified at</th>
                    <th class="text-center">Published?</th>
                </tr>
            </thead>
            <tbody>
            @if( count($categories) == 0 )
                <tr>
                    <td colspan="4">No record found!</td>
                </tr>
            @else
                @foreach($categories as $category)
                    <tr{!! $category->state == 0 ? ' class="warning"' : '' !!}>
                        <td><input type="checkbox" name="select[]" value="{{ $category->id }}"></td>
                        <td><a href="{{ route('admin.cat.edit', ['cat' => $category->id]) }}">{{ $category->name }}</a></td>
                        <td class="text-center">
                            @if ($category->updated_at == $category->created_at)
                                Never
                            @else
                                {{ $category->updated_at->diffForHumans() }}
                            @endif
                        </td>
                        <td class="text-center">{!! $category->state == 1 ? '<i class="glyphicon glyphicon-ok"></i>' : '<i class="glyphicon glyphicon-time"></i>' !!}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="table-bar table-bar-secondary">
            <button type="button" class="btn btn-default" data-ajax-submit="publish" data-ajax-route="{{ route('admin.cat.publish') }}">Publish selected</button>
            <button type="button" class="btn btn-default" data-ajax-submit="unpublish" data-ajax-route="{{ route('admin.cat.unpublish') }}">Unpublish selected</button>
            <button type="button" class="btn btn-default" data-ajax-submit="delete" data-ajax-route="{{ route('admin.cat.delete') }}">Delete selected</button>
        </div>
    </div>
@endsection
