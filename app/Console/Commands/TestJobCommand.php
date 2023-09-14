<?php

namespace App\Console\Commands;

use App\Jobs\TestJob;
use App\Models\TestModel;
use Illuminate\Console\Command;

class TestJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creando el post';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $post = new TestModel();
        $post->save();
    }
}
