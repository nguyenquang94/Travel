<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MstPlaceCategory;
use App\Models\Media;

class MstPlaceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("backend.place.category.index", ["categories" => MstPlaceCategory::get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.place.category.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new MstPlaceCategory();
        $category->fill($request->all());
        if ($request->has('parent_id') && $request->parent_id != -1)
        {
            $category->parent_id = $request->parent_id;
        }
        if ($request->hasFile('icon'))
        {
            $media = Media::saveFile($request->icon);
            $category->icon_id = $media->id;
        }
        $category->save();
        return redirect("/place/category");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("backend.place.category.add", ['category' => MstPlaceCategory::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = MstPlaceCategory::findOrFail($id);
        $category->fill($request->all());
        if ($request->has('parent_id') && $request->parent_id != -1)
        {
            $category->parent_id = $request->parent_id;
        }
        if ($request->hasFile('icon'))
        {
            $media = Media::saveFile($request->icon);
            $category->icon_id = $media->id;
        }
        $category->save();
        return redirect("/place/category");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
