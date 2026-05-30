<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewCommand extends Command
{
    /**
     * Examples:
     *
     * php artisan view create blog.index
     * php artisan view create blogs --resource
     * php artisan view create blogs --r
     * php artisan view delete blog.index
     */
    protected $signature = '
        view
        {action : create|delete}
        {view : View name using dot notation}

        {--layout=app : Layout name}
        {--force : Force overwrite/delete}
        {--empty : Create empty blade file}

        {--resource : Create resource views}
        {--r : Shortcut for --resource}
    ';

    protected $description = 'Create or delete Blade view files';

    /**
     * Resource views
     */
    protected array $resourceViews = [
        'index',
        'create',
        'edit',
        'show',
    ];

    public function handle(): int
    {
        $action = strtolower($this->argument('action'));

        return match ($action) {
            'create' => $this->handleCreate(),
            'delete' => $this->deleteView(),
            default => $this->invalidAction(),
        };
    }

    /**
     * Handle create action
     */
    protected function handleCreate(): int
    {
        if ($this->option('resource') || $this->option('r')) {
            return $this->createResourceViews();
        }

        return $this->createSingleView(
            $this->argument('view')
        );
    }

    /**
     * Create resource views
     */
    protected function createResourceViews(): int
    {
        $base = $this->argument('view');

        foreach ($this->resourceViews as $view) {

            $fullView = "{$base}.{$view}";

            $this->createSingleView($fullView);
        }

        $this->newLine();

        $this->info('Resource views created successfully');

        return self::SUCCESS;
    }

    /**
     * Create single view
     */
    protected function createSingleView(string $view): int
    {
        $path = $this->getViewPath($view);

        File::ensureDirectoryExists(dirname($path));

        if (File::exists($path) && !$this->option('force')) {

            $this->warn("Skipped (already exists):");
            $this->line($path);

            return self::FAILURE;
        }

        File::put(
            $path,
            $this->buildViewContent($view)
        );

        $this->info("Created:");
        $this->line($path);

        return self::SUCCESS;
    }

    /**
     * Delete view
     */
    protected function deleteView(): int
    {
        $view = $this->argument('view');

        $path = $this->getViewPath($view);

        if (!File::exists($path)) {

            $this->error("View does not exist:");
            $this->line($path);

            return self::FAILURE;
        }

        if (!$this->option('force')) {

            $confirm = $this->confirm(
                "Delete this view?\n{$path}"
            );

            if (!$confirm) {

                $this->warn('Delete cancelled');

                return self::FAILURE;
            }
        }

        File::delete($path);

        $this->info("Deleted:");
        $this->line($path);

        $this->deleteEmptyDirectories(dirname($path));

        return self::SUCCESS;
    }

    /**
     * Build blade content
     */
    protected function buildViewContent(string $view): string
    {
        if ($this->option('empty')) {
            return '';
        }

        $layout = $this->option('layout');

        $title = ucfirst(
            basename(str_replace('.', '/', $view))
        );

        return <<<BLADE
@extends('layouts.{$layout}')

@section('content')

<div class="container">

    <h1>{$title} Page</h1>

</div>

@endsection

BLADE;
    }

    /**
     * Convert dot notation to path
     */
    protected function getViewPath(string $view): string
    {
        $view = str_replace('.', '/', $view);

        return resource_path(
            "views/{$view}.blade.php"
        );
    }

    /**
     * Delete empty directories recursively
     */
    protected function deleteEmptyDirectories(string $dir): void
    {
        $viewsPath = resource_path('views');

        while (
            $dir !== $viewsPath &&
            is_dir($dir) &&
            count(scandir($dir)) === 2
        ) {
            rmdir($dir);

            $this->warn("Removed empty directory:");
            $this->line($dir);

            $dir = dirname($dir);
        }
    }

    /**
     * Invalid action
     */
    protected function invalidAction(): int
    {
        $this->error('Invalid action');

        $this->line('Available actions:');
        $this->line('- create');
        $this->line('- delete');

        return self::FAILURE;
    }
}
