<!DOCTYPE html>
<html>
<head>
    <title>Reservering Afgewezen</title>
</head>
<body>
    <h1>Beste {{ $reservation->name }},</h1>
    <p>Je reservering voor de <strong>{{ $reservation->car->merk }} {{ $reservation->car->model }}</strong> is afgewezen door de beheerder.</p>

    <h3>Details van je reservering:</h3>
    <ul>
        <li><strong>Startdatum:</strong> {{ \Carbon\Carbon::parse($reservation->start_date)->format('d-m-Y') }}</li>
        <li><strong>Einddatum:</strong> {{ \Carbon\Carbon::parse($reservation->end_date)->format('d-m-Y') }}</li>
    </ul>

    <p>Bedankt voor het vertrouwen en een fijne rit gewenst!</p>
</body>
</html>