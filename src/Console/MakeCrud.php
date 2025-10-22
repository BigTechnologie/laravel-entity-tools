<?php

namespace Kandia\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeCrud extends Command
{
    // Nom de la commande Artisan
    protected $signature = 'make:crud {name : Nom de l\'entité}';

    // Description de la commande
    protected $description = 'Créer un CRUD complet pour une entité, avec contrôleur, modèle, migration, vues et FormRequest';

    public function handle()
    {
        $name = Str::studly($this->argument('name')); // Nom de l'entité en PascalCase

        $this->createModel($name);
        $this->createMigration($name);
        $this->createController($name);
        $this->createViews($name);

        $this->info("CRUD pour l'entité {$name} créé avec succès !");
    }

    protected function createModel($name)
    {
        $modelPath = app_path("Models/{$name}.php");

        if (!file_exists($modelPath)) {
            $content = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass {$name} extends Model\n{\n    protected \$fillable = [];\n}\n";
            file_put_contents($modelPath, $content);
        }
    }

    protected function createMigration($name)
    {
        $tableName = Str::snake(Str::pluralStudly($name));
        $migrationName = date('Y_m_d_His') . "_create_{$tableName}_table.php";
        $migrationPath = database_path("migrations/{$migrationName}");

        $content = "<?php\n\nuse Illuminate\Database\Migrations\Migration;\nuse Illuminate\Database\Schema\Blueprint;\nuse Illuminate\Support\Facades\Schema;\n\nreturn new class extends Migration {\n    public function up() {\n        Schema::create('{$tableName}', function (Blueprint \$table) {\n            \$table->id();\n            \$table->timestamps();\n        });\n    }\n\n    public function down() {\n        Schema::dropIfExists('{$tableName}');\n    }\n};\n";

        file_put_contents($migrationPath, $content);
    }

    protected function createController($name)
    {
        $controllerPath = app_path("Http/Controllers/{$name}Controller.php");
        $formRequestPath = app_path("Http/Requests/{$name}FormRequest.php");

        // Création du dossier Requests si inexistant
        $requestsDir = app_path("Http/Requests");
        if (!is_dir($requestsDir)) {
            mkdir($requestsDir, 0755, true);
        }

        // Création du contrôleur si inexistant
        if (!file_exists($controllerPath)) {
            $contentController = "<?php\n\nnamespace App\Http\Controllers;\n\nuse App\Models\\{$name};\nuse App\Http\Requests\\{$name}FormRequest;\nuse Illuminate\Http\Request;\n\nclass {$name}Controller extends Controller\n{\n    // Méthodes CRUD ici\n}\n";
            file_put_contents($controllerPath, $contentController);
        }

        // Création du FormRequest si inexistant
        if (!file_exists($formRequestPath)) {
            $contentRequests = "<?php\n\nnamespace App\Http\Requests;\n\nuse Illuminate\Foundation\Http\FormRequest;\n\nclass {$name}FormRequest extends FormRequest\n{\n    public function authorize() {\n        return true;\n    }\n\n    public function rules() {\n        return [];\n    }\n}\n";
            file_put_contents($formRequestPath, $contentRequests);
        }
    }

    protected function createViews($name)
    {
        $viewsDir = resource_path("views/" . Str::snake(Str::pluralStudly($name)));

        // Création du dossier views si inexistant
        if (!is_dir($viewsDir)) {
            mkdir($viewsDir, 0755, true);
        }

        // Fichiers Blade de base
        $files = ['index.blade.php', 'create.blade.php', 'edit.blade.php', 'show.blade.php'];
        foreach ($files as $file) {
            $filePath = $viewsDir . '/' . $file;
            if (!file_exists($filePath)) {
                file_put_contents($filePath, "<!-- Vue {$file} pour l'entité {$name} -->\n");
            }
        }
    }
}
