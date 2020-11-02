<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Components\MenuRecusive;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class MenuController extends Controller
{
    private $menuRecusive;
    private $menu;
    public function __construct(MenuRecusive $menuRecusive, Menu $menu)
    {
        $this->menuRecusive = $menuRecusive;
        $this->menu = $menu;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
            $menus  = $this->menu->paginate(10);

            return view('admin.menu.index',compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $optionSelect = $this->menuRecusive->menuRecusiveAdd();

        return view('admin.menu.add',compact('optionSelect'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->menu->create([
            'name' => $request->name,
            'parent_id'=>$request->parent_id,
            'slug'=>Str::slug($request->name,'-')
        ]);
        return  redirect()->route('menus.index');
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
        $menu = $this->menu->find($id);
        $optionSelect = $this->menuRecusive->menuRecusiveEdit($menu->parent_id);
        return view('admin.menu.edit',compact('menu','optionSelect'));
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
        $this->menu->find($id)->update([
            'name' => $request->name,
            'parent_id'=>$request->parent_id,
            'slug'=>Str::slug($request->name,'-')
        ]);

        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = $this->menu->find($id);
        $this->menu->where('parent_id',$menu->id)->update([
            'parent_id'=>0
        ]);
        $menu->delete();
        return redirect()->route('menus.index');
    }
}
