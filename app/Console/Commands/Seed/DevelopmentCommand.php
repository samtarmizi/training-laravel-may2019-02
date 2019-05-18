<?php

namespace App\Console\Commands\Seed;

use Illuminate\Console\Command;

class DevelopmentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed development data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('db:seed', [
            '--class' => 'DevelopmentSeeder',
        ]);
    }
}
