<?php

namespace App\Console\Commands;

use App\Jobs\TestJob;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mi_comando';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hola Mundo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
            dispatch(new TestJob());
    }
}
