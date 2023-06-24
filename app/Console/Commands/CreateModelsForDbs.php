<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateModelsForDbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'models:frominfyom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Models from database tables using infyom';

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
     * @return int
     */
    public function handle () : int
    {
        $calls = [
            'UserKYC' => ['table' => 'user_kyc_documents' , 'prefix' => false] ,

        ];
        foreach($calls as $model => $call) {
            $table = $call['table'];
            $prefix = $call['prefix'];
            $this->createModel($model , $table , $prefix);
        }
        return 0;
    }

    /**
     * @param $model
     * @param $table
     * @param $prefix
     */
    private function createModel ($model , $table , $prefix) : void
    {
        $params = [
            $model ,
            '--fromTable' ,
            "--tableName=$table" ,
            '--skip=routes,migration,controllers,api_controller,scaffold_controller,scaffold_requests,routes,api_routes,scaffold_routes,views,tests,menu,dump-autoload' ,
        ];
        if($prefix) {
            $params = array_merge($params , ["--prefix=" . ucfirst($prefix)]);
        }
        $paramsStr = implode(' ' , $params);
        $command = "infyom:scaffold $paramsStr";
        Artisan::call($command);
    }
}


