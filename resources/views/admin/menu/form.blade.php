@extends('admin.layout.master')
@section('title', 'Create menu')

@section('content')

    @if( isset($menu) )
        <h2 class="hl-primary">Edit menu</h2>
        {!! Form::model($menu, ['route' => ['admin.menu.update', $menu->id], 'method' => 'PUT']) !!}
    @else
        <h2 class="hl-primary">Create menu</h2>
        {!! Form::open(['url' => route('admin.menu.store')]) !!}
    @endif

        <div class="block">
            <div class="block-header">
                @if( isset($menu) )
                    <button type="submit" class="btn btn-black">Save and update menu</button>
                @else
                    <button type="submit" class="btn btn-primary">Save and create menu</button>
                @endif
            </div>
            <div class="block-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">

                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Menu name']) !!}
                            <span class="help-block"><small>e.g Home, About us, Contact</small></span>
                        </div>

                        <div class="form-group">
                            {!! Form::label('slug', 'Slug') !!}
                            <div class="input-group">
                                <div class="input-group-addon">{{ url() }}/</div>
                                {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => 'URL slug, leave blank for auto generate']) !!}
                            </div>
                            <span class="help-block"><small>If you leave this blank slug will be automatically created. Recommended: Leave blank</small></span>
                        </div>

                        <div class="form-group">
                            {!! Form::label('parent_id', 'Parent item') !!}
                            {!! Form::select('parent_id', array_merge([0 => 'Select if this is child menu'], $menus), old('parent_id'), ['class' => 'form-control']) !!}
                            <span class="help-block"><small>If this is a child menu select it's parent menu item</small></span>
                        </div>

                        <div class="form-group">
                            {!! Form::label('order', 'Order') !!}
                            {!! Form::text('order', old('order'), ['class' => 'form-control', 'placeholder' => 'Order number']) !!}
                            <span class="help-block"><small>e.g Order menu as the way you want, e.g 1, 2, 4</small></span>
                        </div>

                        <hr>
                        <span class="label label-default">Menu must be link with a content or category or custom route</span>
                        <hr>

                        <div class="form-group">
                            {!! Form::label('content_id', 'Link with content') !!}
                            {!! Form::select('content_id', $contents, old('content_id'), ['class' => 'form-control']) !!}
                            <span class="help-block"><small>Establish link with content</small></span>
                        </div>

                        <div class="form-group">
                            {!! Form::label('cat_id', 'Link with category') !!}
                            {!! Form::select('cat_id', $categories, old('cat_id'), ['class' => 'form-control']) !!}
                            <span class="help-block"><small>Establish link with a category</small></span>
                        </div>

                        <div class="form-group">
                            {!! Form::label('raw_path', 'Custom route') !!}
                            {!! Form::text('raw_path', old('raw_path'), ['class' => 'form-control', 'placeholder' => 'For developer usage only, leave this blank']) !!}
                            <span class="help-block"><small>e.g SiteController@methodName</small></span>
                        </div>

                        <hr>

                        <div class="form-group">
                            <div class="radio"><label>{!! Form::radio('is_homepage', 1, old('is_homepage')) !!} Set this menu as homepage</label></div>
                            <div class="radio"><label>{!! Form::radio('is_homepage', 0, old('is_homepage')) !!} This menu isn't homepage</label></div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <div class="radio"><label>{!! Form::radio('state', 1, old('state')) !!} Publish now</label></div>
                            <div class="radio"><label>{!! Form::radio('state', 0, old('state')) !!} Don't publish now</label></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="block-footer">
                @if( isset($menu) )
                    <button type="submit" class="btn btn-black">Save and update menu</button>
                @else
                    <button type="submit" class="btn btn-primary">Save and create menu</button>
                @endif
            </div>
        </div>

    {!! Form::close() !!}
@endsection

@section('inpagescripts')
    <script>
        jQuery(document).ready(function(){
            $('[name="content_id"]').on('change', function () {
                $('[name="cat_id"], [name="raw_path"]').val('');
            });

            $('[name="cat_id"]').on('change', function () {
                $('[name="content_id"], [name="raw_path"]').val('');
            });

            $('[name="raw_path"]').on('change', function () {
                $('[name="cat_id"], [name="content_id"]').val('');
            });
        });
    </script>
@endsection
