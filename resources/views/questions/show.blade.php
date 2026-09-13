@extends("layouts.app")

@section("content")
<div class="max-w-4xl mx-auto" dir="rtl">
    @if(session("success"))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session("success") }}
        </div>
    @endif

    <!-- Question Card -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $question->title }}</h1>
        <div class="text-sm text-gray-500 mb-4 pb-4 border-b">
            طرحه الطالب: <strong>{{ $question->user->name }}</strong> (🏆 {{ $question->user->reputation }} نقطة)
        </div>
        
        <div class="prose max-w-none text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $question->body }}</div>
        
        @if($question->image)
            <div class="mt-6">
                <p class="text-sm font-semibold text-gray-700 mb-2">الصورة المرفقة:</p>
                <img src="{{ Storage::url($question->image) }}" alt="صورة الخطأ" class="max-w-full h-auto rounded border shadow-sm">
            </div>
        @endif
    </div>

    <!-- Answers List -->
    <h2 class="text-xl font-bold mb-4 text-gray-800">الإجابات ({{ $question->answers->count() }})</h2>
    <div class="space-y-4 mb-8">
        @forelse($question->answers as $answer)
            <div class="bg-white p-6 rounded-lg shadow {{ $answer->is_accepted ? "border-2 border-green-500 bg-green-50" : "" }}">
                <div class="flex justify-between items-start">
                    <div class="w-full">
                        <div class="flex items-center mb-2">
                            <strong class="text-gray-800">{{ $answer->user->name }}</strong>
                            @if($answer->is_accepted)
                                <span class="bg-green-600 text-white text-xs font-bold px-2 py-0.5 rounded ml-2">✓ إجابة معتمدة كحل</span>
                            @endif
                        </div>
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $answer->body }}</p>
                    </div>

                    @auth
                        @if(auth()->id() === $question->user_id && !$answer->is_accepted)
                            <form method="POST" action="{{ route("answers.accept", $answer->id) }}" class="mr-4 flex-shrink-0">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm transition">
                                    اعتماد كحل
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <div class="bg-white p-4 rounded shadow text-gray-500 text-center">
                لا توجد إجابات بعد.
            </div>
        @endforelse
    </div>

    <!-- Answer Form -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold mb-4 text-gray-800">إضافة إجابة</h3>
        @auth
            @if(auth()->id() !== $question->user_id)
                <form method="POST" action="{{ route("answers.store", $question->id) }}">
                    @csrf
                    <div>
                        <textarea name="body" rows="4" required placeholder="اكتب إجابتك هنا..." class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old("body") }}</textarea>
                        @error("body")
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                        نشر الإجابة
                    </button>
                </form>
            @else
                <p class="bg-yellow-50 text-yellow-800 border border-yellow-200 p-4 rounded">
                    ⚠️ لا يمكنك الإجابة على سؤالك الخاص بحسب قواعد المنصة.
                </p>
            @endif
        @else
            <p class="text-gray-600">
                يجب عليك <a href="{{ route("login") }}" class="text-blue-600 font-bold hover:underline">تسجيل الدخول</a> لتتمكن من الإجابة.
            </p>
        @endauth
    </div>
</div>
@endsection
