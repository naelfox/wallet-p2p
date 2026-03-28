<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Services\TransferService;
use Illuminate\Http\JsonResponse;
use Nette\Utils\Json;

class TransferController extends Controller
{

    public function __construct(private TransferService $transferService) {}

    public function store(TransferRequest $transfer): JsonResponse
    {
        $this->transferService->execute(
            $transfer->user(),
            $transfer->input('recipient_email'),
            $transfer->input('amount')
        );

        return response()->json(['message' => 'Transferência realizada com sucesso.'], 201);
    }
}
