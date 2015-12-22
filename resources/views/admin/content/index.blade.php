@extends('master')
@section('title', 'Manage content')

@section('content')
    <h2 class="hl-primary">Manage contents</h2>

    <div class="table-bar">
        <a href="{{ route('admin.content.create') }}" class="btn btn-primary">Add content</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th width="35"><input type="checkbox" id="selectall"></th>
                <th>Title</th>
                <th>Category</th>
                <th>Key</th>
                <th class="text-center">Last modified at</th>
                <th class="text-center">Published?</th>
            </tr>
            </thead>
            <tbody>
            @if( count($contents) == 0 )
                <tr>
                    <td colspan="6">No record found!</td>
                </tr>
            @else
                @foreach($contents as $content)
                    <tr{!! $content->state == 0 ? ' class="warning"' : '' !!}>
                        <td><input type="checkbox" name="select[]" value="{{ $content->id }}"></td>
                        <td><a href="{{ route('admin.content.edit', ['content' => $content->id]) }}">{{ $content->title }}</a></td>
                        <td>{{ $content->category->name }}</td>
                        <td>{{ $content->key }}</td>
                        <td class="text-center">
                            @if ($content->updated_at == $content->created_at)
                                Never
                            @else
                                {{ $content->updated_at->diffForHumans() }}
                            @endif
                        </td>
                        <td class="text-center">{!! $content->state == 1 ? '<i class="glyphicon glyphicon-ok"></i>' : '<i class="glyphicon glyphicon-time"></i>' !!}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="table-bar table-bar-secondary">
            <button type="button" class="btn btn-default" data-ajax-submit="publish" data-ajax-route="{{ route('admin.content.publish') }}">Publish selected</button>
            <button type="button" class="btn btn-default" data-ajax-submit="unpublish" data-ajax-route="{{ route('admin.content.unpublish') }}">Unpublish selected</button>
            <button type="button" class="btn btn-default" data-ajax-submit="delete" data-ajax-route="{{ route('admin.content.delete') }}">Delete selected</button>
        </div>
    </div>
@endsection
