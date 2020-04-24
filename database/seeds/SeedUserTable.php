<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SeedUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        factory(App\User::class, 30)->create();

        /*
        $sql = 'INSERT INTO users (name , email, password)';
        $sql.= 'values(:name, :email, :password)';
        for($i=0; $i<30; $i++) {
            DB::statement($sql, [
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('password')

                ]);
        }*/
//        for($i=0; $i<30; $i++) {
//            DB::table('users')->insert([
//                'name' => 'Fabio'.$i,
//                'email' => 'fabio'.$i.'@gmail.com',
//                'password' => Hash::make('password'),
//                'created_at' => Carbon::now()
//            ]);
//        }
    }
}
