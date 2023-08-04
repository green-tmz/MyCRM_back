<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mycrm:make-module {name} {--r=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make module for MyCRM';

    public function artisanCommand($command, $name, $className, $params="")
    {
        $folder = ucfirst($command)."s";

        if ($command == "route") {
            $command = "controller";
        }

        if (!file_exists(dirname(__FILE__, 3) . "/Modules/" . $name . "/$folder/" . $className . ".php")) {
            Artisan::call("make:$command \\\App\\\Modules\\\\$name\\\\$folder\\\\$className $params");
            return $this->info("$command created successfully.");
        } else {
            return $this->info("$command already exists.");
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $params = "";
        if ($this->option("r") != 'false') {
            $params = "-r";
        }

        // print_r($params);

        $name = ucfirst($this->argument('name'));
        $routeName = $name . "Routes";
        $controllerName = $name . "Controller";
        $modelName = $name . "";

        if (file_exists(dirname(__FILE__, 3) . "/Modules/" . $name)) {
            return $this->info('Module already exists.');
        }

        $this->artisanCommand('route', $name, $routeName);
        $this->artisanCommand('controller', $name, $controllerName, $params);
        $this->artisanCommand('model', $name, $modelName);
    }
}
