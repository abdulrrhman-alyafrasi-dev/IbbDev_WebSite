<?php

namespace App\Services;

use App\Contracts\ReputationServiceInterface;
use App\Models\User;

class ReputationService implements ReputationServiceInterface
{
    public function addReputation(User $user, int $points): void
    {
        $user->increment("reputation", $points);
    }
}
