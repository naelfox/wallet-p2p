<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'balance' => $request->user()->wallet->balance,
            'latest_transactions' => $request->user()->transactions()->with([
                'sender:id,name,email',
                'recipient:id,name,email',
            ])->latest()->take(5)->get()
        ], 200);
    }
}
