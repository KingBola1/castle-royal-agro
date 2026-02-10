
// --- SYSTEM RESCUE ROUTE (Fixes Schema & Restores Admin) ---
Route::get('/fix-system-access', function () {
    try {
        $results = [];

        // 1. Schema Repair
        $pdo = Illuminate\Support\Facades\DB::connection()->getPdo();
        $schemaQueries = [
            "ALTER TABLE users ADD COLUMN role TEXT DEFAULT 'investor'",
            "ALTER TABLE users ADD COLUMN status TEXT DEFAULT 'active'",
            "ALTER TABLE users ADD COLUMN blocked_by INTEGER DEFAULT NULL"
        ];

        foreach ($schemaQueries as $query) {
            try {
                $pdo->exec($query);
            } catch (\Exception $e) {
                // Ignore if column exists
            }
        }
        $results[] = "Schema columns checked/patched.";

        // 2. Admin Restoration (Force kwamerahman83@gmail.com)
        $email = 'kwamerahman83@gmail.com';
        $user = App\Models\User::where('email', $email)->first();

        if (!$user) {
            $user = new App\Models\User();
            $user->email = $email;
            $user->name = 'Kwame Rahman';
            $user->password = Illuminate\Support\Facades\Hash::make('test1234');
            $user->role = 'super_admin';
            $user->status = 'active';
            $user->save();
            $results[] = "Created Super Admin: $email";
        } else {
            $user->role = 'super_admin';
            $user->status = 'active';
            $user->password = Illuminate\Support\Facades\Hash::make('test1234');
            $user->save();
            $results[] = "Updated Super Admin: $email";
        }

        return "<h1>System Rescue Complete</h1>" . 
               "<ul><li>" . implode("</li><li>", $results) . "</li></ul>" .
               "<p>You can now login with <strong>$email</strong> / <strong>test1234</strong></p>";

    } catch (\Exception $e) {
        return "<h1>Error</h1><p>" . $e->getMessage() . "</p>";
    }
});
