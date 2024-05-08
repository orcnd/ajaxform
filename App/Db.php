<?php 
namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class Db
{
    /**
     * Init the db
     *
     * @return void
     */
    public static function init():void 
    {
        $capsule = new Capsule;

        $capsule->addConnection(
            [
            'driver' => 'sqlite',
            'database' => 'database.sqlite'
            ]
        );
        $capsule->setAsGlobal();

        //create db file if not exists
        if (!file_exists('database.sqlite')) {
            $file = fopen('database.sqlite', 'w') or die("can't open file");
            fclose($file);
            Capsule::schema()->create(
                'users', function ($table) {
                    $table->increments('id');
                    $table->string('email')->unique();
                    $table->string('password');
                    $table->string('name');
                    $table->timestamps();
                }
            );
        }        
        $capsule->bootEloquent();
    }
}
