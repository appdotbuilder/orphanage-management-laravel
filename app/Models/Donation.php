<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Donation
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $child_id
 * @property float $amount
 * @property string $type
 * @property string $description
 * @property string|null $notes
 * @property string $status
 * @property string $donation_date
 * @property string|null $received_date
 * @property string|null $receipt_url
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Child|null $child
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Donation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereChildId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereDonationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereReceivedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereReceiptUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation received()
 * @method static \Database\Factories\DonationFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'child_id',
        'amount',
        'type',
        'description',
        'notes',
        'status',
        'donation_date',
        'received_date',
        'receipt_url',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'donation_date' => 'date',
        'received_date' => 'date',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who made this donation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the child this donation is for (if targeted).
     */
    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    /**
     * Scope to get received donations.
     */
    public function scopeReceived($query)
    {
        return $query->whereIn('status', ['diterima', 'digunakan', 'selesai']);
    }

    /**
     * Get donation type display name.
     */
    public function getTypeDisplayAttribute(): string
    {
        return match($this->type) {
            'uang' => 'Uang',
            'barang' => 'Barang',
            'makanan' => 'Makanan',
            'pakaian' => 'Pakaian',
            'pendidikan' => 'Pendidikan',
            'kesehatan' => 'Kesehatan',
            'lainnya' => 'Lainnya',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get status display name.
     */
    public function getStatusDisplayAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'diterima' => 'Diterima',
            'digunakan' => 'Digunakan',
            'selesai' => 'Selesai',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Format amount for display.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}