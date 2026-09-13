<?php

namespace App\Contracts;

use App\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;

interface QuestionServiceInterface
{
    public function getAllQuestionsPaginated(int $perPage = 10): LengthAwarePaginator;
    
    public function getQuestionById(int $id): Question;
    
    public function createQuestion(array $data, int $userId): Question;
}