<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Overzicht</title>
</head>
<body>
    <h1>Overzicht van de auto's</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Merk</th>
                <th>Model</th>
                <th>Kenteken</th>
                <th>Brandstof</th>
                <th>Actief</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($autos as $auto)
                <tr>
                    <td>{{ $auto->brand }}</td>
                    <td>{{ $auto->model }}</td>
                    <td>{{ $auto->license_plate }}</td>
                    <td>{{ ucfirst($auto->fuel) }}</td>
                    <td>{{ $auto->is_active ? 'Ja' : 'Nee' }}</td>
                    <td>
                        @if ($auto->photo)
                            <img src="{{ asset($auto->photo) }}" alt="Foto van {{ $auto->brand }}" width="100">                        @else
                            Geen foto beschikbaar
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
