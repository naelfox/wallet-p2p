<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionFilterRequest;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $transactionService) {}

    public function index(TransactionFilterRequest $request)
    {
        $transactions = $this->transactionService->list(
            $request->user(),
            $request->validated()
        );

        return TransactionResource::collection($transactions);
    }
}
