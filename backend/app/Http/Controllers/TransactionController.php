<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionFilterRequest;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct(private TransactionService $transactionService) {}
    public function index(TransactionFilterRequest $request)
    {
        $transactions = $this->transactionService->list(
            $request->user(),
            $request->validated()
        );

        return response()->json($transactions, 200);
    }
}
