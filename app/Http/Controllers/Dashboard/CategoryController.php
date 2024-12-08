<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();
        
        $categories = Category::filter($request->query())->paginate(1);
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $parents  = Category::all();
        return view('dashboard.categories.create',compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::Rules());
        $request->merge([
            'slug' => Str::slug($request->name)
        ]);
        $data  = $request->all();
        Category::create($data);
        return to_route('categories.index')->with('success','Category Created successfully');
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
    public function edit(string $id)
    {

        try{
        $category  =Category::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return to_route('categories.index')->with('danger','Not Found');
        }
        $parents  = Category::all();
        return view('dashboard.categories.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(Category::Rules());
        $updated = Category::findOrFail($id);
        $updated->update($request->all);
        return to_route('categories.index')->with('success','Category updated successsfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = Category::findOrFail($id);
        $deleted->delete();
        return to_route('categories.index')->with('Category Moved To Trashed');
    }


    public function trashed(){
     
        $categories = Category::onlyTrashed()->get();
        return view('dashboard.categories.trashed',compact('categories'));

    }
    public function restore($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return to_route('categories.index');


    }


    public function forceDelete( $category){
        $category = Category::onlyTrashed()->findOrFail($category);
        $category->forceDelete();
        return to_route('categories.index');
    }

    public static function uploadeImage($request){
        if ($request->hasfile('image')){
            $image  = $request->file('image');
            $path = $image->store('uploades',[
                'disk' => 'public'
            ]);
            return $path ;
        }
    }
}
