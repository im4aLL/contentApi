@extends('master')
@section('title', 'Create content')

@section('content')

    @if( isset($category) )
        <h2 class="hl-primary">Edit content</h2>
        {!! Form::model($content, ['route' => ['admin.content.update', $content->id], 'method' => 'PUT', 'class' => 'form']) !!}
    @else
        <h2 class="hl-primary">Create content</h2>
        {!! Form::open(['url' => route('admin.content.store'), 'class' => 'form']) !!}
    @endif

    <div class="block">
        <div class="block-header">
            @if( isset($content) )
                <button type="submit" class="btn btn-black">Save and update content</button>
            @else
                <button type="submit" class="btn btn-primary">Save and create content</button>
            @endif
        </div>
        <div class="block-body">
            <div class="row">
                <div class="col-sm-12 col-lg-6">

                    <div class="form-group">
                        {!! Form::label('key', 'Key') !!}
                        {!! Form::text('key', old('key'), ['class' => 'form-control', 'placeholder' => 'A unique key']) !!}
                        <span class="help-block"><small>This unique key allows later to pull this content</small></span>
                    </div>

                    <div class="form-group">
                        {!! Form::label('cat_id', 'Category') !!}
                        {!! Form::select('cat_id', array_merge([0 => 'Uncategorized'], $categories), old('cat_id'), ['class' => 'form-control']) !!}
                        <span class="help-block"><small>Every content should be in a category else select uncategorized</small></span>
                    </div>

                    <div class="form-group">
                        {!! Form::label('title', 'Title') !!}
                        {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Content title']) !!}
                        <span class="help-block"><small>Page headline</small></span>
                    </div>

                    <div class="form-group">
                        {!! Form::label('subtitle', 'Sub Title') !!}
                        {!! Form::text('subtitle', old('subtitle'), ['class' => 'form-control', 'placeholder' => 'Content sub title']) !!}
                        <span class="help-block"><small>Page sub headline</small></span>
                    </div>

                    <div class="form-group">
                        {!! Form::label('content', 'Contents') !!}
                        {!! Form::text('content[key][]', 'one', ['class' => 'form-control form-control-single', 'placeholder' => 'Content key']) !!}
                        {!! Form::textarea('content[html][]', null, ['class' => 'form-control editor', 'placeholder' => 'Type here ...', 'rows' => 15]) !!}
                        <span class="help-block"><small>Your page content usually long description</small></span>
                    </div>

                    <div class="form-group">
                        <div class="radio"><label>{!! Form::radio('state', 1, old('state')) !!} Publish now</label></div>
                        <div class="radio"><label>{!! Form::radio('state', 0, old('state')) !!} Don't publish now</label></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="block-footer">
            @if( isset($category) )
                <button type="submit" class="btn btn-black">Save and update content</button>
            @else
                <button type="submit" class="btn btn-primary">Save and create content</button>
            @endif
        </div>
    </div>

    {!! Form::close() !!}
@endsection
