@extends("layouts.app")

@section("content")
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow" dir="rtl">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">طرح سؤال برمجي جديد</h1>

    <form method="POST" action="{{ route("questions.store") }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">عنوان السؤال</label>
            <input type="text" name="title" value="{{ old("title") }}" required class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error("title")
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">تفاصيل المشكلة (10 أحرف على الأقل)</label>
            <textarea name="body" rows="5" required class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old("body") }}</textarea>
            @error("body")
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">صورة الخطأ/الكود (اختياري)</label>
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded p-2">
            @error("image")
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
            نشر السؤال
        </button>
    </form>
</div>
@endsection
