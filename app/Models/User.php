<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleEnum;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property Carbon $email_verified_at
 * @property RoleEnum $role
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $avatar
 * @property bool $is_admin
 */
class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
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
            'password' => 'hashed',
            'role' => RoleEnum::class,
        ];
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn () => 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($this->name),
        );
    }

    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->role === RoleEnum::ADMIN,
        );
    }

    protected function isManager(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->role === RoleEnum::ADMIN || $this->role === RoleEnum::MANAGER,
        );
    }

    protected function isMaintainer(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->role === RoleEnum::ADMIN
                || $this->role === RoleEnum::MANAGER
                || $this->role === RoleEnum::MAINTAINER,
        );
    }

    protected function isStaff(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->role === RoleEnum::ADMIN
                || $this->role === RoleEnum::MANAGER
                || $this->role === RoleEnum::STAFF,
        );
    }

    public function scopeMaintainers($query): void
    {
        $query->where('role', RoleEnum::MAINTAINER);
    }

    public function scopeNotAdmin($query): void
    {
        $query->whereNot('role', RoleEnum::ADMIN);
    }

    public function requestWarranty()
    {
        return $this->hasMany(WarrantyRequest::class, 'comfirmation_id');
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }
}
