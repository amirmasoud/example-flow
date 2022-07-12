<?php

namespace Domain\Users\Models;

use Domain\Sites\Models\Site;
use Domain\Sites\Models\Stack;
use Domain\Sites\Models\Server;
use Laravel\Sanctum\HasApiTokens;
use Domain\Users\Casts\SettingsCast;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Domain\Users\QueryBuilders\UserQueryBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static withTrashed()
 * @method static verified()
 * @method static unverified()
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'settings',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => SettingsCast::class,
    ];

    public function servers(): HasMany
    {
        return $this->hasMany(Server::class);
    }

    public function stacks(): HasMany
    {
        return $this->hasMany(Stack::class);
    }

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }
}
