<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $user = $request->user();

        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'type' => $this->sender_id === $user->id ? 'debit' : 'credit',
            'sender' => $this->sender,
            'recipient' => $this->recipient,
            'created_at' => $this->created_at,
        ];
    }
}
