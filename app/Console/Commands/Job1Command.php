<?php

namespace App\Console\Commands;

use App\Jobs\Job1;
use Illuminate\Console\Command;

class Job1Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:job1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new Job1());
    }
}
