<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ListCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parentId = $this->parent_id ?? null;
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'icon'       => isset($this->icon) ? getIconUrl($this->icon) : null,
            'childs_txt' => $this->children->pluck('name')->implode(','),
            'is_leaf'    => $this->isLeaf(),
            'ad_count'   => $this->getFilteredAdCount($request),
            'draft_ad'   => $this->getDraftAd($request),
            'view_layout'=> $parentId == 2006 ? 'grid' : 'list',
        ];
    }

}
