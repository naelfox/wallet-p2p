<?php

namespace App\Exceptions\Transactions;

use Exception;

class InsufficientBalanceException extends Exception
{
    protected $message = 'Saldo insuficiente para realizar esta operação.';

    public function render($request)
    {
        return response()->json(['message' => $this->message], 422);
    }
}
