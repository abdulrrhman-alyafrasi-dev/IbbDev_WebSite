<?php

namespace App\Http\Controllers;

use App\Contracts\AnswerServiceInterface;
use App\Http\Requests\StoreAnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnswerController extends Controller
{
    public function __construct(
        private AnswerServiceInterface $answerService
    ) {}

    public function store(StoreAnswerRequest $request, Question $question)
    {
        $this->answerService->createAnswer($request->validated(), $question->id, auth()->id());
        return back()->with("success", "تم إرسال إجابتك بنجاح.");
    }

    public function accept(Answer $answer)
    {
        Gate::authorize("accept", $answer);
        
        $this->answerService->acceptAnswer($answer->id, auth()->id());
        
        return back()->with("success", "تم اعتماد الإجابة كحل للمشكلة.");
    }
}
