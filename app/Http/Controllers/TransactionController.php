<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionsResource;

use App\Models\Transaction;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $collection = Transaction::paginate(15);
        return new TransactionsResource($collection);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
    }

    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
