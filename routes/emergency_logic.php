
// --- EMERGENCY FIX ROUTE (Final Recovery) ---
Route::get('/emergency-fix-db', function () {
    try {
        $results = [];

        // 1. Schema Check & Patch
        $table = 'users';
        $columns = ['role', 'status', 'blocked_by'];
        $db = Illuminate\Support\Facades\DB::connection()->getPdo();
        
        // Use raw SQL for schema check/patch which is usually safer
        foreach ($columns as $col) {
            try {
                // Try adding column, fail silently if exists
                if ($col === 'blocked_by') {
                    $db->exec("ALTER TABLE users ADD COLUMN $col INTEGER DEFAULT NULL");
                } else if ($col === 'role') {
                    $db->exec("ALTER TABLE users ADD COLUMN $col TEXT DEFAULT 'investor'");
                } else {
                    $db->exec("ALTER TABLE users ADD COLUMN $col TEXT DEFAULT 'active'");
                }
                $results[] = "Added column: $col";
            } catch (\Exception $e) {
                // Column likely exists
            }
        }

        // 2. Admin Fix (kwamerahman83@gmail.com)
        $email = 'kwamerahman83@gmail.com';
        $user = App\Models\User::where('email', $email)->first();

        if ($user) {
            $user->role = 'super_admin'; // Force update
            $user->status = 'active';
            $user->save();
            $results[] = "Promoted Admin: $email";
        } else {
            // Create if missing
            $user = new App\Models\User();
            $user->email = $email;
            $user->name = 'Kwame Rahman';
            $user->password = Illuminate\Support\Facades\Hash::make('test1234');
            $user->role = 'super_admin';
            $user->status = 'active';
            $user->save();
            $results[] = "Created Admin: $email";
        }

        // 3. Public Fix (Unlock everyone else)
        // Set anyone with NULL status to 'active'
        $updated = App\Models\User::whereNull('status')->update(['status' => 'active', 'role' => 'investor']);
        $results[] = "Activated $updated users with null status.";

        return "<h1>Database Schema Repaired, Admin Promoted, and All Users Activated.</h1>" .
               "<ul><li>" . implode("</li><li>", $results) . "</li></ul>";

    } catch (\Exception $e) {
        return "<h1>Error</h1><p>" . $e->getMessage() . "</p>";
    }
});
