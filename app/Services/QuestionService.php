<?php

namespace App\Services;

use App\Contracts\QuestionServiceInterface;
use App\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class QuestionService implements QuestionServiceInterface
{
    public function getAllQuestionsPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Question::with(["user"])->withCount("answers")->latest()->paginate($perPage);
    }

    public function getQuestionById(int $id): Question
    {
        return Question::with(["user", "answers.user"])->findOrFail($id);
    }

    public function createQuestion(array $data, int $userId): Question
    {
        $imagePath = null;
        if (isset($data["image"]) && $data["image"] instanceof \Illuminate\Http\UploadedFile) {
            $imagePath = $data["image"]->store("questions", "public");
        }

        return Question::create([
            "user_id" => $userId,
            "title" => $data["title"],
            "body" => $data["body"],
            "image" => $imagePath,
        ]);
    }
}
