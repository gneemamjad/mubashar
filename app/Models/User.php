<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'email',
        'verified_at',
        'otp',
        'image',
        'app_version',
        'notification',
        'call',
        'user_name',
        'active',
        'blocked',
        'deleted',
        'currency_id',
        'dial_code',
        'os',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'call' => 'boolean',
        'notification' => 'boolean',
        'blocked' => 'integer',
        'active' => 'integer'
    ];
    const USERTYPE = [
        1 => "مستخدم عادي",
        2 => "مكتب",
        3 => "وكالة"
    ];
    const USERTYPEEN = [
        1 => "Regular",
        2 => "Office",
        3 => "Agent"
    ];

    /**
     * Get the ads that belong to the user.
     */
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    /**
     * Get the ads that the user is following.
     */
    public function following()
    {
        return $this->belongsToMany(Ad::class, 'favorites', 'user_id', 'ad_id');
    }

    /**
     * Get the ads that the user is following.
     */
    public function reviewing()
    {
        return $this->belongsToMany(Ad::class, 'ads_reviews', 'user_id', 'ad_id')->withTimestamps();
    }

    /**
     * Get the ads that the user is following.
     */
    public function ownerReviewing()
    {
        return $this->belongsToMany(Ad::class, 'owners_reviews', 'user_id', 'ad_id')->withTimestamps();
    }

    public function ownerReviews()
    {
        return $this->hasMany(OwnersReview::class, 'owner_id');
    }

    public function getAverageStarsAttribute()
    {
        return $this->ownerReviews()->avg('stars');
    }

    public function followingWithLimit($limit)
    {
        return $this->following()->limit($limit);
    }


    /**
     * Get the ads that the user has viewed.
     */
    public function views()
    {
        return $this->belongsToMany(Ad::class, 'ad_views')->withTimestamps();
    }

    /**
     * Scope a query to only include not deleted users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('deleted', 0);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * Scope a query to only include not blocked users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotBlocker($query)
    {
        return $query->where('blocker', 0);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function curreny()
    {
        return $this->belongsTo(Currency::class,'currency_id','id');
    }
}
