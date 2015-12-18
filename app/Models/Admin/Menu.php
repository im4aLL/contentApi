<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = ['id'];

    /**
     * Get menu with parent menu names
     *
     * @return array
     */
    public static function findAllWithParent()
    {
        $collection = self::select('id', 'parent_id', 'name')->get();
        $menu_array = self::arrangeSublevel($collection->toArray());
        return collect($menu_array)->lists('fulltext', 'id')->toArray();
    }

    /**
     * Helper function of arranging sublevel menus recurssive function
     *
     * @param $menu_parent_id
     * @param $menu_array
     * @return string
     */
    public static function findParent($menu_parent_id, $menu_array){
        $name = '';
        foreach($menu_array as $menu) {
            if($menu['id'] == $menu_parent_id) {
                $name = $menu['name'].' » '.$name;

                if($menu['parent_id'] != 0) {
                    $name = self::findParent($menu['parent_id'], $menu_array).$name;
                }
                break;
            }
        }

        return $name;
    }


    /**
     * Full parent menu text in full text field
     *
     * @param $array
     * @return array
     */
    public static function arrangeSublevel($array)
    {
        $newArray = [];
        foreach($array as $menu){
            $newArray[$menu['id']] = $menu;
            if($menu['parent_id'] != 0) {
                $newArray[$menu['id']]['fulltext'] = self::findParent($menu['parent_id'], $array).$menu['name'];
            }
            else {
                $newArray[$menu['id']]['fulltext'] = $menu['name'];
            }
        }

        return $newArray;
    }
}
