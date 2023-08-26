<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Car;
use App\Models\Drive;
use App\Models\Refuel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = new Role();
        $adminRole->role_name = 'admin';
        $adminRole->save();

        $userRole = new Role();
        $userRole->role_name = 'user';
        $userRole->save();

        $user = new User();
        $user->name = 'koen verstappen';
        $user->email = 'koenverstappen2003@gmail.com';
        $user->password = bcrypt('Ab12345');
        $user->role_name = 'admin';
        $user->save();

        $car = Car::factory()->create();

        for($i=0;$i<3;$i++){
            $user = User::factory()->create();
            Refuel::factory()->count(5)
                ->for($user)
                ->for($car)
                ->has(
                    Drive::factory()
                        ->count(10)
                        ->for($car)
                        ->for($user)
                )
                ->create();
            $user->cars()->attach($car, ['activated_at' => now()]);
        }
    }
}
