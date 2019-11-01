<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\LookUpController;

class LookUp extends Command  
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index';
                                            
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '数据返回';

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
        (new LookUpController())->index();
    }
}
