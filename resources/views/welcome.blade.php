<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Automotriz Carmona - API & CMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-stone-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-stone-100 overflow-hidden">
        
        <!-- Header SEC -->
        <div class="bg-[#d2001c] p-8 pb-10 flex justify-center flex-col items-center relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <img src="{{ env('NEXT_PUBLIC_SITE_URL', 'https://automotrizcarmona.cl') }}/images/logo-carmona.avif" alt="Automotriz Carmona" class="h-10 relative z-10 brightness-0 invert drop-shadow-md mb-2 object-contain" />
            <h1 class="text-white/90 font-bold text-sm tracking-[0.2em] uppercase relative z-10 text-center">Plataforma Administrativa</h1>
        </div>

        <!-- Content SEC -->
        <div class="p-8 pb-10 flex flex-col gap-4 -mt-4 relative bg-white rounded-t-3xl border-t border-white/50">
            <p class="text-stone-500 text-center text-sm mb-4 leading-relaxed">
                Bienvenido al panel web de gestión de contenidos y leads para el ecosistema digital de Carmona.
            </p>

            <a href="{{ url('/admin') }}" class="group relative flex w-full justify-between items-center gap-4 bg-[#d2001c] hover:bg-[#aa0015] active:scale-[0.98] transition-all px-6 py-4 rounded-xl shadow-lg shadow-red-600/20 text-white font-semibold">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-80 group-hover:opacity-100 transition-opacity"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span>Iniciar Sesión en el Panel</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>

            <a href="{{ env('NEXT_PUBLIC_SITE_URL', 'https://automotrizcarmona.cl') }}" target="_blank" rel="noopener noreferrer" class="group relative flex w-full justify-between items-center gap-4 bg-stone-100 hover:bg-stone-200 active:scale-[0.98] transition-all px-6 py-4 rounded-xl text-stone-800 font-semibold mt-2">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-80 group-hover:opacity-100 transition-opacity"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                    <span>Ir al Sitio Web Principal</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-stone-400 group-hover:text-stone-600 transition-colors"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
            </a>
        </div>
        
        <div class="bg-stone-50 p-4 border-t border-stone-100 text-center text-xs text-stone-400 font-medium">
            &copy; {{ date('Y') }} AUTOMOTRIZ CARMONA ESPINOZA Y CIA LIMITADA.<br>Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
