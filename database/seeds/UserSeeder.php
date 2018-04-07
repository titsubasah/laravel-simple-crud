<?php
/**
 * Created by PhpStorm.
 * User: jimmydumalang
 * Date: 2/8/17
 * Time: 1:54 PM
 */

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::truncate();
        $temp = array(
            'username' => 'super',
            'name' => 'super',
            'password' => Hash::make('super123'),
            'role' => 'SUPER'
        );
        User::insert($temp);
        $temp = array(
            'username' => 'admin',
            'name' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'ADMIN'
        );
        User::insert($temp);
        $temp = array(
            'username' => 'op',
            'name' => 'op',
            'password' => Hash::make('op123'),
            'role' => 'OPERATOR'
        );
        User::insert($temp);
    }

}