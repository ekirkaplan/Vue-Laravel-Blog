<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $hasAdmin = User::where('email','egemen@innoviz.com.tr')->count('id');
        if ($hasAdmin < 1){
            $arr = [
                'name' => 'Egemen KIRKAPLAN',
                'email' => 'egemen@innoviz.com.tr',
                'password' => Hash::make('egemensevda'),
                'status' => 1,
            ];
            User::create($arr);
        }
    }
}
