<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\MenuFromRequest;
use App\Http\Requests\Admin\UpdateStateRequest;
use App\Models\Admin\Cat;
use App\Models\Admin\Content;
use App\Models\Admin\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::orderBy('order')->get();
        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $data['menus'] = Menu::findAllWithParent();
        $data['contents'] = Content::select('id', 'title')->where('state', 1)->lists('title', 'id')->prepend('Select a content', '')->toArray();
        $data['categories'] = Cat::select('id', 'name')->lists('name', 'id')->prepend('Select a category', '')->toArray();

        return view('admin.menu.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MenuFromRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuFromRequest $request)
    {
        $data = $request->all();
        $data['slug'] = strlen($data['slug']) == 0 ? str_slug($data['name']) : $data['slug'];
        if($data['is_homepage'] == 1) {
            $data['slug'] = '/';
        }
        $data['user_id'] = auth()->user()->id;

        $menu = Menu::create($data);

        return redirect()->route('admin.menu')->with('alert-success', $menu->name.' menu has been created!');
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
        $data['menu'] = Menu::findOrFail($id);
        $data['menus'] = Menu::findAllWithParent();
        $data['contents'] = Content::select('id', 'title')->where('state', 1)->lists('title', 'id')->prepend('Select a content', '')->toArray();
        $data['categories'] = Cat::select('id', 'name')->lists('name', 'id')->prepend('Select a category', '')->toArray();

        return view('admin.menu.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MenuFromRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuFromRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = strlen($data['slug']) == 0 ? str_slug($data['name']) : $data['slug'];
        if($data['is_homepage'] == 1) {
            $data['slug'] = '/';
        }

        $menu = Menu::findOrFail($id);
        $menu->update($data);

        return redirect()->route('admin.menu')->with('alert-success', $menu->name.' menu has been updated!');
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
        $request->session()->flash('alert-success', 'Selected menus has been deleted!');
        return Menu::destroy($items);
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
        $request->session()->flash('alert-success', 'Selected menus has been published!');
        return Menu::whereIn('id', $items)->update(['state' => 1]);
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
        $request->session()->flash('alert-success', 'Selected menus has been unpublished!');
        return Menu::whereIn('id', $items)->update(['state' => 0]);
    }
}
