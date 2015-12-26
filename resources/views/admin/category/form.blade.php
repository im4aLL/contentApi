@extends('admin.layout.master')
@section('title', 'Create category')

@section('content')

    @if( isset($category) )
        <h2 class="hl-primary">Edit category</h2>
        {!! Form::model($category, ['route' => ['admin.cat.update', $category->id], 'method' => 'PUT']) !!}
    @else
        <h2 class="hl-primary">Create category</h2>
        {!! Form::open(['url' => route('admin.cat.store')]) !!}
    @endif

        <div class="block">
            <div class="block-header">
                @if( isset($category) )
                    <button type="submit" class="btn btn-black">Save and update category</button>
                @else
                    <button type="submit" class="btn btn-primary">Save and create category</button>
                @endif
            </div>
            <div class="block-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">

                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Category name']) !!}
                            <span class="help-block"><small>e.g Product</small></span>
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
                    <button type="submit" class="btn btn-black">Save and update category</button>
                @else
                    <button type="submit" class="btn btn-primary">Save and create category</button>
                @endif
            </div>
        </div>

    {!! Form::close() !!}
@endsection
