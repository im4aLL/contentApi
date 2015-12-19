<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CatFormRequest;
use App\Http\Requests\Admin\UpdateStateRequest;
use App\Models\Admin\Cat;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Cat::all();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CatFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatFormRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

        $category = Cat::create($data);

        return redirect()->route('admin.cat')->with('alert-success', $category->name.' category has been created!');
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
        $data = [];
        $data['category'] = Cat::findOrFail($id);
        return view('admin.category.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CatFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatFormRequest $request, $id)
    {
        $data = $request->all();

        $category = Cat::findOrFail($id);
        $category->update($data);

        return redirect()->route('admin.cat')->with('alert-success', $category->name.' category has been updated!');
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
        return Cat::destroy($items);
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
        return Cat::whereIn('id', $items)->update(['state' => 1]);
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
        return Cat::whereIn('id', $items)->update(['state' => 0]);
    }
}
