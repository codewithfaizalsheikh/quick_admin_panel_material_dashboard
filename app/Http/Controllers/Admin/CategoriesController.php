<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;

USE App\EventCategory;
use File;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreCategoryRequest;

class CategoriesController extends Controller
{


    public function index(){
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category = EventCategory::all();

        return view('admin.category.index',compact('category'));
    }

    public function create()
    {
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        return view('admin.category.create');

    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $category = EventCategory::create($request->all());

        
        return redirect()->route('admin.category.index')->with('success','Category Created Successfully!');
    }

    public function edit(Request $request, $id){
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(!$id){
            return redirect()->route('admin.category.index')->with('error',' ID not found!');
        }

        $category = EventCategory::find($id);

        if(!$category){
            return redirect()->route('admin.category.index')->with('error',' ID not found!');
        }

        return view('admin.category.edit',compact('category','id'));

    }
    public function update(Request $request, $id){
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(!$id){
            return redirect()->route('admin.category.index')->with('error','Event ID not found!');
        }
        $category = EventCategory::find($id);
        if(!$category){
            return redirect()->route('admin.category.index')->with('error','Event ID not found!');
        }

        $category->update($request->all());

         return redirect()->route('admin.category.index',compact('category'));
    }

     public function delete(Request $request, $id)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if(!$id){
            return redirect()->route('admin.category.index')->with('error','ID not found!');
        }

        $category = EventCategory::find($id); 
        if(!$category){
            return redirect()->route('admin.category.index')->with('error','ID not found!');
        }
        $category->delete();

        return back();

    }








}
