<?php

namespace App\Http\Controllers;

use App\Model\Pages;
use App\Model\Test;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class HomeController extends Controller
{
    public function index(Request $request, $slug){
        $this->data['page'] = Pages::where('slug',$slug)->first();
        if (!empty($this->data['page'])){
            return view('web.page',$this->data);
        }else{
            abort(404);
        }
//        return $page;


    }
}
