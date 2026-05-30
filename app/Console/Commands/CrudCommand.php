<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CrudCommand extends Command
{
    /**
     * Examples:
     *
     * php artisan crud Blog
     * php artisan crud Post
     * php artisan crud Admin/User
     */
    protected $signature = '
        crud
        {name : Model name}

        {--force : Overwrite existing files}
        {--api : Generate api controller}
    ';

    protected $description = 'Generate complete CRUD';

    protected string $model;

    protected string $modelName;

    protected string $modelVariable;

    protected string $tableName;

    protected string $viewPath;

    public function handle(): int
    {
        $this->setup();

        $this->createModel();

        $this->createMigration();

        $this->createController();

        $this->createRequests();

        $this->createViews();

        $this->createRoutes();

        $this->info("\nCRUD generated successfully.");

        return self::SUCCESS;
    }

    /**
     * Setup variables
     */
    protected function setup(): void
    {
        $this->model = str_replace('/', '\\', $this->argument('name'));

        $this->modelName = class_basename($this->model);

        $this->modelVariable = Str::camel($this->modelName);

        $this->tableName = Str::plural(
            Str::snake($this->modelName)
        );

        $this->viewPath = resource_path(
            'views/' . $this->tableName
        );
    }

    /**
     * Create model
     */
    protected function createModel(): void
    {
        $this->call('make:model', [
            'name' => $this->model,
            '--migration' => false,
        ]);
    }

    /**
     * Create migration
     */
    protected function createMigration(): void
    {
        $this->call('make:migration', [
            'name' => 'create_' . $this->tableName . '_table',
            '--create' => $this->tableName,
        ]);
    }

    /**
     * Create controller
     */
    protected function createController(): void
    {
        $controller = $this->modelName . 'Controller';

        $options = [
            'name' => $controller,
            '--resource' => true,
        ];

        if ($this->option('api')) {
            $options['--api'] = true;
        }

        $this->call('make:controller', $options);

        $this->replaceControllerContent($controller);
    }

    /**
     * Replace controller content
     */
    protected function replaceControllerContent(string $controller): void
    {
        $path = app_path(
            "Http/Controllers/{$controller}.php"
        );

        $model = $this->modelName;

        $modelVariable = $this->modelVariable;

        $table = $this->tableName;

        $content = <<<PHP
            <?php

            namespace App\Http\Controllers;

            use App\Models\\{$model};
            use App\Http\Requests\\Store{$model}Request;
            use App\Http\Requests\\Update{$model}Request;

            class {$controller} extends Controller
            {
                public function index()
                {
                    \${$table} = {$model}::latest()->paginate(10);

                    return view('{$table}.index', compact('{$table}'));
                }

                public function create()
                {
                    return view('{$table}.create');
                }

                public function store(Store{$model}Request \$request)
                {
                    {$model}::create(\$request->validated());

                    return redirect()
                        ->route('{$table}.index')
                        ->with('success', '{$model} created successfully');
                }

                public function show({$model} \${$modelVariable})
                {
                    return view('{$table}.show', compact('{$modelVariable}'));
                }

                public function edit({$model} \${$modelVariable})
                {
                    return view('{$table}.edit', compact('{$modelVariable}'));
                }

                public function update(
                    Update{$model}Request \$request,
                    {$model} \${$modelVariable}
                ) {
                    \${$modelVariable}->update(
                        \$request->validated()
                    );

                    return redirect()
                        ->route('{$table}.index')
                        ->with('success', '{$model} updated successfully');
                }

                public function destroy({$model} \${$modelVariable})
                {
                    \${$modelVariable}->delete();

                    return redirect()
                        ->route('{$table}.index')
                        ->with('success', '{$model} deleted successfully');
                }
            }
        PHP;

        File::put($path, $content);

        $this->info("Controller updated");
    }

    /**
     * Create form requests
     */
    protected function createRequests(): void
    {
        $this->call('make:request', [
            'name' => 'Store' . $this->modelName . 'Request',
        ]);

        $this->call('make:request', [
            'name' => 'Update' . $this->modelName . 'Request',
        ]);
    }

    /**
     * Create views
     */
    protected function createViews(): void
    {
        File::ensureDirectoryExists($this->viewPath);

        $views = [
            'index',
            'create',
            'edit',
            'show',
        ];

        foreach ($views as $view) {

            $path = "{$this->viewPath}/{$view}.blade.php";

            File::put(
                $path,
                $this->getViewTemplate($view)
            );

            $this->info("View created: {$view}");
        }
    }

    /**
     * View templates
     */
    protected function getViewTemplate(string $view): string
    {
        $title = ucfirst($view);

        return <<<BLADE
            @extends('layouts.app')

            @section('content')

            <div class="container">

                <h1>{$title} {$this->modelName}</h1>

            </div>

            @endsection
           BLADE;
    }

    /**
     * Append routes
     */
    protected function createRoutes(): void
    {
        $routeFile = base_path('routes/web.php');

        $controller = $this->modelName . 'Controller';

        $route = "\nRoute::resource('{$this->tableName}', {$controller}::class);\n";

        File::append($routeFile, $route);

        $this->info("Route added");
    }
}
