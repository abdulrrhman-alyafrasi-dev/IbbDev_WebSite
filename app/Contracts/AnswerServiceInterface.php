<?php

namespace App\Contracts;

use App\Models\Answer;

interface AnswerServiceInterface
{
    public function createAnswer(array $data, int $questionId, int $userId): Answer;
    
    public function acceptAnswer(int $answerId, int $userId): bool;
}