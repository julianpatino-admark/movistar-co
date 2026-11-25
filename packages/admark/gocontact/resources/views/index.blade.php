<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Monitoreo de envíos GoContact</title>
    <style>
        body { font: 14px/1.5 Arial, sans-serif; color: #202124; margin: 2rem; }
        h1 { font-size: 1.5rem; }
        form { display: flex; gap: .75rem; align-items: end; margin: 1rem 0; }
        label { display: grid; gap: .25rem; }
        input, select, button { padding: .5rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; border-bottom: 1px solid #ddd; padding: .6rem; vertical-align: top; }
        .ok { color: #176b35; } .failed { color: #a32121; }
        nav { margin-top: 1rem; }
        @media (max-width: 760px) { body { margin: 1rem; overflow-x: auto; } table { min-width: 900px; } }
    </style>
</head>
<body>
    <h1>Monitoreo de envíos GoContact</h1>
    <table>
        <thead><tr><th>BD de destino</th><th>Leads asignados</th><th>Intentos exitosos</th><th>Intentos fallidos</th></tr></thead>
        <tbody>
            @forelse ($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->database_id }}</td>
                    <td>{{ $assignment->total }}</td>
                    <td>{{ $totals->get($assignment->database_id)->successful ?? 0 }}</td>
                    <td>{{ $totals->get($assignment->database_id)->failed ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No hay asignaciones registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
    <p>Totales históricos desde la activación del reparto, sin aplicar filtros. Los reintentos conservan su BD y no aumentan los leads asignados.</p>
    <form method="get" action="{{ route('gocontact.monitor') }}">
        <label>ID de forms
            <input type="number" min="1" name="form_id" value="{{ request('form_id') }}">
        </label>
        <label>BD de destino
            <input type="text" name="database_id" value="{{ request('database_id') }}">
        </label>
        <label>Resultado
            <select name="status">
                <option value="">Todos</option>
                <option value="failed" @selected(request('status') === 'failed')>Fallidos</option>
                <option value="successful" @selected(request('status') === 'successful')>Exitosos</option>
            </select>
        </label>
        <button type="submit">Filtrar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Fecha</th><th>forms.id</th><th>BD de destino</th><th>lead_id tracking</th><th>ID GoContact</th>
                <th>Estado</th><th>Etapa</th><th>HTTP</th><th>Request ID</th><th>Duración</th><th>Error</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attempts as $attempt)
                <tr>
                    <td>{{ $attempt->created_at }}</td>
                    <td>{{ $attempt->form_id ?? '—' }}</td>
                    <td>{{ $attempt->database_id ?? '—' }}</td>
                    <td>{{ $attempt->tracking_lead_id ?? '—' }}</td>
                    <td>{{ $attempt->gocontact_id ?? '—' }}</td>
                    <td class="{{ $attempt->successful ? 'ok' : 'failed' }}">{{ $attempt->successful ? 'Exitoso' : 'Fallido' }}</td>
                    <td>{{ $attempt->stage }}</td>
                    <td>{{ $attempt->http_status ?? '—' }}</td>
                    <td>{{ $attempt->request_id ?? '—' }}</td>
                    <td>{{ $attempt->duration_ms }} ms</td>
                    <td>{{ $attempt->error ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="11">No hay envíos registrados con esos filtros.</td></tr>
            @endforelse
        </tbody>
    </table>

    <nav>{{ $attempts->links() }}</nav>
</body>
</html>
