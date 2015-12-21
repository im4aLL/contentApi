<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ContentFormRequest;
use App\Models\Admin\Cat;
use App\Models\Admin\Content;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::all();
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
        $additional_fields = session('admin_content_settings');
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
        return $request->all();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
}
