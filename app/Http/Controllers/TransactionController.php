<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Location;
use App\Models\Product;
use App\Models\Transaction;
use App\repositories\TransactionRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $transactions = $this->transactionRepository->getTransactionsByUserWithPaginate($user->id);

        return $this->transactionRepository->generateResponse('index', compact('transactions'));
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
        $this->transactionRepository->getPage();
        return $this->transactionRepository->generateResponse('create', compact('locations' , 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        Transaction::create($validatedData);
        return $this->transactionRepository->generateSweetAlertResponse('success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transactions=$this->transactionRepository->findId($id);
        $user = auth()->user();
        $locations = Location::where('user_id', $user->id)->get();
        $products = Product::where('user_id', $user->id)->get();
        $this->transactionRepository->getPage();
        return $this->transactionRepository->generateResponse('edit', compact('products' , 'locations' , 'transactions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, $id)
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $transactions=$this->transactionRepository->findId($id);
        $transactions->update($validatedData);
        return $this->transactionRepository->redirectToRoute('transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->transactionRepository->findId($id);
        $this->transactionRepository->delete($id);
    }
    public function showDeletedTransactions()
    {
        $deletedTransactions = $this->transactionRepository->deletedActions();
        return view('cms.transactions.deleted-transactions', compact('deletedTransactions'));
    }

    public function restore($id)
    {
        $this->transactionRepository->restore($id);
        return $this->transactionRepository->redirectToRoute('transactions.index');
    }

    public function forceDelete($id)
    {
        $this->transactionRepository->forceDelete($id);
        return $this->transactionRepository->redirectToRoute('transactions.index');
    }
}
