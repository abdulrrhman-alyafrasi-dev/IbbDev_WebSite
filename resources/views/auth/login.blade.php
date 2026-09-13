<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - منتدى علوم الحاسوب</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="min-h-screen flex flex-col justify-center items-center py-6 sm:py-12">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">تسجيل الدخول للمنتدى</h2>
            
            <form method="POST" action="{{ route("login") }}">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old("email") }}" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    @error("email") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">كلمة المرور</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    @error("password") <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition duration-200">دخول</button>
            </form>
            
            <p class="text-center text-sm text-gray-600 mt-4">
                ليس لديك حساب؟ <a href="{{ route("register") }}" class="text-blue-600 font-bold hover:underline">أنشئ حسابك الآن</a>
            </p>
        </div>
    </div>
</body>
</html>
