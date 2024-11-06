<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class BoCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        $categories = Category::withTrashed()->get();
        return view('bo.admin.categories.all')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bo.admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);

        Category::create($request->all());

        session()->flash('success', 'Úspešné vytvorenie kategórie');

        return redirect()->route('bo.categories.create');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('bo.admin.categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255']
        ]);
        $category->update($request->all());

        session()->flash('success', 'Úspešné upravenie kategórie');

        return redirect()->route('bo.categories.edit', $category->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->route('bo.categories.all');
    }

    /**
     * Restore the specified resource in storage.
     */
    public function restore($id)
    {
        Category::withTrashed()->find($id)->restore();
        return redirect()->route('bo.categories.all');
    }
}
