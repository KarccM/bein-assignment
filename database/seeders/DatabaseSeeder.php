<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
        ]);

        $master = User::create([
            'name'          => 'master',
            'username'      => 'master',
            'password'      => bcrypt('Master.1234'),
        ]);
        
        $master->givePermissionTo(config('permissions.all'));

    }
}
