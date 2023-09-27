<?php

namespace App\Console\Commands;

use App\Events\Hello;
use App\Events\NuevoTiempo;
use App\Events\TimeZoneChanged;
use App\Jobs\RealTimeDataUpdateJob;
use Illuminate\Console\Command;

class try1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:try1';

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
        RealTimeDataUpdateJob::dispatch();

    }
}
