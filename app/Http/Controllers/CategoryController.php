<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    private CategoryService $_categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->_categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->_categoryService->retrieveAll();

        return $categories ? response()->json([
            'response_status' => 'success', 'message' => 'categories retrieved successfully', 'data' => ['categories' => $categories]
            ]) : response()->json(['response_status' => 'failure', 'message' => 'categories retrieving failed']);
    }

    public function show(string $categoryId)
    {
        $category = $this->_categoryService->retrieve($categoryId);

        return $category ? response()->json([
            'response_status' => 'success', 'message' => 'category retrieved successfully', 'data' => ['category' => $category]
            ]) : response()->json(['response_status' => 'failure', 'message' => 'category retrieving failed']);
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        $addedCategory = $this->_categoryService->add($data);

        return $addedCategory ? response()->json([
            'response_status' => 'success', 'message' => 'category added successfully', 'data' => ['addedCategory' => $addedCategory]
            ]) : response()->json(['response_status' => 'failure', 'message' => 'category adding failed']);
    }

    public function update(Request $request, string $categoryId)
    {
        $data = $request()->json()->all();

        $updatedCategory = $this->_categoryService->update($categoryId, $data);

        return $updatedCategory ? response()->json([
            'response_status' => 'success', 'message' => 'category updated successfully', 'data' => ['updatedCategory' => $updatedCategory]
            ]) : response()->json(['response_status' => 'failure', 'message' => 'category update failed']);
    }

    public function remove(string $categoryId)
    {
        $removedSuccessfully = $this->_categoryService->remove($categoryId);

        return $removedSuccessfully ? response()->json([
            'response_status' => 'success', 'message' => 'category removed successfully'
            ]) : response()->json(['response_status' => 'failure', 'message' => 'category remove failed']);
    }
}
