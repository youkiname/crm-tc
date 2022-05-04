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
        $collection = Transaction::where('amount', '>', 0);
        if($request->seller_id) {
            $collection->where('seller_id', $request->seller_id);
        }
        if($request->customer_id) {
            $collection->where('customer_id', $request->customer_id);
        }
        if($request->shop_id) {
            $collection->where('shop_id', $request->shop_id);
        }
        return new TransactionsResource($collection->paginate(15));
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
