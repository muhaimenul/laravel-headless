<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
	 * Service Instance
	 * @var $service
	 */

    protected $service;

    /**
	 * Sets a new service instance
	 */
    public function __construct()
	{

	}

    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json($categories, 201);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json($category);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return response()->json(null, 204);
    }
}
