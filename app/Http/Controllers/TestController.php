<?php

namespace App\Http\Controllers;

use App\Model\Test;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class TestController extends Controller
{
    public function index(Request $request){


        $url = url('/');

//        return $url;
//        return gethostname();
//        return $_SERVER['SERVER_NAME']; //localhost
        //return $_SERVER['REQUEST_URI']; // /project/banner_maker/git_banner_maker_clone/public/test
        //return "http://festivalstudio365.freefestivalpost.com/store_data?d=".$_SERVER['SERVER_NAME']."&u=".$_SERVER['REQUEST_URI'];

        //@file_get_contents("http://festivalstudio365.freefestivalpost.com/store_data?d=".$_SERVER['SERVER_NAME']."&u=".$_SERVER['REQUEST_URI']);


//        return $url = "";

        return "123";
        
        Excel::load('file.xlsx', function($reader) {

            // Getting all results
            $results = $reader->get();
            foreach ($results as $result) {
                $data = $result->toArray();

                Test::create([
                    'author'=> $data['author'],
                    'title'=> $data['title'],
                    'type'=> $data['type'],
                    'publisher'=> $data['publisher'],
                    'version'=> $data['version'],
                    'year'=> $data['year'],
                    'remarks'=> $data['remarks'],
                ]);

            }

            // ->all() is a wrapper for ->get() and will work the same
            $results = $reader->all();

        });
        return "123";
    }
}
