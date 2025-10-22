<?php

namespace Kandia;

use Illuminate\Support\ServiceProvider;
use Kandia\Console\InstallEntityTools;
use Kandia\Console\MakeEntity;
use Kandia\Console\MakeCrud;

/**
 * Service Provider du package Laravel Entity Tools
 * 
 * Il enregistre les commandes Artisan disponibles et permet
 * la publication des fichiers dans un projet Laravel.
 */
class EntityToolsServiceProvider extends ServiceProvider
{
    /**
     * Enregistrement des services (optionnel)
     */
    public function register(): void
    {
        // Ici vous pouvez binder des services si nécessaire
    }

    /**
     * Démarrage du package : enregistre les commandes Artisan.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            // Enregistrement des commandes Artisan du package
            $this->commands([
                InstallEntityTools::class,
                MakeEntity::class,
                MakeCrud::class,
            ]);

            // Publication facultative des fichiers dans le projet Laravel
            $this->publishes([
                __DIR__ . '/Console/MakeEntity.php' => app_path('Console/Commands/MakeEntity.php'),
                __DIR__ . '/Console/MakeCrud.php' => app_path('Console/Commands/MakeCrud.php'),
            ], 'entity-tools');
        }
    }
}
