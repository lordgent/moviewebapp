<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieApp - Discover Your Cinema</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dropdown:hover .dropdown-menu { display: block; }
        .loader-fade-in { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="bg-[#f8fafc] text-gray-900 min-h-screen">

    <div id="page-loader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/80 backdrop-blur-sm hidden">
        <div class="flex flex-col items-center">
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 border-4 border-indigo-100 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-indigo-600 rounded-full border-t-transparent animate-spin"></div>
            </div>
            <p class="mt-4 text-indigo-600 font-bold tracking-widest animate-pulse uppercase text-xs">
                {{ app()->getLocale() == 'id' ? 'Memuat...' : 'Loading...' }}
            </p>
        </div>
    </div>

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <a href="{{ route('movies.list') }}" class="flex items-center gap-2">
                    <div class="bg-indigo-600 p-1.5 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-800">
                        Movie<span class="text-indigo-600">App</span>
                    </span>
                </a>

                <div class="flex items-center gap-2">
                    <div class="relative dropdown group mr-2">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-xl bg-gray-50 hover:bg-gray-100 transition-all duration-200">
                            <span class="text-xs font-bold text-indigo-600 uppercase">{{ app()->getLocale() }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="dropdown-menu absolute right-0 top-[100%] w-32 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 hidden">
                            <a href="{{ url('lang/id') }}" class="lang-link block px-4 py-2 text-sm text-gray-600 hover:bg-indigo-50 {{ app()->getLocale() == 'id' ? 'font-bold text-indigo-600' : '' }}">🇮🇩 Indonesia</a>
                            <a href="{{ url('lang/en') }}" class="lang-link block px-4 py-2 text-sm text-gray-600 hover:bg-indigo-50 {{ app()->getLocale() == 'en' ? 'font-bold text-indigo-600' : '' }}">🇺🇸 English</a>
                        </div>
                    </div>

                    @if(session('user'))
                        <div class="relative dropdown group h-16 flex items-center">
                            <button class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 transition-all duration-200">
                                <div class="text-right hidden sm:block">
                                    <p class="text-sm font-semibold text-gray-700 leading-none">{{ session('user') }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Member</p>
                                </div>
                                <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 border-2 border-white shadow-sm flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr(session('user'), 0, 1)) }}
                                </div>
                            </button>

                            <div class="dropdown-menu absolute right-0 top-[100%] w-48 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 hidden">
                                <div class="px-4 py-2 border-b border-gray-50 mb-1">
                                    <p class="text-xs text-gray-400">{{ trans('messages.account') ?? 'Account' }}</p>
                                </div>
                                <a href="{{ route('favorite.list') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    {{ trans('messages.favorites') ?? 'Favorites' }}
                                </a>
                                <hr class="my-1 border-gray-50">
                                <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ trans('messages.logout') ?? 'Logout' }}
                                </a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-md">
                            Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 py-8 mt-20">
        <div class="text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} MovieApp
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            // CSRF Token Global Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Smooth Language Switch Loader
            $('.lang-link').on('click', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $('#page-loader').removeClass('hidden').addClass('flex loader-fade-in');
                setTimeout(function() {
                    window.location.href = url;
                }, 800); // 3000ms is too long for UX, 800ms is perfect
            });
        });
    </script>
</body>
</html>