<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seo\SeoBlog;
use App\Helpers\SeoHelper;

class UpdateSeoMetrics extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'seo:update-metrics {--force : Force update all articles}';

    /**
     * The console command description.
     */
    protected $description = 'Update SEO metrics for all articles including reading time, word count, and SEO scores';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        $query = SeoBlog::query();
        
        if (!$force) {
            $query->where(function($q) {
                $q->whereNull('reading_time')
                  ->orWhereNull('seo_score')
                  ->orWhere('seo_score', 0);
            });
        }
        
        $articles = $query->get();
        
        if ($articles->isEmpty()) {
            $this->info('No articles need SEO metrics updates.');
            return;
        }

        $this->info("Updating SEO metrics for {$articles->count()} articles...");
        
        $progressBar = $this->output->createProgressBar($articles->count());
        $progressBar->start();

        $updated = 0;
        
        foreach ($articles as $article) {
            try {
                $updated++;
                
                // Calculate reading time
                $readingTime = SeoHelper::calculateReadingTime($article->content);
                
                // Calculate SEO score
                $seoScore = SeoHelper::calculateSeoScore($article);
                
                // Update meta description if missing
                if (empty($article->meta_description)) {
                    $metaDescription = SeoHelper::generateMetaDescription($article->content, $article->excerpt);
                    $article->meta_description = $metaDescription;
                }
                
                // Update meta title if missing
                if (empty($article->meta_title)) {
                    $article->meta_title = SeoHelper::generateMetaTitle($article->title);
                }
                
                // Update the article
                $article->reading_time = $readingTime;
                $article->seo_score = $seoScore;
                $article->save();
                
                $progressBar->advance();
                
            } catch (\Exception $e) {
                $this->error("Error updating article {$article->id}: " . $e->getMessage());
                continue;
            }
        }
        
        $progressBar->finish();
        $this->newLine();
        $this->info("Successfully updated SEO metrics for {$updated} articles.");
        
        // Show some statistics
        $avgScore = SeoBlog::avg('seo_score');
        $lowScoreCount = SeoBlog::where('seo_score', '<', 60)->count();
        
        $this->table(
            ['Metric', 'Value'],
            [
                ['Average SEO Score', number_format($avgScore, 1)],
                ['Articles with Score < 60', $lowScoreCount],
                ['Total Articles', SeoBlog::count()],
            ]
        );
        
        if ($lowScoreCount > 0) {
            $this->warn("Consider improving {$lowScoreCount} articles with SEO scores below 60.");
        }
    }
}