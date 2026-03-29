<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = $user->transactions()->with(['sender:id,name,email', 'recipient:id,name,email',])->latest()->take(5)->get();
        
        return response()->json([
            'balance' => $user->wallet->balance,
            'latest_transactions' => TransactionResource::collection($transactions),
        ], 200);
    }
}
