<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $user = auth()->user();

        $categories = $this->categoryRepository->getCategoriesByUserWithPaginate($user->id);

        return $this->categoryRepository->generateResponse('index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->categoryRepository->getPage();
        return $this->categoryRepository->generateResponse('create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $user = auth()->user();
        $categories = $request->validated();
        $categories['user_id'] = $user->id;
        Category::create($categories);
        return $this->categoryRepository->generateSweetAlertResponse('success');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories=$this->categoryRepository->findId($id);
        return $this->categoryRepository->generateResponse('edit', compact('categories'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $user = auth()->user();
        $category = $this->categoryRepository->findId($id);
        $validatedData = $request->validated();
        $category->update([
            'name' => $validatedData['name'],
        ]);
        $category->user_id = $user->id;
        $category->save();
        return $this->categoryRepository->redirectToRoute('categories.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories=$this->categoryRepository->findId($id);
        $categories=$this->categoryRepository->delete($id);
    }


    public function showDeletedCategories()
    {
        // Fetch the soft-deleted categories using the deletedActions method
        $deletedCategories = $this->categoryRepository->deletedActions();

        // Return the view to display the list of soft-deleted categories
        return view('cms.categories.deleted-categories', compact('deletedCategories'));
    }

    public function restore($id)
    {
        // Restore the soft-deleted category using the restore method from CategoryRepository
        $this->categoryRepository->restore($id);

        // Redirect back to the index page after restoring
        return $this->categoryRepository->redirectToRoute('categories.index');
    }

    public function forceDelete($id)
    {
        // Permanently delete the soft-deleted category using the forceDelete method from CategoryRepository
        $this->categoryRepository->forceDelete($id);

        // Redirect back to the index page after permanently deleting
        return $this->categoryRepository->redirectToRoute('categories.index');
    }
}
