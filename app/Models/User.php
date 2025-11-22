<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    protected $guard_name = 'web';

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
        'google_id',
        'image',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function can($permission, $arguments = []): bool
    {
        // Nếu user có quyền trực tiếp, trả về true
        if (parent::can($permission, $arguments)) {
            return true;
        }

        // Kiểm tra nếu quyền này có quyền cha nhiều cấp, tránh vòng lặp vô hạn
        $perm = Permission::where('name', $permission)->with('parent')->first();
        $visitedIds = [];
        while ($perm && $perm->parent) {
            if (in_array($perm->id, $visitedIds)) {
                // Nếu đã duyệt qua quyền này rồi thì dừng lại để tránh lặp vô hạn
                break;
            }
            $visitedIds[] = $perm->id;
            $perm = $perm->parent;
            if ($perm && parent::can($perm->name, $arguments)) {
                return true;
            }
        }

        return false;
    }

    public function canAny($permissions, $arguments = []): bool
    {
        foreach ($permissions as $permission) {
            if ($this->can($permission, $arguments)) {
                return true;
            }
        }
        return false;
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'position_users');
    }

    /**
     * Get the cart for the user.
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }


}
