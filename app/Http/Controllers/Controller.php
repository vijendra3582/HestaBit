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
        $name = [];
        for($i = 1; $i <= 20000; $i++){
            $name['title'][] = "cat".$i;
        }
        
        foreach(array_unique(array_filter($name['title'])) as $value){
            $categories['title'][] = [
                        "name" => $value
                      ];
        }
        
        echo "<hr><pre>";
        print_r($name);
        // die;
        $categories = collect($categories['title']);
        foreach ($categories->chunk(1000) as $categoriesChunk)
        {
            $insertArray = [];
            foreach($categoriesChunk as $item){
                 if($item['name'] == "" || empty(trim($item['name']))){
                     continue;
                 }
                 $insertArray[] = $item;
            }
            DB::table('categories')->insertOrIgnore($insertArray);
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