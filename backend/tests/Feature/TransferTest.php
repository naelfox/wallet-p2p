<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_transfer_money_successfully(): void
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        $sender->wallet()->create(['balance' => 1000]);
        $recipient->wallet()->create(['balance' => 500]);

        Sanctum::actingAs($sender);

        $response = $this->postJson('/api/wallet/transfer', [
            'recipient_email' => $recipient->email,
            'amount' => 200,
        ]);

        $response->assertCreated()
            ->assertJson([
                'message' => 'Transferência realizada com sucesso.',
            ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $sender->id,
            'balance' => 800,
        ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $recipient->id,
            'balance' => 700,
        ]);

        $this->assertDatabaseCount('transactions', 1);
    }

    public function test_user_cannot_transfer_without_sufficient_balance(): void
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        $sender->wallet()->create(['balance' => 100]);
        $recipient->wallet()->create(['balance' => 500]);

        Sanctum::actingAs($sender);

        $response = $this->postJson('/api/wallet/transfer', [
            'recipient_email' => $recipient->email,
            'amount' => 200,
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Saldo insuficiente para realizar esta operação.',
            ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $sender->id,
            'balance' => 100,
        ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $recipient->id,
            'balance' => 500,
        ]);

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_transfer_amount_must_be_greater_than_zero(): void
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        $sender->wallet()->create(['balance' => 1000]);
        $recipient->wallet()->create(['balance' => 500]);

        Sanctum::actingAs($sender);

        $response = $this->postJson('/api/wallet/transfer', [
            'recipient_email' => $recipient->email,
            'amount' => 0,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('amount');
    }

    public function test_user_cannot_transfer_to_non_existing_email(): void
    {
        $sender = User::factory()->create();

        $sender->wallet()->create(['balance' => 1000]);

        Sanctum::actingAs($sender);

        $response = $this->postJson('/api/wallet/transfer', [
            'recipient_email' => 'naoexiste@email.com',
            'amount' => 100,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('recipient_email');
    }

    public function test_transfer_really_creates_debit_and_credit_transactions(): void
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();

        $sender->wallet()->create(['balance' => 1000]);
        $recipient->wallet()->create(['balance' => 500]);

        Sanctum::actingAs($sender);

        $this->postJson('/api/wallet/transfer', [
            'recipient_email' => $recipient->email,
            'amount' => 300,
        ]);

        $this->assertDatabaseHas('transactions', [
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'amount' => 300,
        ]);

        $this->assertDatabaseHas('transactions', [
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'amount' => 300,
        ]);
    }

    public function test_user_cannot_transfer_to_self(): void
    {
        $user = User::factory()->create();

        $user->wallet()->create(['balance' => 1000]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/wallet/transfer', [
            'recipient_email' => $user->email,
            'amount' => 100,
        ]);

        $response->assertUnprocessable()
            ->assertJson([
                'message' => 'Não é possível transferir para si mesmo.',
            ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance' => 1000,
        ]);

        $this->assertDatabaseCount('transactions', 0);
    }
}
