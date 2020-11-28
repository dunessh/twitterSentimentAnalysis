<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    
    public function analyze(){
        $title = 'Sentiment Analysis';
        return view('twitter.analyze')->with('title', $title);
    }


}
