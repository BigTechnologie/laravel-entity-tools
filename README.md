# Laravel Entity Tools

> 🧰 Une bibliothèque Artisan pour générer automatiquement des entités et des CRUD dans Laravel.

---

## ⚙️ Installation

Ajoutez le package via Composer (en utilisant la branche `main`) :

```bash
composer require bigtechnologie/laravel-entity-tools:dev-main

Ensuite, vous pouvez tester que le package est bien installé en listant les commandes Artisan :
php artisan list

Vous devriez voir apparaître les commandes suivantes : make:entity et make:crud

Utilisation :

1️⃣ Créer une entité
php artisan make:entity NomDeLEntité

NomDeLEntité : le nom de votre entité (première lettre en majuscule)

Cette commande va générer :

Le modèle correspondant dans app/Models

La migration associée

Le fichier fillable pour le modèle

2️⃣ Créer un CRUD complet pour une entité
php artisan make:crud NomDeLEntité

NomDeLEntité : l'entité pour laquelle vous souhaitez créer le CRUD

Cette commande va générer :

Un contrôleur CRUD dans app/Http/Controllers

L'ajout automatique du NomDeLEntitéFormRequest.php dans app/Http/Requests pour les contraintes de validation

Les vues Blade (index, create, edit, show) dans resources/views/nom-de-l-entité

L’ajout automatique de la route Route::resource() dans routes/web.php

📂 Structure générée
Après avoir utilisé le package, vous aurez une structure similaire à :

app/
├── Models/
│   └── NomDeLEntité.php
├── Http/
│   ├── Controllers/
│   │   └── NomDeLEntitéController.php
│   └── Requests/
│       └── NomDeLEntitéFormRequest.php
resources/
└── views/
    └── nom-de-l-entité/
        ├── create.blade.php
        ├── edit.blade.php
        ├── index.blade.php
        └── show.blade.php
routes/
└── web.php


⚡ Remarques
Le package nécessite PHP >= 8.1 et Laravel 10, 11 ou 12.

Utilisez toujours la première lettre en majuscule pour vos entités.

Pour un projet partagé ou sur Packagist, utilisez la commande complète :

composer require bigtechnologie/laravel-entity-tools:dev-main


📝 Auteur
Kandia Diallo – dev.technologie2018@gmail.com

🏷️ License
Ce projet est sous licence MIT.

EXEMPLE :

1️⃣ Créer une entité

php artisan make:entity Product

Product : nom de votre entité (première lettre en majuscule)

Cette commande va générer automatiquement :

Le modèle Product.php dans app/Models

La migration associée create_products_table.php dans database/migrations

Le fichier $fillable dans le modèle pour les colonnes générées

Exemple : modèle généré app/Models/Product.php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock'
    ];
}

Exemple : migration générée database/migrations/xxxx_xx_xx_create_products_table.php

Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->integer('stock')->default(0);
    $table->timestamps();
});



2️⃣ Créer un CRUD complet pour une entité

php artisan make:crud Product

Cette commande génère automatiquement :

Le contrôleur ProductController.php dans app/Http/Controllers

ProductFormRequest.php dans app/Http/Requests

Les vues Blade index, create, edit, show dans resources/views/products/

L’ajout automatique de la route Route::resource('products', ProductController::class); dans routes/web.php

Exemple : structure des vues générées

resources/views/products/
├── create.blade.php
├── edit.blade.php
├── index.blade.php
└── show.blade.php

Exemple : route générée dans routes/web.php

Route::resource('products', ProductController::class);

🔍 Structure finale après génération

app/
├── Models/
│   └── NomDeLEntité.php
├── Http/
│   ├── Controllers/
│   │   └── NomDeLEntitéController.php
│   └── Requests/
│       └── NomDeLEntitéFormRequest.php
resources/
└── views/
    └── nom-de-l-entité/
        ├── create.blade.php
        ├── edit.blade.php
        ├── index.blade.php
        └── show.blade.php
routes/
└── web.php





