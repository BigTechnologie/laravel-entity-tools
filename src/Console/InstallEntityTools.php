<?php

namespace Kandia\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Commande : php artisan entity:install
 * 
 * Copie les commandes MakeEntity et MakeCrud dans app/Console/Commands
 * et ajoute automatiquement la ligne de chargement dans app/Console/Kernel.php
 */
class InstallEntityTools extends Command
{
    /**
     * Nom de la commande Artisan
     */
    protected $signature = 'entity:install';

    /**
     * Description affichée dans la liste des commandes
     */
    protected $description = 'Installe les commandes MakeEntity et MakeCrud dans le projet Laravel.';

    /**
     * Exécution de la commande
     */
    public function handle(): void
    {
        $commandsDir = app_path('Console/Commands');

        // Crée le dossier Commands s’il n’existe pas
        if (!File::exists($commandsDir)) {
            File::makeDirectory($commandsDir, 0755, true);
            $this->info("📁 Dossier app/Console/Commands créé.");
        }

        // Copie des fichiers de commandes
        File::copy(__DIR__ . '/MakeEntity.php', $commandsDir . '/MakeEntity.php');
        File::copy(__DIR__ . '/MakeCrud.php', $commandsDir . '/MakeCrud.php');

        $this->info("✅ Fichiers MakeEntity.php et MakeCrud.php copiés dans app/Console/Commands.");

        // Mise à jour du Kernel
        $kernelPath = app_path('Console/Kernel.php');
        $kernelContent = File::get($kernelPath);

        if (!str_contains($kernelContent, "\$this->load(__DIR__.'/Commands');")) {
            $kernelContent = str_replace(
                'require base_path(\'routes/console.php\');',
                "\$this->load(__DIR__.'/Commands');\n\n        require base_path('routes/console.php');",
                $kernelContent
            );
            File::put($kernelPath, $kernelContent);
            $this->info("🧩 Ligne ajoutée dans Kernel.php : \$this->load(__DIR__.'/Commands');");
        } else {
            $this->info("ℹ️  Kernel.php contient déjà la ligne de chargement des commandes.");
        }

        $this->info("🎉 Installation terminée : les commandes Artisan sont prêtes à l’emploi !");
    }
}
