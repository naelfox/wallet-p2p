<?php

namespace App\Services;

use App\Exceptions\Transactions\InsufficientBalanceException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransferService
{

    public function execute(User $sender, string $recipientEmail, int $amount): void
    {
        $recipient = User::where('email', $recipientEmail)->firstOrFail();

        if ($sender->wallet->balance < $amount) {
            throw new InsufficientBalanceException();
        }

        DB::transaction(function () use ($sender, $recipient, $amount): void {

            $this->transferFunds($sender, $recipient, $amount);
            $this->recordTransactionHistory($sender, $recipient, $amount);

        });

    }

    private function transferFunds(User $sender, User $recipient, int $amount): void
    {
        $sender->wallet()->decrement('balance', $amount);
        $recipient->wallet()->increment('balance', $amount);
    }

    private function recordTransactionHistory(User $sender, User $recipient, int $amount): void
    {
        $sender->transactions()->create([
            'recipient_id' => $recipient->id,
            'amount' => $amount,
            'type' => 'debit',
        ]);

        $recipient->transactions()->create([
            'sender_id' => $sender->id,
            'amount' => $amount,
            'type' => 'credit',
        ]);
    }

}