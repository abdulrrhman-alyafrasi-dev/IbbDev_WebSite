<?php

namespace App\Services;

use App\Contracts\AnswerServiceInterface;
use App\Contracts\ReputationServiceInterface;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Validation\ValidationException;

class AnswerService implements AnswerServiceInterface
{
    public function __construct(
        private ReputationServiceInterface $reputationService
    ) {}

    public function createAnswer(array $data, int $questionId, int $userId): Answer
    {
        $question = Question::findOrFail($questionId);

        if ($question->user_id === $userId) {
            throw ValidationException::withMessages([
                "body" => "áÇ íãßäß ÇáÅÌÇÈÉ Úáì ÓÄÇáß ÇáÎÇÕ."
            ]);
        }

        return Answer::create([
            "question_id" => $questionId,
            "user_id" => $userId,
            "body" => $data["body"],
        ]);
    }

    public function acceptAnswer(int $answerId, int $userId): bool
    {
        $answer = Answer::with("question")->findOrFail($answerId);
        
        // ÇáÊÍŞŞ ãä ÇáÕáÇÍíÉ íÊã İí Policy æáßä ááÊÃßíÏ İí ÇáÎÏãÉ
        if ($answer->question->user_id !== $userId) {
            return false;
        }

        // ÅáÛÇÁ ÇÚÊãÇÏ Ãí ÅÌÇÈÉ ÓÇÈŞÉ áäİÓ ÇáÓÄÇá
        Answer::where("question_id", $answer->question_id)
            ->where("is_accepted", true)
            ->update(["is_accepted" => false]);

        $answer->is_accepted = true;
        $answer->save();

        // ÅÖÇİÉ 10 äŞÇØ áÕÇÍÈ ÇáÅÌÇÈÉ
        $this->reputationService->addReputation($answer->user, 10);

        return true;
    }
}
