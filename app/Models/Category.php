<?php

namespace App\Models;

use Baum\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class Category extends Node
{
    use HasTranslations;
    protected $table = 'category';

    public $translatable = ['name'];
    protected $fillable = ['name', 'type', 'have_book'];


    // protected $fillable = ['name'];

    public function parentCat(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the count of ads for this category and its children.
     *
     * @return int
     */
    public function getAdCountAttribute()
    {
        $childrenIds = $this->descendants()->pluck('id');
        $allIds = $childrenIds->push($this->id);

        return Ad::where('status', 1)->where('approved', 1)->where('active', 1)->whereIn('category_id', $allIds)->count();
    }

    public function getFilteredAdCount(Request $request): int
    {
        $childrenIds = $this->descendants()->pluck('id');
        $allIds = $childrenIds->push($this->id);
        $outsideSyria = $request->get('outside_syria');
        if($outsideSyria) {
            $query = Ad::where('status', 3)
                ->whereIn('category_id', $allIds);
        } else {
            $query = Ad::where('status', 1)
                ->where('approved', 1)
                ->where('active', 1)
                ->whereIn('category_id', $allIds);
        }

        if ($request->has('city_id')) {
            $query->where('city_id', $request->input('city_id'));
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        return $query->count();
    }

    public function getDraftAd(Request $request)
    {
        $childrenIds = $this->descendants()->pluck('id');
        $allIds = $childrenIds->push($this->id);
        $ad = Ad::where('status', -1)
                ->whereIn('category_id', $allIds)
                ->where('user_id', Auth::user()->id)
                ->first();
        if(!$ad) {
            return null;
        }
        return $ad->id;
    }

    /**
     * Get all ads belonging to this category and its children.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allAds()
    {
        $childrenIds = $this->descendants()->pluck('id');
        $allIds = $childrenIds->push($this->id);

        return $this->hasMany(Ad::class, 'category_id')->whereIn('category_id', $allIds);
    }

    /**
     * Get the attributes associated with the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'categories_attributes', 'category_id', 'attribute_id');
    }

    /**
     * Get the filter attributes associated with the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function filterAttributes()
    {
        return $this->belongsToMany(Attribute::class, 'categories_attributes', 'category_id', 'attribute_id')
                    ->where('filter_enabled', true);
    }


    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')
                    ->with('children'); 
    }
    
}
