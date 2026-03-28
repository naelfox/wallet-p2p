<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Services\TransferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class TransferServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_transfer_is_rolled_back_when_transaction_creation_fails(): void
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        $sender->wallet()->create(['balance' => 1000]);
        $recipient->wallet()->create(['balance' => 500]);

        $transferService = app(TransferService::class);

        Transaction::creating(function () {
            throw new \Exception('Erro simulado ao salvar quebrar a transação');
        });

        $this->expectException(\Exception::class);

        try {
            $transferService->execute($sender, $recipient->email, 200);
        } finally {
            $sender->wallet->refresh();
            $recipient->wallet->refresh();

            $this->assertEquals(1000, $sender->wallet->balance);
            $this->assertEquals(500, $recipient->wallet->balance);

            $this->assertDatabaseCount('transactions', 0);
        }
    }
}
