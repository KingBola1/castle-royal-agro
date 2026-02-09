<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\BrevoMailService;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status', // pending, approved, rejected
        'proof_of_payment',
        'admin_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Deposit $deposit) {
            // Send Alert to Admin
            BrevoMailService::send(
                env('MAIL_FROM_ADDRESS'),
                'Castle Royal Admin',
                '💰 New Deposit Request',
                "
                <div style='font-family: Arial; padding: 20px; border: 1px solid #eee;'>
                    <h2>New Deposit Request</h2>
                    <p>A user has submitted a new deposit request.</p>
                    <ul>
                        <li><strong>User:</strong> {$deposit->user->name}</li>
                        <li><strong>Amount:</strong> GHS " . number_format($deposit->amount, 2) . "</li>
                        <li><strong>Time:</strong> " . now()->format('Y-m-d H:i:s') . "</li>
                    </ul>
                    <a href='" . url('/admin/deposits') . "'>View in Admin Panel</a>
                </div>"
            );
        });
    }
}
