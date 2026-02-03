Route::get('/force-migrate', function () {
    try {
        // STEP 1: Force the website to forget old settings
        Illuminate\Support\Facades\Artisan::call('config:clear');
        Illuminate\Support\Facades\Artisan::call('cache:clear');
        
        // STEP 2: Now try to connect to the database
        Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        
        return '<h1>SUCCESS! ✅</h1><p>Database connected and setup complete.</p>';
    } catch (\Exception $e) {
        return '<h1>Still Error:</h1><p>' . $e->getMessage() . '</p>';
    }
});