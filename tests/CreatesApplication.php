<?php

namespace Tests;

use App\Models\Fridge;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function initDatabase()
    {
        Artisan::call('migrate');
    }

    protected function resetDatabase()
    {
        Artisan::call('migrate:reset');
    }

    protected function authenticateUser(){
       
        $user = $this->postJson('api/auth/register', [
            'nickname' => 'Antho',
            'email' => 'antho@test.com',
            'password' => 'azertyui'
        ]);
        $data = ["user" => new User($user['user']),"fridge" =>  Fridge::create($user['fridge'])];
        
        return $data;

    }

    protected function loadFixture($file)
    {
        return json_decode(file_get_contents(__DIR__."/Fixture/{$file}.json"), true);
    }


    protected function initDataInDatabase()
    {
        $this->getJson('api/record');
    }
}
