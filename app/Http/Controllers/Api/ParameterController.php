<?php

namespace App\Http\Controllers\Api;

use App\Models\Parameter;
use App\Http\Controllers\Controller;

class ParameterController extends Controller
{
    public function index()
    {
        return Parameter::select('name')->distinct()->get();
    }
}
