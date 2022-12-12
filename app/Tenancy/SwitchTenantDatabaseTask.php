<?php

namespace App\Tenancy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Exceptions\InvalidConfiguration;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class SwitchTenantDatabaseTask implements SwitchTenantTask
{
    use UsesMultitenancyConfig;

    public string $tenantConnectionName = '';

    public function makeCurrent(Tenant $tenant): void
    {
        $this->tenantConnectionName = $this->tenantDatabaseConnectionName();

        $this->setTenantDatabaseConnection($tenant);
    }

    public function forgetCurrent(): void
    {
        config([
            "database.connections.{$this->tenantConnectionName}.driver" => null,
            "database.connections.{$this->tenantConnectionName}.database" => null,
        ]);

        app('db')->extend($this->tenantConnectionName, function ($config, $name) {
            $config['driver'] = null;

            $config['database'] = null;

            return app('db.factory')->make($config, $name);
        });
    }

    /**
     * @throws InvalidConfiguration
     */
    protected function setTenantDatabaseConnection(Tenant $tenant)
    {
        if ($this->tenantConnectionName === $this->landlordDatabaseConnectionName()) {
            throw InvalidConfiguration::tenantConnectionIsEmptyOrEqualsToLandlordConnection();
        }

        if (is_null(config("database.connections.{$this->tenantConnectionName}"))) {
            throw InvalidConfiguration::tenantConnectionDoesNotExist($this->tenantConnectionName);
        }

        match ($tenant->database['driver']) {
            'sqlite' => $this->sqliteConnection($tenant->name),
            'mysql' => $this->mySqlConnection($tenant),
            'default' => Log::error("Valid database configuration not found for {$tenant->name}")
        };

        DB::purge($this->tenantConnectionName);

        // Octane will have an old `db` instance in the Model::$resolver.
        Model::setConnectionResolver(app('db'));
    }

    private function sqliteConnection($tenantName)
    {
        config([
            "database.connections.{$this->tenantConnectionName}.driver" => 'sqlite',
            "database.connections.{$this->tenantConnectionName}.database" => database_path($tenantName.'.sqlite'),
            "database.connections.{$this->tenantConnectionName}.prefix" => '',
            "database.connections.{$this->tenantConnectionName}.foreign_key_constraints" => 'true',
        ]);

        app('db')->extend($this->tenantConnectionName, function ($config, $name) use ($tenantName) {
            $config['driver'] = 'sqlite';

            $config['database'] = database_path($tenantName.'.sqlite');

            $config['prefix'] = '';

            $config['foreign_key_constraints'] = true;

            return app('db.factory')->make($config, $name);
        });
    }

    private function mySqlConnection(Tenant $tenant)
    {
        config([
            "database.connections.{$this->tenantConnectionName}.driver" => 'mysql',
            "database.connections.{$this->tenantConnectionName}.database" => $tenant->name,
            "database.connections.{$this->tenantConnectionName}.url" => $tenant->database['url'],
            "database.connections.{$this->tenantConnectionName}.host" => $tenant->database['host'],
            "database.connections.{$this->tenantConnectionName}.port" => $tenant->database['port'],
            "database.connections.{$this->tenantConnectionName}.username" => $tenant->database['username'],
            "database.connections.{$this->tenantConnectionName}.password" => $tenant->database['password'],
            "database.connections.{$this->tenantConnectionName}.unix_socket" => $tenant->database['unix_socket'],
        ]);

        app('db')->extend($this->tenantConnectionName, function ($config, $name) use ($tenant) {
            $config['driver'] = 'mysql';

            $config['database'] = $tenant->database['database'];

            $config['url'] = $tenant->database['url'];

            $config['host'] = $tenant->database['host'];

            $config['port'] = $tenant->database['port'];

            $config['username'] = $tenant->database['username'];

            $config['password'] = $tenant->database['password'];

            $config['unix_socket'] = $tenant->database['unix_socket'];

            return app('db.factory')->make($config, $name);
        });
    }
}
