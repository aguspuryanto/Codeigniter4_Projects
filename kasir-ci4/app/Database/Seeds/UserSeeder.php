<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $data = [
            'username' => 'admin',
            'password' => 'admin123',
            'name' => 'Administrator',
            'role' => 'admin'
        ];

        $userModel->insert($data);
    }
}
