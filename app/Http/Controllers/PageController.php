<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $data = [
        [
            'name'=> 'fabio',
            'lastname'=> 'diterlizzi'
        ],
        [
            'name'=> 'vanessa',
            'lastname'=> 'de felice'
        ],
        [
            'name'=> 'linda',
            'lastname'=> 'diterlizzi'
        ]
    ];

    public function about()
    {
        return view('about');
    }

    public function blog()
    {
        return view('blog');
    }

    public function staff()
    {
        //passare i dati con l'array (miglior modo) return view('staff', ['title'=>'Our staff', 'staff'=> $this->data]);
        //passare i dati solo con with (si usa per passare un solo dato) return view('staff')->with('staff', $this->data)->with('title','our staff');
        //passare i dati alla view con eloquent: return view('staff')->withStaff($this->data)->withTitle('our staff');

        $staff = $this->data;
        $title ="our staff";
        return view('staffb', compact('title', 'staff'));
    }
}
