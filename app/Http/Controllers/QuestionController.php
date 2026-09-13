<?php

namespace App\Http\Controllers;

use App\Contracts\QuestionServiceInterface;
use App\Http\Requests\StoreQuestionRequest;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(
        private QuestionServiceInterface $questionService
    ) {}

    public function index()
    {
        $questions = $this->questionService->getAllQuestionsPaginated();
        return view("questions.index", compact("questions"));
    }

    public function create()
    {
        return view("questions.create");
    }

    public function store(StoreQuestionRequest $request)
    {
        $this->questionService->createQuestion($request->validated(), auth()->id());
        return redirect()->route("questions.index")->with("success", "تم نشر السؤال بنجاح!");
    }

    public function show(int $id)
    {
        $question = $this->questionService->getQuestionById($id);
        return view("questions.show", compact("question"));
    }
}
