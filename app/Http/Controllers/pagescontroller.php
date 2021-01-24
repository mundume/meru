<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pagescontroller extends Controller
{
public function independent() {
    return view('independent');
}
public function show_route($id) {
    return view('dashboard.routes.show_route');
}
}
