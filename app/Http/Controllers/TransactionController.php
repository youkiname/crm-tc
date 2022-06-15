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
        $collection = $this->applyFilter($collection, $request);
        return new TransactionsResource($collection->get());
    }

    public function getAmount(Request $request) {
        $collection = Transaction::where('amount', '>', 0);
        $collection = $this->applyFilter($collection, $request);
        return response()->json([
            'amount' => $collection->sum('amount'),
        ]);
    }

    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    private function applyFilter($collection, $request) {
        if($request->seller_id) {
            $collection = $collection->where('seller_id', $request->seller_id);
        }
        if($request->customer_id) {
            $collection = $collection->where('customer_id', $request->customer_id);
        }
        if ($request->start_date) {
            $collection = $collection->where('created_at', ">=", $request->start_date);
        }
        if ($request->end_date) {
            $collection = $collection->where('created_at', "<=", $request->end_date);
        }
        if ($request->shopping_center_id) {
            $collection = $collection->where('shopping_center_id', $request->shopping_center_id);
        }
        if ($request->shop_id) {
            $collection = $collection->where('shop_id', $request->shop_id);
        }
        return $collection;
    }
}
