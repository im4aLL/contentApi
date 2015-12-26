<?php

namespace App\Http\Controllers;

use App\Models\Admin\Content;
use App\Models\Admin\Menu;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'index page';
    }

    public function pages()
    {
        $slug = Route::getCurrentRoute()->getPath();
        $content = Menu::where('slug', $slug)->first();

        if($content->content_id > 0) {
            $content['data'] = $content->content;
            $content['data']['html'] = json_decode($content->content->content);
        }
        elseif($content->cat_id > 0) {
            $cat_id = $content->category->id;
            $contents = Content::where('cat_id', $cat_id)->get();

            $array = [];
            $counter = 0;
            foreach($contents as $content) {
                $array[$counter] = $content;
                $array[$counter]['html'] = json_decode($content->content);
                $counter++;
            }

            $content['data'] = collect($array)->toArray();
        }

        return $content;
    }
}
