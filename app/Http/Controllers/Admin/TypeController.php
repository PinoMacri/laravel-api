<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types=Type::all();
        return view ("admin.types.index", compact("types"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type = new Type();
        return view("admin.types.create", compact("type"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $type=new Type();
        $type->fill($data);
        $type->save();
        return redirect()->route("admin.types.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        $types=Type::all();
        $type->pluck("id")->toArray();
        return view ("admin.types.edit", compact("type"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $data = $request->all();
        $type->update($data);
        $type->save();
        return redirect()->route("admin.types.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return redirect()->route("admin.types.index")->with("delete", "Il Tipo $type->label è stato eliminato");
    }
}