<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles, HasFactory, Notifiable;

    /**
     * Get the investments for the user.
     */
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->latest();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'ghana_card_id',
        'address',
        'next_of_kin_name',
        'next_of_kin_phone',
        'total_invested',
        'active_acres',
        'projected_roi',
        'momo_details',
        'bank_details',
        'google2fa_secret', // Added for 2FA
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret', // Added for 2FA
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            
            // 1. Send Welcome Email to User
            \App\Services\BrevoMailService::send(
                $user->email,
                $user->name,
                '🌱 Welcome to Castle Royal Agro!',
                "
                <div style='font-family: Arial; padding: 20px; border: 1px solid #eee;'>
                    <h2>Welcome, {$user->name}!</h2>
                    <p>Thank you for joining <strong>Castle Royal Agro</strong>. We are excited to have you on board.</p>
                    <p>You can now log in to your dashboard to view investment packages and track your portfolio.</p>
                    <br>
                    <a href='" . route('login') . "' style='background-color: #2d3748; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Login to Dashboard</a>
                </div>"
            );

            // 2. Send New Sign-up Alert to Admin
            \App\Services\BrevoMailService::send(
                env('MAIL_FROM_ADDRESS'), // Send to Admin
                'Castle Royal Admin',
                '🔔 New User Registration',
                "
                <div style='font-family: Arial; padding: 20px; border: 1px solid #eee;'>
                    <h2>New User Alert</h2>
                    <p>A new user has just registered on the platform.</p>
                    <ul>
                        <li><strong>Name:</strong> {$user->name}</li>
                        <li><strong>Email:</strong> {$user->email}</li>
                        <li><strong>Time:</strong> " . now()->format('Y-m-d H:i:s') . "</li>
                    </ul>
                    <a href='" . route('admin.dashboard') . "'>View in Admin Panel</a>
                </div>"
            );
        });
    }
}
