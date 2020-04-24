<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($name='', $lastname='', $age=0, Request $req) {
        $language = $req->input('lang');
         $res = '<h1>Hello world '.$name.' '.$lastname.' you are '.$age.' old. your language is '.$language.'</h1>';
         return $res;
    }

}
