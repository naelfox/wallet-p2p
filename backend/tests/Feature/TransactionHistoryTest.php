<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TransactionHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_paginated_transactions(): void
    {
        $user = User::factory()->create();

        $user->wallet()->create(['balance' => 1000]);

        Transaction::factory()->count(5)->create([
            'sender_id' => $user->id,
        ]);
        Transaction::factory()->count(5)->create([
            'recipient_id' => $user->id,
        ]);


        Sanctum::actingAs($user);

        $response = $this->getJson('/api/transactions');

        $response->assertOk()
            ->assertJsonStructure([
                'data',
                'links',
            ]);
    }

    public function test_user_can_filter_transactions_by_type(): void
    {
        $user = User::factory()->create();

        Transaction::factory()->create([
            'sender_id' => $user->id,
        ]);

        Transaction::factory()->create([
            'recipient_id' => $user->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/transactions?type=credit');

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('credit', $response->json('data.0.type'));
    }
}
