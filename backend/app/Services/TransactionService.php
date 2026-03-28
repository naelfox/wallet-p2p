<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionService
{
    public function list(User $user, array $filters = []): LengthAwarePaginator
    {
        $query = Transaction::query()
            ->with('recipient:id,name,email');

        $this->applyTypeFilter($query, $user, $filters['type'] ?? null);
        $this->applyDateFilters($query, $filters);

        return $query
            ->latest()
            ->paginate($filters['per_page'] ?? 10);
    }

    private function applyTypeFilter($query, User $user, ?string $type): mixed
    {
        return $query->where(function ($q) use ($user, $type) {
            if ($type !== 'credit') {
                $q->orWhere(function ($sub) use ($user) {
                    $sub->where('sender_id', $user->id)
                        ->where('type', 'debit');
                });
            }

            if ($type !== 'debit') {
                $q->orWhere(function ($sub) use ($user) {
                    $sub->where('recipient_id', $user->id)
                        ->where('type', 'credit');
                });
            }
        });
    }

    private function applyDateFilters($query, array $filters): void
    {
        $query->when(
            !empty($filters['start_date']),
            fn($q) => $q->whereDate('created_at', '>=', $filters['start_date'])
        );

        $query->when(
            !empty($filters['end_date']),
            fn($q) => $q->whereDate('created_at', '<=', $filters['end_date'])
        );
    }
}
