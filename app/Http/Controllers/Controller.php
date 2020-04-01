<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function bulkUpload(){
        $categories = [];
        $title = [];
        
        for($i = 1; $i <= 20000; $i++){
            $name[] = [
                        "name" => "cat".$i
                      ];
        }
        $categories['title'] = $name;
        
        echo "<hr><pre>";
        print_r($categories);
        
        $categories = collect($categories['title']);
        foreach ($categories->chunk(1000) as $categoriesChunk)
        {
            DB::table('categories')->insertOrIgnore(array_filter($categoriesChunk->toArray()));
        }
        
    }
    
    public function htmlList(){
        $array = [
                    "Women" => [
                                 "Clothes",
                                 "Footwear" => [
                                                "Shoes" => [
                                                            "Formal",
                                                            "Casual",
        
                                                            ]
                                                ]
                                ],
                    "Men" => [
                                "Clothes",
                                "Footwear"
                             ],
                    "Kids",
                    "Electronics"
            ];
            
            echo "<hr><pre>";
            print_r($array);
            
            $list = $this->createHtml($array);
            
            echo "<br><hr>";
            echo $list;
    }
    
    private function createHtml($array){
        $html = "<ul>";
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $html .= "<li>" . $key;
                $html .= $this->createHtml($value);
                $html .= "</li>";
            } else {
                $html .= "<li>" . $value . "</li>";
            }
        }
        $html .= "</ul>";
        return $html;
    }
}
