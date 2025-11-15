<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CategoryCloneService;
use App\Models\Category;

class CloneCategories extends Command
{
    protected $signature = 'categories:clone
        {sourceParentId : Source category id (root of subtree)}
        {targetParentId : Target parent id}
        {--exclude-root : Clone only children of source (exclude the source node itself)}';

    protected $description = 'Clone a category subtree under a new parent (Baum), keeping hierarchy and attribute links.';

    public function handle(CategoryCloneService $service)
    {
        $sourceId     = (int) $this->argument('sourceParentId');
        $targetId     = (int) $this->argument('targetParentId');
        $excludeRoot  = (bool) $this->option('exclude-root');
        $includeRoot  = !$excludeRoot; // our service expects includeSourceNode

        if (!Category::find($sourceId)) {
            $this->error("Source category #{$sourceId} not found.");
            return 1;
        }
        if (!Category::find($targetId)) {
            $this->error("Target parent category #{$targetId} not found.");
            return 1;
        }

        $this->info("Cloning subtree: source=#{$sourceId} -> targetParent=#{$targetId}");
        if ($excludeRoot) {
            $this->info("Mode: EXCLUDE ROOT (children only).");
        } else {
            $this->info("Mode: INCLUDE ROOT.");
        }

        $result = $service->cloneSubtree($sourceId, $targetId, $includeRoot);

        // Minimal logging as requested
        $this->info("Done. Cloned {$result['count_nodes']} nodes.");

        return 0;
    }
}
