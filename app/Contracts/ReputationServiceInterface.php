<?php

namespace App\Contracts;

use App\Models\User;

interface ReputationServiceInterface
{
    public function addReputation(User $user, int $points): void;
}