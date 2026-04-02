<!DOCTYPE html>
<html lang="pt-br" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Login - Travel Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-6">

    <div class="w-full max-w-md">
        
        <!-- Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-8">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-semibold text-white tracking-tight">
                    TravelManager
                </h2>
                <p class="text-slate-400 mt-2 text-sm">
                    Acesse sua conta administrativa
                </p>
            </div>

@if ($errors->any())
    <div class="mb-4 p-3 rounded-lg bg-red-500/20 border border-red-500/50 text-red-200 text-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm text-slate-300 mb-1">
                        E-mail
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-white/5 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="seu@email.com"
                        value="admin@jamino.com"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm text-slate-300 mb-1">
                        Senha
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 rounded-lg bg-white/5 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="••••••••"
                        value="password"
                    >
                </div>

                <!-- Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 rounded-lg font-semibold text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:opacity-90 transition transform active:scale-95 shadow-lg"
                >
                    Entrar no Painel
                </button>
            </form>

        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-slate-500 mt-6">
            © 2026 TravelManager
        </p>

    </div>

</body>
</html>