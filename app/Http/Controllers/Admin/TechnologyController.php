<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $technologies=Technology::all();
        return view ("admin.technologies.index", compact("technologies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technology = new Technology();
        return view("admin.technologies.create", compact("technology"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $technology=new Technology();
        $technology->fill($data);
        $technology->save();
        return redirect()->route("admin.technologies.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Technology $technology)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technology $technology)
    {
        $technologies=Technology::all();
        $technology->pluck("id")->toArray();
        return view ("admin.technologies.edit", compact("technology"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technology $technology)
    {
        $data = $request->all();
        $technology->update($data);
        $technology->save();
        return redirect()->route("admin.technologies.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();
        return redirect()->route("admin.technologies.index")->with("delete", "Il Tipo $technology->label è stato eliminato");
    }
}