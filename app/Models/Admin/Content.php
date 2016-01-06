<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the category of a content.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Admin\Cat', 'cat_id');
    }


    /**
     * Format content array to JSON
     * used for content create
     *
     * @param $collection
     * @return string
     */
    public static function formatContentToJson($collection)
    {
        $array = [];
        $keys = [];
        foreach($collection['key'] as $key) {
            $keys[] = $key;
        }

        $counter = 0;
        foreach($collection['html'] as $html) {
            $key = trim($keys[$counter]) != NULL ? str_replace(' ', '', strtolower($keys[$counter])) : str_random();
            $array[$key] = $html;
            $counter++;
        }

        return collect($array)->toJson();
    }

    /**
     * Get additonal fields content
     * used by self::buildContentArray
     *
     * @param $json
     * @return array
     */
    private static function getAdditionalContent($json)
    {
        $content_array = (array) json_decode($json);
        $array = [];

        $counter = 0;
        foreach($content_array as $key => $value){
            if($counter > 0) {
                $array['key'][] = $key;
                $array['html'][] = $value;
            }

            $counter++;
        }

        return $array;
    }

    /**
     * Get first or main content
     * used by self::buildContentArray
     *
     * @param $json
     * @return array
     */
    private static function getFirstContent($json)
    {
        $content_array = (array) json_decode($json);
        $array = [];
        foreach($content_array as $content_key => $content_text) {
            $array['key'][0] = $content_key;
            $array['html'][0] = $content_text;

            return $array;
        }
    }

    /**
     * Building json content to raw array content same as previously create content array
     * has two dependancy function above getFirstContent and getAdditionalContent
     *
     * @param $content
     * @return array
     */
    public static function buildContentArray($content)
    {
        $additional_fields = (array) json_decode($content->content_types);

        $array = self::getFirstContent($content->content);
        $additional_field_contents = self::getAdditionalContent($content->content);

        if(count($additional_field_contents) > 0)
        {
            $counter = 0;
            for($i = 0; $i < count($additional_fields['field_type']); $i++)
            {
                for($j = 0; $j < $additional_fields['quantity'][$i]; $j++)
                {
                    $temp = $i.'_'.$j;
                    $array['key'][$temp] = $additional_field_contents['key'][$counter];
                    $array['html'][$temp] = $additional_field_contents['html'][$counter];

                    $counter++;
                }
            }
        }

        return $array;
    }
}
