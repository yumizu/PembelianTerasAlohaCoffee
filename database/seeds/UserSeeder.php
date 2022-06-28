<?php
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('user');
        $user = User::create([
            'name' => 'Manajer Operasional',
            'email' => 'operational@gmail.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('operational');
    }
}
