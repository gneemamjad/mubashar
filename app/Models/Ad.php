<?php

namespace App\Models;

use App\Services\PayPal\PayPalService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS = [
        "DRAFT" => -1,
        "PENDING" => 0,
        "APPROVED" => 1,
        "NOT_APPROVED" => 2
    ];

    const SHOW_AS = [
        1 => 'name',
        2 => 'username'
    ];

    protected $table = 'ad';

    public $timestamps = true;
    protected $fillable = [
        'ad_number',
        'title',
        'type',
        'approved',
        'description',
        'price',
        'discount',
        'active',
        'category_id',
        'status',
        'paid',
        'lat',
        'lng',
        'image',
        'created_at',
        'updated_at',
        'user_id',
        'recive_calls',
        'deleted_at',
        'show_as',
        'currency_id',
        'premium',
        'highlighter',
        'sold',
        'rented',
        'city_id',
        'area_id',
        'added_by',
        'approved_by'
    ];

    protected $casts = [
        'options' => 'array',
        'recive_calls' => 'boolean',
        'paid' => 'boolean'
    ];



    public function scopeInMapSquare($query, $minLat, $maxLat, $minLng, $maxLng)
    {
        return $query->whereBetween('lat', [$minLat, $maxLat])
                     ->whereBetween('lng', [$minLng, $maxLng]);
    }

    function scopeShowcase($query)
    {
        return $query->where('paid',1);
    }

    function scopePremium($query)
    {
        return $query->where('paid',1);
    }

    function scopeActive($query)
    {
        return $query->where('active',1);
    }

    function scopeApproved($query)
    {
        return $query->where('approved',self::STATUS['APPROVED']);
    }

    function scopeNotApproved($query)
    {
        return $query->where('approved',self::STATUS['NOT_APPROVED']);
    }

    function scopePending($query)
    {
        return $query->where('approved',self::STATUS["PENDING"]);
    }


    function getCategoriesTraceRootAttribute()
    {
        $category = Category::find($this->category_id);

        if(!$category){
            return "";
        }
        $categoriesTraceRoot = $category->ancestorsAndSelf()->get()->pluck('id','name')->toArray();
        return $categoriesTraceRoot;
    }

    function getCategoryRootAttribute()
    {
        $category = Category::find($this->category_id);

        if(!$category){
            return null;
        }
        // $categoriesTraceRoot = $category->getRoot();
        
        // // dd($category);
        // return $categoriesTraceRoot;
        $visited = [];

        while ($category->parent_id) {
            // Prevent infinite loop in case of circular reference
            if (in_array($category->id, $visited)) {
                break;
            }
            $visited[] = $category->id;
    
            $nextCategory = Category::find($category->parent_id);
            if (!$nextCategory) {
                break;
            }
    
            $category = $nextCategory;
        }
    
        return $category;
    }

    /**
     * Get the media associated with the ad.
     */
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function adAttributes()
    {
        return $this->hasMany(AdAttribute::class, 'ad_id', 'id');
    }

    /**
     * Get the attributes associated with the ad.
     */
    public function attributes()
    {
        return $this->hasManyThrough(Attribute::class,AdAttribute::class,'ad_id','id','id','attribute_id');
    }

    function owner()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    function addedBy()
    {
        return $this->belongsTo(Admin::class,'added_by','id');
    }

    function approvedBy()
    {
        return $this->belongsTo(Admin::class,'approved_by','id');
    }

    function city()
    {
        return $this->belongsTo(City::class,'city_id','id');
    }

    function area()
    {
        return $this->belongsTo(Area::class,'area_id','id');
    }

    function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    
    public function reels()
    {
        return $this->hasMany(Reel::class);
    }

       /**
     * Get the ads that the user is following.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'ad_id', 'user_id')->withTimestamps();
    }

    public function views(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ad_views')->withTimestamps();
    }

    protected static function booted()
    {
        static::created(function ($ad) {
            $formattedNumber = date('ymd') . str_pad($ad->id, 4, '0', STR_PAD_LEFT);
            $ad->update(['ad_number' => $formattedNumber]);
        });
    }

    // Add this relationship to the Ad model
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'ad_plan')
                    ->withPivot('featured_until', 'is_active')
                    ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(AdImage::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($ad) {
            if ($ad->isDirty('status') && $ad->status === 'rejected') {
                if ($ad->is_paid) {
                    self::handleRefund($ad);
                }
            }
        });
    }


    public function bookedDates()
    {
        return $this->hasMany(AdBooked::class, 'ad_id');
    }

}
