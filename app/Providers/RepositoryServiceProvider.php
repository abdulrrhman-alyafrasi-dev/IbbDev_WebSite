<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\QuestionServiceInterface;
use App\Services\QuestionService;
use App\Contracts\AnswerServiceInterface;
use App\Services\AnswerService;
use App\Contracts\ReputationServiceInterface;
use App\Services\ReputationService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(QuestionServiceInterface::class, QuestionService::class);
        $this->app->bind(AnswerServiceInterface::class, AnswerService::class);
        $this->app->bind(ReputationServiceInterface::class, ReputationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
