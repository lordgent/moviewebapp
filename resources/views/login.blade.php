<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MovieApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-movie-hero {
            background-image: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.85)), 
                              url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-movie-hero min-h-screen flex items-center justify-center p-4">

    <div class="bg-white/95 backdrop-blur-md w-full max-w-[450px] rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20 transform transition-all duration-500">
        
        <div class="p-8 sm:p-12">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-300 mb-4 transform -rotate-6 transition-transform hover:rotate-0 duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-gray-800 tracking-tight">Welcome Back</h1>
                <p class="text-gray-500 mt-2 font-medium">Get your popcorn ready, the adventure continues.</p>
            </div>

            @if(session('error'))
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-xl mb-6 flex items-center gap-3 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-[0.15em] mb-2 ml-1">Username</label>
                    <div class="relative group">
                        <input type="text" name="username" required placeholder="Your username"
                               class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 outline-none font-medium text-gray-700">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-[0.15em]">Password</label>
                    </div>
                    <div class="relative group">
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full pl-12 pr-4 py-4 bg-gray-50 border border-transparent rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-300 outline-none font-medium text-gray-700">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-200 transition-all duration-300 active:scale-[0.97] shadow-lg shadow-indigo-100">
                        Sign In
                    </button>
                </div>
            </form>

            <div class="mt-10 text-center">
                <p class="text-gray-500 font-medium text-sm">
                    Don't have an account? 
                    <a href="/register" class="text-indigo-600 font-bold hover:underline decoration-2 underline-offset-4 transition-all">
                        Register now
                    </a>
                </p>
            </div>
        </div>
    </div>

    <div class="fixed bottom-6 text-white/40 text-xs font-medium tracking-widest uppercase">
        © {{ date('Y') }} MovieApp Cinematic Experience
    </div>

</body>
</html>