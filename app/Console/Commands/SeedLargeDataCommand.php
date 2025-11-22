<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\LargeDataSeeder;

class SeedLargeDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-large';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with 1000 records for each table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to seed large data for each table (1000 records each)...');
        
        if ($this->confirm('This will generate a large amount of data and may take some time. Continue?', true)) {
            $start = microtime(true);
            
            $seeder = new LargeDataSeeder();
            $seeder->setCommand($this);
            $seeder->run();
            
            $time = microtime(true) - $start;
            
            $this->info("Large data seeding completed in {$time} seconds!");
        } else {
            $this->info('Operation cancelled.');
        }
        
        return Command::SUCCESS;
    }
} 