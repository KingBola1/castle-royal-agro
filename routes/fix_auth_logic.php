
// --- AUTH REPAIR & USER RESTORE ROUTE ---
Route::get('/fix-auth-db', function () {
    try {
        // 1. Fix Schema
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

        // 2. Restore/Update Users
        $usersToFix = [
            [
                'email' => 'kwamerahman83@gmail.com',
                'name' => 'Kwame Rahman',
                'password' => 'test1234', // Will be hashed
                'role' => 'super_admin'
            ],
            [
                'email' => 'johnmtec1@gmail.com',
                'name' => 'Castle Royal Admin',
                'password' => 'Castle2026',
                'role' => 'super_admin'
            ]
        ];

        $results = [];

        foreach ($usersToFix as $userData) {
            $user = App\Models\User::where('email', $userData['email'])->first();
            
            if (!$user) {
                $user = new App\Models\User();
                $user->email = $userData['email'];
                $user->name = $userData['name'];
                $user->password = Illuminate\Support\Facades\Hash::make($userData['password']);
                $user->role = $userData['role']; 
                $user->status = 'active';
                $user->save();
                $results[] = "Created user: {$userData['email']} ({$userData['role']})";
            } else {
                $user->role = $userData['role'];
                $user->status = 'active';
                $user->password = Illuminate\Support\Facades\Hash::make($userData['password']);
                $user->save();
                $results[] = "Updated user: {$userData['email']} ({$userData['role']})";
            }
        }

        return "<h1>Database Repair Complete</h1>" . 
               "<ul><li>" . implode("</li><li>", $results) . "</li></ul>" .
               "<p>You can now login with <strong>kwamerahman83@gmail.com</strong> / <strong>test1234</strong></p>";

    } catch (\Exception $e) {
        return "<h1>Error</h1><p>" . $e->getMessage() . "</p>";
    }
});
