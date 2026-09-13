<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منتدى طلاب علوم الحاسوب CS Forum</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Navbar -->
    <nav class="bg-white shadow border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route("home") }}" class="text-xl font-bold text-blue-600">
                        💻 منتدى علوم الحاسوب
                    </a>
                </div>

                <div class="flex items-center space-x-4 space-x-reverse">
                    @auth
                        <span class="text-gray-700 font-medium">مرحباً، {{ auth()->user()->name }} (🏆 {{ auth()->user()->reputation }} نقطة)</span>
                        <form method="POST" action="{{ route("logout") }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold mr-4">تسجيل الخروج</button>
                        </form>
                    @else
                        <a href="{{ route("login") }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium">تسجيل الدخول</a>
                        <a href="{{ route("register") }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">إنشاء حساب</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Content -->
    <main class="py-6">
        @yield("content")
        {{ $slot ?? "" }}
    </main>
</body>
</html>
