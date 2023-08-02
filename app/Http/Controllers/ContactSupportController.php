<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactSupportRequest;
use App\Models\ContactSupport;
use Illuminate\Http\Request;

class ContactSupportController extends Controller
{

    /**
     * @var ContactSupport
     */
    private $contactSupport;

    public function __construct(\App\repositories\ContactSupportRepository $contactSupport)
    {
        $this->contactSupport = $contactSupport;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->contactSupport->getPage();
        return $this->contactSupport->generateResponse('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactSupportRequest $request)
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        ContactSupport::create($validatedData);
        return $this->contactSupport->generateSweetAlertResponse('success');
    }

}
