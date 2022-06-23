<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionsResource;

use App\Models\Transaction;

use Carbon\Carbon;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $collection = Transaction::where('amount', '>', 0);
        $collection = $this->applyFilter($collection, $request);
        $collection = $this->applyDateFilter($collection, $request->start_date, $request->end_date);
        return new TransactionsResource($collection->get());
    }

    public function getAmountSum(Request $request) {
        $collection = Transaction::where('amount', '>', 0);
        $collection = $this->applyFilter($collection, $request);
        $collection = $this->applyDateFilter($collection, $request->start_date, $request->end_date);
        return response()->json([
            'amount' => $collection->sum('amount'),
        ]);
    }

    public function getAmountSumToday(Request $request) {
        $collection = Transaction::where('created_at', '>=', Carbon::now()->subDays(1));
        $collection = $this->applyFilter($collection, $request);
        return response()->json([
            'amount' => $collection->sum('amount'),
        ]);
    }

    public function getAmountSumMonth(Request $request) {
        $collection = Transaction::where('created_at', '>=', Carbon::now()->subDays(30));
        $collection = $this->applyFilter($collection, $request);
        return response()->json([
            'amount' => $collection->sum('amount'),
        ]);
    }

    public function getAverageSumToday(Request $request) {
        $collection = Transaction::where('created_at', '>=', Carbon::now()->subDays(1));
        $collection = $this->applyFilter($collection, $request);

        $sum = $collection->sum('amount');
        $amount = $collection->count();

        return response()->json([
            'amount' => $sum / $amount,
        ]);
    }

    public function getAverageSumMonth(Request $request) {
        $collection = Transaction::where('created_at', '>=', Carbon::now()->subDays(30));
        $collection = $this->applyFilter($collection, $request);

        $sum = $collection->sum('amount');
        $amount = $collection->count();

        return response()->json([
            'amount' => $sum / $amount,
        ]);
    }

    public function getBonusesIncrementSum(Request $request) {
        $collection = Transaction::where('bonuses_offset', '>', 0);
        $collection = $this->applyFilter($collection, $request);
        $collection = $this->applyDateFilter($collection, $request->start_date, $request->end_date);
        return response()->json([
            'amount' => $collection->sum('bonuses_offset'),
        ]);
    }

    public function getBonusesDecrementSum(Request $request) {
        $collection = Transaction::where('bonuses_offset', '<', 0);
        $collection = $this->applyFilter($collection, $request);
        $collection = $this->applyDateFilter($collection, $request->start_date, $request->end_date);
        return response()->json([
            'amount' => $collection->sum('bonuses_offset'),
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
        if ($request->shopping_center_id) {
            $collection = $collection->where('shopping_center_id', $request->shopping_center_id);
        }
        if ($request->shop_id) {
            $collection = $collection->where('shop_id', $request->shop_id);
        }
        return $collection;
    }

    private function applyDateFilter($collection, $startDate, $endDate) {
        if ($startDate) {
            $collection = $collection->where('created_at', ">=", $startDate);
        }
        if ($endDate) {
            $collection = $collection->where('created_at', "<=", $endDate);
        }
        return $collection;
    }
}
