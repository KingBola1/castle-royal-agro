Route::get('/check-config', function () {
    // 1. Force clear the cache
    \Illuminate\Support\Facades\Artisan::call('config:clear');

    // 2. Ask Laravel: "Where are you trying to connect?"
    $host = config('database.connections.pgsql.host');
    $port = config('database.connections.pgsql.port');
    $db   = config('database.connections.pgsql.database');

    // 3. Display the answer
    return "<h1>Detective Result 🕵️</h1>
            <p>I am trying to connect to this Host: <br><strong>$host</strong></p>
            <p>On Port: <strong>$port</strong></p>
            <p>Database Name: <strong>$db</strong></p>";
});