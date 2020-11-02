<?php

namespace App\Http\Controllers;

use App\Category;
use App\Components\Recusive;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $category;
    // Dependency Category vào Method Constructor
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getMenuCategory($parentID)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        return $recusive->categoryRecusive($parentID);
    }

    public function index()
    {
            $categories = $this->category->latest()->paginate(5);
            return view('admin.category.index',compact('categories'));
    }
    public function create()
    {
           $htmlOption = $this->getMenuCategory('');

            return view('admin.category.add',compact('htmlOption'));
    }

    public function store(Request $request)
    {
        $this->category->create([
            'name'=> $request->name,
            'parent_id'=>$request->parent_id,
            'slug'=>Str::slug($request->name,'-')
        ]);
        return redirect(route('categories.index'));
    }

    public function edit($id)
    {
        $category = $this->category->find($id);
        $htmlOption = $this->getMenuCategory($category->parent_id);
        return view('admin.category.edit',compact('category','htmlOption'));
    }
    public function update($id,Request $request)
    {
        $category = $this->category->find($id)->update([
        'name'=> $request->name,
        'parent_id'=>$request->parent_id,
        'slug'=>Str::slug($request->name,'-')
    ]);;

        return redirect(route('categories.index'));
    }

    public function destroy($id)
    {
            $category = $this->category->find($id);
            $this->category->where('parent_id',$category->id)->update([
                'parent_id'=>0
            ]);
            $category->delete();
            return redirect()->route('categories.index');
    }
}

