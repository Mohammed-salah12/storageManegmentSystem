<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\repositories\LocationRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository){
        $this->locationRepository = $locationRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $locations = $this->locationRepository->getLocationsByUserWithPaginate($user->id);

        return $this->locationRepository->generateResponse('index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->locationRepository->getPage();
        return $this->locationRepository->generateResponse('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $locations = Location::create($validatedData);
        return $this->locationRepository->generateSweetAlertResponse('success');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $locations=$this->locationRepository->findId($id);
        return $this->locationRepository->generateResponse('edit' , compact('locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocationRequest $request, $id)
    {
        $validatedData = $request->validated();
        $product=$this->locationRepository->findId($id);
        $product->update($validatedData);
        return $this->locationRepository->redirectToRoute('products.index')
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
        $this->locationRepository->findId($id);
        $this->locationRepository->delete($id);
    }

    public function showDeletedLocations()
    {
        $deletedLocations = $this->locationRepository->deletedActions();
        return view('cms.locations.deleted-locations', compact('deletedLocations'));
    }

    public function restore($id)
    {
        $this->locationRepository->restore($id);
        return $this->locationRepository->redirectToRoute('locations.index');
    }

    public function forceDelete($id)
    {
        $this->locationRepository->forceDelete($id);
        return $this->locationRepository->redirectToRoute('locations.index');
    }
}
