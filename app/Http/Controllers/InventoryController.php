<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\Product;
use App\repositories\InventoryRepository;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    /**
     * @var InventoryRepository
     */
    private $inventoryRepository;

    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $inventories = $this->inventoryRepository->getInventoriesByUserWithPaginate($user->id);

        return $this->inventoryRepository->generateResponse('index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $locations = Location::where('user_id', $user->id)->get();
        $products = Product::where('user_id', $user->id)->get();
        $this->inventoryRepository->getPage();
        return $this->inventoryRepository->generateResponse('create', compact('locations' , 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryRequest $request)
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
         Inventory::create($validatedData);
        return $this->inventoryRepository->generateSweetAlertResponse('success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventories=$this->inventoryRepository->findId($id);
        $user = auth()->user();
        $locations = Location::where('user_id', $user->id)->get();
        $products = Product::where('user_id', $user->id)->get();
        $this->inventoryRepository->getPage();
        return $this->inventoryRepository->generateResponse('edit', compact('products' , 'locations' , 'inventories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InventoryRequest $request, $id)
    {
        $validatedData = $request->validated();
        $inventories=$this->inventoryRepository->findId($id);
        $inventories->update($validatedData);
        return $this->inventoryRepository->redirectToRoute('products.index')
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
        $this->inventoryRepository->findId($id);
        $this->inventoryRepository->delete($id);
    }

    public function showDeletedInventories()
    {
        $deletedInventories = $this->inventoryRepository->deletedActions();
        return view('cms.inventories.deleted-inventories', compact('deletedInventories'));
    }

    public function restore($id)
    {
        $this->inventoryRepository->restore($id);
        return $this->inventoryRepository->redirectToRoute('inventories.index');
    }

    public function forceDelete($id)
    {
        $this->inventoryRepository->forceDelete($id);
        return $this->inventoryRepository->redirectToRoute('inventories.index');
    }
}
