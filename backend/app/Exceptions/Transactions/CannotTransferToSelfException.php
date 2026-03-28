<?php

namespace App\Exceptions\Transactions;

use Exception;

class CannotTransferToSelfException extends Exception
{
    protected $message = 'Não é possível transferir para si mesmo.';

    public function render($request)
    {
        return response()->json(['message' => $this->message], 422);
    }
}
