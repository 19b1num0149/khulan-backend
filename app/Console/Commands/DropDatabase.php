<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DropDatabase extends Command
{
    protected $signature = 'database:drop {name?}';
    protected $description = 'Drop the specified database';

    public function handle()
    {
        $databaseName = $this->argument('name') ?: config('database.connections.mysql.database');

        if ($this->confirm("Do you really want to drop database '$databaseName'?")) {
            DB::statement("DROP DATABASE IF EXISTS $databaseName");
            $this->info("Database '$databaseName' has been dropped.");
        } else {
            $this->info("Operation cancelled.");
        }
    }
}
