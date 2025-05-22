<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
   

public function index()
{
    $parameters = Parameter::all();
    return view('parameters.index', compact('parameters'));
}

public function create()
{
    return view('parameters.create');
}

public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255', 
        'label' => 'required|string|max:50', 
        'unit' => 'required|string|max:50', 
        'valueType' => 'required|string|max:50',
    ]);

    Parameter::create($data);

    return redirect()->route('parameters.index')->with('success', 'parameter created successfully.');
}

public function edit(Parameter $parameter)
{
    return view('parameters.edit', compact('parameter'));
}

public function update(Request $request, Parameter $parameter)
{
    $data = $request->validate([
        'name' => 'required|string|max:255', 
        'label' => 'required|string|max:50', 
        'unit' => 'required|string|max:50', 
        'valueType' => 'required|string|max:50',
    ]);

    $parameter->update($data);

    return redirect()->route('parameters.index')->with('success', 'parameter updated successfully.');
}

public function destroy(Parameter $parameter)
{
    $parameter->delete();

    return redirect()->route('parameters.index')->with('success', 'parameter deleted successfully.');
}

}