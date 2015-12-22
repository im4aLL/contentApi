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

    public function __construct()
    {
        $this->additional_fields = session('admin_content_settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::with('category')->get();
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

        $data['content'] = [];

        $content_array = array_map('array_values', $request->input('content'));
        for($i = 0; $i < count($content_array['html']); $i++)
        {
            if(trim($content_array['html'][$i]) != NULL) {
                $key = trim($content_array['key'][$i]) != NULL ? $content_array['key'][$i] : $i;
                $data['content'][snake_case($key)] = $content_array['html'][$i];
            }
        }
        $data['content'] = collect($data['content'])->toJson();
        $data['content_types'] = is_array($this->additional_fields) && count($this->additional_fields) > 0 ? json_encode($this->additional_fields) : '';

        return $request->all();

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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {

        $categories = Cat::select('id', 'name')->lists('name', 'id')->toArray();
        $content = Content::findOrFail($id);
        $additional_fields = (array) json_decode($content->content_types);


        $content['content'] = [];
        print_r($content->content);
        $counter = 0;
        foreach($content->content as $c) {
            if($counter == 0) {
                $content['content'][0] = $c;
            }
            else {
                $content['content'][0] = $c;
            }

            $counter++;
        }
        return $content;

        return view('admin.content.form', compact('categories', 'additional_fields', 'content'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function settings(Request $request)
    {
        $request->session()->forget('admin_content_settings');

        $settings = [];
        if( $request->input('additional_fields') == 'remove' )
        {

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
        return redirect()->back()->with('alert-success', 'Additional fields updated!');
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
