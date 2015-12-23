<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ContentFormRequest;
use App\Http\Requests\Admin\UpdateStateRequest;
use App\Models\Admin\Cat;
use App\Models\Admin\Content;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminContentController extends Controller
{
    private $additional_fields;
    private $remove_additional_field_flag;

    /**
     * Contructor function
     */
    public function __construct()
    {
        $this->additional_fields = session('admin_content_settings');
        $this->remove_additional_field_flag = session('admin_content_settings_remove') ? session('admin_content_settings_remove') : false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->destroyAllSettings();

        $contents = Content::with('category')->orderBy('id', 'DESC')->get();
        return view('admin.content.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Cat::select('id', 'name')->lists('name', 'id')->toArray();
        $additional_fields = $this->additional_fields;
        return view('admin.content.form', compact('categories', 'additional_fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContentFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentFormRequest $request)
    {
        $data = [];
        $data['key'] = $request->input('key');
        $data['cat_id'] = $request->input('cat_id');
        $data['title'] = $request->input('title');
        $data['subtitle'] = $request->input('subtitle');
        $data['user_id'] = auth()->user()->id;
        $data['state'] = $request->input('state');
        $data['content'] = Content::formatContentToJson($request->input('content'));
        $data['content_types'] = is_array($this->additional_fields) && count($this->additional_fields) > 0 ? json_encode($this->additional_fields) : '';

        $content = Content::create($data);
        $request->session()->forget('admin_content_settings');
        return redirect()->route('admin.content')->with('alert-success', $content->title.' content has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $categories = Cat::select('id', 'name')->lists('name', 'id')->toArray();
        $content = Content::findOrFail($id);

        if($this->remove_additional_field_flag == false) {
            $additional_fields = (array) json_decode($content->content_types);
        }
        $contents = Content::buildContentArray($content);

        return view('admin.content.form', compact('categories', 'additional_fields', 'content', 'contents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContentFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContentFormRequest $request, $id)
    {
        $content = Content::findOrFail($id);

        $data = [];
        $data['key'] = $request->input('key');
        $data['cat_id'] = $request->input('cat_id');
        $data['title'] = $request->input('title');
        $data['subtitle'] = $request->input('subtitle');
        $data['state'] = $request->input('state');
        $data['content'] = Content::formatContentToJson($request->input('content'));
        $data['content_types'] = is_array($this->additional_fields) && count($this->additional_fields) > 0 ? json_encode($this->additional_fields) : $content->content_types;

        $content->update($data);
        $this->destroyAllSettings();

        return redirect()->route('admin.content')->with('alert-success', $content->title.' content has been updated!');
    }


    /**
     * Add or update additional field data into from
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function settings(Request $request)
    {
        $request->session()->forget('admin_content_settings');

        $settings = [];
        if( $request->input('additional_fields') == 'remove' )
        {
            $request->session()->put('admin_content_settings_remove', true);
        }
        else {
            for($i = 0; $i < count($request->input('field_type')); $i++ ) {
                $type = $request->input('field_type')[$i];
                $qty = $request->input('quantity')[$i];

                if($type != NULL && $qty > 0) {
                    $settings['field_type'][] = $request->input('field_type')[$i];
                    $settings['quantity'][] = $request->input('quantity')[$i];
                }
            }
        }

        $request->session()->put('admin_content_settings', $settings);
        return redirect()->back()->with('alert-info', 'Additional fields updated! (temporary) P.S. Until you hit save, data will not be saved!');
    }

    /**
     * Destroy all additional field settings
     */
    public function destroyAllSettings()
    {
        session()->forget('admin_content_settings_remove');
        session()->forget('admin_content_settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UpdateStateRequest $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(UpdateStateRequest $request)
    {
        $items = $request->input('items');
        $request->session()->flash('alert-success', 'Selected categories has been deleted!');
        return Content::destroy($items);
    }

    /**
     * Publish items
     *
     * @param  UpdateStateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function publish(UpdateStateRequest $request)
    {
        $items = $request->input('items');
        $request->session()->flash('alert-success', 'Selected categories has been published!');
        return Content::whereIn('id', $items)->update(['state' => 1]);
    }

    /**
     * Unpublish items
     *
     * @param  UpdateStateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function unpublish(UpdateStateRequest $request)
    {
        $items = $request->input('items');
        $request->session()->flash('alert-success', 'Selected categories has been unpublished!');
        return Content::whereIn('id', $items)->update(['state' => 0]);
    }
}
