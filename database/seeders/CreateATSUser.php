<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateATSUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name'      => 'ADMIN',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('12345678'),
            'role'      => 'ADMIN'
        ];
        User::create($data);
        $data = [
            'name'      => 'TEACHER',
            'email'     => 'teacher@gmail.com',
            'password'  => Hash::make('12345678'),
            'role'      => 'TEACHER'
        ];
        User::create($data);
        $data = [
            'name'      => 'STUDENT',
            'email'     => 'student@gmail.com',
            'password'  => Hash::make('12345678'),
            'role'      => 'STUDENT'
        ];
        User::create($data);
    }
}
