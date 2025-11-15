<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryCloneService
{
    /**
     * Clone subtree:
     * - If $includeSourceNode=false => clone children of $sourceParentId under $targetParentId (recursively).
     * - Copies: name (translations), icon, have_book.
     * - Copies pivot rows in categories_attributes (prevents duplicates).
     *
     * @return array{count_nodes:int, map:array<int,int>}
     */
    public function cloneSubtree(int $sourceParentId, int $targetParentId, bool $includeSourceNode = false): array
    {
        return DB::transaction(function () use ($sourceParentId, $targetParentId, $includeSourceNode) {
            $targetParent = Category::findOrFail($targetParentId);
            $sourceRoot   = Category::findOrFail($sourceParentId);

            $oldToNew = [];

            if ($includeSourceNode) {
                $newRoot = $this->cloneSingleNode($sourceRoot, $targetParent);
                $oldToNew[$sourceRoot->id] = $newRoot->id;

                $this->cloneAttributesPivot($sourceRoot->id, $newRoot->id);
                $this->cloneChildrenRecursive($sourceRoot, $newRoot, $oldToNew);
            } else {
                // clone only direct children of sourceRoot under targetParent
                $children = $sourceRoot->children()->get();
                foreach ($children as $child) {
                    $newChild = $this->cloneSingleNode($child, $targetParent);
                    $oldToNew[$child->id] = $newChild->id;

                    $this->cloneAttributesPivot($child->id, $newChild->id);
                    $this->cloneChildrenRecursive($child, $newChild, $oldToNew);
                }
            }

            return [
                'count_nodes' => count($oldToNew),
                'map'         => $oldToNew,
            ];
        });
    }

    /**
     * Clone one Category node (without children) under $newParent using Baum.
     * Copies translations of 'name', 'icon', 'have_book'.
     */
    protected function cloneSingleNode(Category $old, Category $newParent): Category
    {
        $new = new Category();

        // Copy translatable name
        if (method_exists($old, 'getTranslations')) {
            $translations = $old->getTranslations('name');
            $new->setTranslations('name', $translations);
        } else {
            $new->name = $old->name;
        }

        // Copy other fields
        $new->icon = $old->icon;
        $new->have_book = $old->have_book;

        // Persist then attach in Baum tree
        $new->save();
        $new->makeChildOf($newParent);

        return $new->fresh();
    }

    /**
     * Recursively clone children keeping hierarchy.
     */
    protected function cloneChildrenRecursive(Category $oldParent, Category $newParent, array &$oldToNew): void
    {
        $children = $oldParent->children()->get();

        foreach ($children as $oldChild) {
            $newChild = $this->cloneSingleNode($oldChild, $newParent);
            $oldToNew[$oldChild->id] = $newChild->id;

            $this->cloneAttributesPivot($oldChild->id, $newChild->id);

            // Recurse
            $this->cloneChildrenRecursive($oldChild, $newChild, $oldToNew);
        }
    }

    /**
     * Clone pivot rows from categories_attributes: (category_id=old) -> (category_id=new)
     * Prevents duplicates for (category_id, attribute_id).
     */
    protected function cloneAttributesPivot(int $oldCategoryId, int $newCategoryId): void
    {
        $rows = DB::table('categories_attributes')
            ->where('category_id', $oldCategoryId)
            ->get();

        if ($rows->isEmpty()) {
            return;
        }

        foreach ($rows as $row) {
            $data = (array) $row;

            // Normalize
            unset($data['id']);
            $data['category_id'] = $newCategoryId;

            // Prevent duplicates (safe if no unique index exists)
            $exists = DB::table('categories_attributes')
                ->where('category_id', $newCategoryId)
                ->where('attribute_id', $row->attribute_id)
                ->exists();

            if ($exists) {
                continue; // skip duplicate
            }

            DB::table('categories_attributes')->insert($data);
        }
    }
}
