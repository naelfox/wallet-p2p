<?php

namespace App\Exceptions;

class InsufficientBalanceException extends \Exception
{
    protected $message = 'Saldo insuficiente para realizar esta operação.';
}