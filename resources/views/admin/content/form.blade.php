@extends('master')
@section('title', 'Create content')

@section('content')



    @if( isset($category) )
        <h2 class="hl-primary">Edit content <small><a href="" data-toggle="modal" data-target="#settings">Additional fields</a></small></h2>
    @else
        <h2 class="hl-primary">Create content <small><a href="" data-toggle="modal" data-target="#settings">Additional fields</a></small></h2>
    @endif

    <div class="modal fade" id="settings" tabindex="-1">
        {!! Form::open(['url' => route('admin.content.settings'), 'class' => 'form form-inline']) !!}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title">Form settings <small>additional fields</small></h4>
                </div>
                <div class="modal-body">

                    <div class="settings-form-wrapper">
                        <div class="settings-form-master-field">
                            <div class="form-group">
                                <label>Field type</label>
                                <select name="field_type[]" class="form-control">
                                    <option value="">Please select</option>
                                    <option value="text">Text</option>
                                    <option value="plaintextarea">Plain textarea</option>
                                    <option value="richtexteditor">Rice text editor</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" class="form-control" name="quantity[]" value="1">
                            </div>
                        </div>

                        @if( isset($additional_fields['field_type']) )
                            @for($i = 0; $i < count($additional_fields['field_type']); $i++)
                                <div class="settings-form-master-field">
                                    <div class="form-group">
                                        <label>Field type</label>
                                        <select name="field_type[]" class="form-control">
                                            <option value="">Please select</option>
                                            <option value="text"{{ $additional_fields['field_type'][$i] == 'text' ? ' selected="selected"': '' }}>Text</option>
                                            <option value="plaintextarea"{{ $additional_fields['field_type'][$i] == 'plaintextarea' ? ' selected="selected"': '' }}>Plain textarea</option>
                                            <option value="richtexteditor"{{ $additional_fields['field_type'][$i] == 'richtexteditor' ? ' selected="selected"': '' }}>Rice text editor</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="text" class="form-control" name="quantity[]" value="{{ $additional_fields['quantity'][$i] }}">
                                    </div>
                                </div>
                            @endfor
                        @endif

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-black pull-left settings-form-addmore">Add one more field</button>
                    <button type="submit" class="btn btn-primary pull-left" value="remove" name="additional_fields">Remove all additional fields</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add above field(s)</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="clearfix"></div>

    @if( isset($contents) )
        {!! Form::model($contents, ['route' => ['admin.content.update', $content->id], 'method' => 'PUT', 'class' => 'form']) !!}
    @else
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
                        {!! Form::label('key', 'Content API key') !!}
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
                        {!! Form::text('content[key][0]', 'one', ['class' => 'form-control form-control-single', 'placeholder' => 'Content key']) !!}
                        {!! Form::textarea('content[html][0]', null, ['class' => 'form-control editor', 'placeholder' => 'Type here ...', 'rows' => 15]) !!}
                        <span class="help-block"><small>Your page content usually long description</small></span>
                    </div>

                    <div class="form-group">
                        @if( isset($additional_fields['field_type']) )
                            <hr>
                            <label>Additional fields</label>
                            @for($i = 0; $i < count($additional_fields['field_type']); $i++)
                                @for($j = 0; $j < $additional_fields['quantity'][$i]; $j++)
                                    {!! Form::text('content[key][]', null, ['class' => 'form-control form-control-single', 'placeholder' => 'Content key']) !!}
                                    @if($additional_fields['field_type'][$i] == 'text')
                                        {!! Form::text('content[html][]', null, ['class' => 'form-control form-control-single', 'placeholder' => 'Content details']) !!}
                                    @elseif($additional_fields['field_type'][$i] == 'plaintextarea')
                                        {!! Form::textarea('content[html][]', null, ['class' => 'form-control form-control-single', 'placeholder' => 'Type here ...', 'rows' => 10]) !!}
                                    @elseif($additional_fields['field_type'][$i] == 'richtexteditor')
                                        {!! Form::textarea('content[html][]', null, ['class' => 'form-control editor form-control-single', 'placeholder' => 'Type here ...', 'rows' => 15]) !!}
                                    @endif
                                    <hr>
                                @endfor
                            @endfor
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="radio"><label>{!! Form::radio('state', 1, old('state')) !!} Publish now</label></div>
                        <div class="radio"><label>{!! Form::radio('state', 0, old('state')) !!} Don't publish now</label></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="block-footer">
            @if( isset($contents) )
                <button type="submit" class="btn btn-black">Save and update content</button>
            @else
                <button type="submit" class="btn btn-primary">Save and create content</button>
            @endif
        </div>
    </div>

    {!! Form::close() !!}
@endsection


@section('inpagescripts')
    <script>
        jQuery(document).ready(function($){
            $('html').delegate('.settings-form-addmore', 'click', function(event){
                event.preventDefault();
                var $settingsContainer = $(this).closest('.modal').find('.settings-form-wrapper');
                var $masterField = $settingsContainer.find('.settings-form-master-field:first');

                $masterField.clone().appendTo($settingsContainer);
            });
        });
    </script>
@endsection
