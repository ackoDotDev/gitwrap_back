<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'github_id',
        'avatar',
        'name',
        'username',
        'email',
        'company',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
 * @return HasMany
 */
    public function gitTokens(): HasMany
    {
        return $this->hasMany(GitToken::class);
    }

    /**
     * @return HasMany
     */
    public function userBrowsers(): HasMany
    {
        return $this->hasMany(UserBrowser::class);
    }
}
