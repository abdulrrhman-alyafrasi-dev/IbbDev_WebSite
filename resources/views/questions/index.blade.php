@extends("layouts.app")

@section("content")
<div class="max-w-4xl mx-auto" dir="rtl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">جميع الأسئلة البرمجية</h1>
        @auth
            <a href="{{ route("questions.create") }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + طرح سؤال جديد
            </a>
        @endauth
    </div>

    @if(session("success"))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session("success") }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($questions as $question)
            <div class="bg-white p-6 rounded-lg shadow border-b border-gray-200">
                <h2 class="text-xl font-bold text-blue-600 hover:underline">
                    <a href="{{ route("questions.show", $question->id) }}">{{ $question->title }}</a>
                </h2>
                <p class="text-gray-600 mt-2 line-clamp-2">{{ Str::limit($question->body, 150) }}</p>
                <div class="flex justify-between items-center text-sm text-gray-500 mt-4 pt-4 border-t">
                    <span>👤 كُتب بواسطة: <strong>{{ $question->user->name }}</strong> (🏆 {{ $question->user->reputation }} نقطة)</span>
                    <span>💬 الإجابات: <strong>{{ $question->answers_count }}</strong></span>
                </div>
            </div>
        @empty
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                لا توجد أسئلة مطروحة حتى الآن. كن أول من يطرح سؤالاً!
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $questions->links() }}
    </div>
</div>
@endsection
