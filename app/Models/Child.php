<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Child
 *
 * @property int $id
 * @property string $name
 * @property string|null $nickname
 * @property string $birth_date
 * @property string $gender
 * @property string|null $photo_url
 * @property string|null $background_story
 * @property string|null $education_level
 * @property string|null $school_name
 * @property string|null $health_condition
 * @property string|null $special_needs
 * @property string $status
 * @property string $entry_date
 * @property string|null $exit_date
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Donation[] $donations
 * @property-read int $age
 * @property-read int $years_in_orphanage
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Child newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Child newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Child query()
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child wherePhotoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereBackgroundStory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereEducationLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereSchoolName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereHealthCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereSpecialNeeds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereExitDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Child active()
 * @method static \Database\Factories\ChildFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Child extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'children';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'birth_date',
        'gender',
        'photo_url',
        'background_story',
        'education_level',
        'school_name',
        'health_condition',
        'special_needs',
        'status',
        'entry_date',
        'exit_date',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'entry_date' => 'date',
        'exit_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get donations related to this child.
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the child's age.
     */
    public function getAgeAttribute(): int
    {
        if (!$this->birth_date) return 0;
        try {
            $birthDate = Carbon::parse($this->birth_date);
            return (int) $birthDate->diffInYears(now());
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get years in orphanage.
     */
    public function getYearsInOrphanageAttribute(): int
    {
        if (!$this->entry_date) return 0;
        try {
            $entryDate = Carbon::parse($this->entry_date);
            $exitDate = $this->exit_date ? Carbon::parse($this->exit_date) : now();
            return (int) $entryDate->diffInYears($exitDate);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Scope to get only active children.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Get education level display name.
     */
    public function getEducationLevelDisplayAttribute(): string
    {
        return match($this->education_level) {
            'tk' => 'Taman Kanak-kanak',
            'sd' => 'Sekolah Dasar',
            'smp' => 'Sekolah Menengah Pertama',
            'sma' => 'Sekolah Menengah Atas',
            'kuliah' => 'Kuliah',
            'lulus' => 'Lulus',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get status display name.
     */
    public function getStatusDisplayAttribute(): string
    {
        return match($this->status) {
            'aktif' => 'Aktif',
            'alumni' => 'Alumni',
            'pindah' => 'Pindah',
            default => 'Tidak Diketahui'
        };
    }
}