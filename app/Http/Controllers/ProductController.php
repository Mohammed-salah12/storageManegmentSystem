<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $user = auth()->user();

        // Get the selected category ID from the request
        $selectedCategoryId = $request->query('category_id');
        session(['selected_category_id' => $selectedCategoryId]);

        // Get products based on the selected category ID or all products if no category is selected
        $products = $this->productRepository->getProductsByUserWithPaginate($user->id, $selectedCategoryId);

        // Fetch categories that belong to the currently authenticated user
        $categories = Category::where('user_id', $user->id)->get();

        return $this->productRepository->generateResponse('index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // Fetch categories that belong to the currently authenticated user
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)->get();
        $this->productRepository->getPage();
        return $this->productRepository->generateResponse('create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $user = auth()->user();
        // Validate the incoming request data using the ProductRequest
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;

        // Optionally, handle image upload and storage if provided
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = time() . 'image.' . $img->getClientOriginalExtension();
            $img->move('storage/images/products', $imgName);
            $validatedData['image'] = $imgName;
        }

        $product = Product::create($validatedData);
        return $this->productRepository->generateSweetAlertResponse('success');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products=$this->productRepository->findId($id);
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)->get();
        $this->productRepository->getPage();
        return $this->productRepository->generateResponse('edit', compact('products' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $validatedData = $request->validated();
        $product=$this->productRepository->findId($id);
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = time() . 'image.' . $img->getClientOriginalExtension();
            $img->move('storage/images/products', $imgName);
            $validatedData['image'] = $imgName;
        }
        $product->update($validatedData);
        return $this->productRepository->redirectToRoute('products.index')
        ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productRepository->findId($id);
        $this->productRepository->delete($id);

    }

    public function showDeletedProducts()
    {
        // Fetch the soft-deleted categories using the deletedActions method
        $deletedProducts = $this->productRepository->deletedActions();

        // Return the view to display the list of soft-deleted categories
        return view('cms.products.deleted-products', compact('deletedProducts'));
    }

    public function restore($id)
    {
        // Restore the soft-deleted category using the restore method from CategoryRepository
        $this->productRepository->restore($id);

        // Redirect back to the index page after restoring
        return $this->productRepository->redirectToRoute('products.index');
    }

    public function forceDelete($id)
    {
        // Permanently delete the soft-deleted category using the forceDelete method from CategoryRepository
        $this->productRepository->forceDelete($id);

        // Redirect back to the index page after permanently deleting
        return $this->productRepository->redirectToRoute('products.index');
    }
}
