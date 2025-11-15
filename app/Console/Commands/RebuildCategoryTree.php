<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use DB;

class RebuildCategoryTree extends Command
{
    
    protected int $currentLeft = 1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild the nested set tree structure for categories using Baum';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        DB::beginTransaction();
        try {
            // Start from root nodes (those without parent)
            $roots = Category::whereNull('parent_id')->get();

            foreach ($roots as $root) {
                $this->rebuildNode($root, 0);
            }

            DB::commit();
            $this->info('✅ Category tree rebuilt successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Error: ' . $e->getMessage());
        }
    }

    protected function rebuildNode(Category $node, int $depth)
    {
        $left = $this->currentLeft++;
        $children = Category::where('parent_id', $node->id)->get();

        foreach ($children as $child) {
            $this->rebuildNode($child, $depth + 1);
        }

        $right = $this->currentLeft++;

        // Update node values
        $node->lft = $left;
        $node->rgt = $right;
        $node->depth = $depth;
        $node->save();

        $this->line("✔️ Updated {$node->name} (ID: {$node->id}) — lft: $left, rgt: $right, depth: $depth");
    }
}
