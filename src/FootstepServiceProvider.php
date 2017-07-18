<?php

namespace Albofish\Footstep;

use Albofish\Footstep\Facades\FootstepFacade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class FootstepServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishConfig();
        $this->publishMigration();
    }

    /**
     * Publish Footstep configuration
     */
    protected function publishConfig()
    {
        // Publish config files
        $this->publishes([
            realpath(__DIR__.'/config/footstep.php') => config_path('footstep.php'),
        ]);
    }

    /**
     * Publish Footstep migration
     */
    protected function publishMigration()
    {
        $published_migration = glob( database_path( '/migrations/*_create_footstep_table.php' ) );
        if( count( $published_migration ) === 0 ) {
            $this->publishes([
                __DIR__ . '/database/migrations/migrations.stub' => database_path('/migrations/' . date('Y_m_d_His') . '_create_footstep_table.php'),
            ], 'migrations');
        }
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        // Bring in configuration values
        $this->mergeConfigFrom(
            __DIR__ . '/config/footstep.php', 'footstep'
        );

        $this->app->singleton(Footstep::class, function () {
            return new Footstep();
        });

        // Define alias 'Footstep'
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();

            $loader->alias('Footstep', FootstepFacade::class);
        });
    }
}
