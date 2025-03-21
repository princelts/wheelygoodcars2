<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $brands = Car::distinct()->pluck('brand');
        $models = Car::distinct()->pluck('model');

        return view('home', compact('brands', 'models'));
    }
}
