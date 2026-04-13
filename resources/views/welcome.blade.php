<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Automotriz Carmona - API & CMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --brand-dark: #111827; 
            --brand-darker: #000000;
            --brand-light: #f9fafb;
            --brand-border: #e5e7eb;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--brand-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            color: #374151;
        }

        .card {
            max-width: 28rem;
            width: 100%;
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--brand-border);
            overflow: hidden;
        }

        .header {
            background-color: var(--brand-dark);
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to bottom right, rgba(255,255,255,0.1), transparent);
        }

        .logo {
            height: 2.5rem;
            position: relative;
            z-index: 10;
            filter: brightness(0) invert(1) drop-shadow(0 4px 6px rgba(0,0,0,0.1));
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 800;
            font-size: 0.875rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            position: relative;
            z-index: 10;
            text-align: center;
        }

        .content {
            padding: 2rem;
            background: #ffffff;
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
            margin-top: -1rem;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .description {
            color: #6b7280;
            text-align: center;
            font-size: 0.875rem;
            line-height: 1.625;
            margin-bottom: 1rem;
        }

        .btn {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background-color: var(--brand-dark);
            color: #ffffff;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);
        }

        .btn-primary:hover {
            background-color: var(--brand-darker);
        }

        .btn-secondary {
            background-color: #f3f4f6;
            color: #1f2937;
            margin-top: 0.5rem;
        }

        .btn-secondary:hover {
            background-color: #e5e7eb;
        }

        .btn-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-primary svg { opacity: 0.8; transition: opacity 0.2s; }
        .btn-primary:hover svg { opacity: 1; }
        .btn-arrow { transition: transform 0.2s; }
        .btn:hover .btn-arrow { transform: translateX(4px); }

        .footer {
            background-color: var(--brand-light);
            padding: 1rem;
            text-align: center;
            font-size: 0.75rem;
            color: #9ca3af;
            font-weight: 500;
            border-top: 1px solid var(--brand-border);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <img src="{{ asset('images/logo-carmona.avif') }}" alt="Automotriz Carmona" class="logo" />
            <h1 class="subtitle">Plataforma Administrativa</h1>
        </div>

        <div class="content">
            <p class="description">
                Bienvenido al panel web de gestión de contenidos y leads para el ecosistema digital de Carmona.
            </p>

            <a href="{{ url('/admin') }}" class="btn btn-primary">
                <div class="btn-content">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <span>Iniciar Sesión en el Panel</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-arrow"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>

            <a href="https://automotrizcarmona.vercel.app/" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                <div class="btn-content">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                    <span>Ir al Sitio Web Principal</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-arrow text-gray-400"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
            </a>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} AUTOMOTRIZ CARMONA ESPINOZA Y CIA LIMITADA.<br>Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
