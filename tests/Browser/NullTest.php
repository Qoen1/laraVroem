<?php

namespace Tests\Browser;

use App\Models\Car;
use App\Models\Refuel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * this is a class that tests all pages and makes sure no errors are thrown when there is no data present.
 */
class NullTest extends DuskTestCase
{
    use DatabaseMigrations;

    #region cars

    public function testCarOverview(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $browser
                ->visit('/')
                ->loginAs($user)
                ->visit('/cars')
                ->assertSee('My Cars');
        });
    }

    public function testCarDetails(): void
    {
        $this->browse(function (Browser $browser) {
            $car = Car::factory()->create();
            $user = User::factory()->create();

            $browser
                ->visit('/')
                ->loginAs($user->id)
                ->visit('/cars/'.$car->id)
                ->assertSee($car->license_plate);
        });
    }

    #endregion

    #region drives

    public function testDriveOverview(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $browser
                ->visit('/')
                ->loginAs($user)
                ->visit('/drives')
                ->assertSee('My Drives');
        });
    }

    #endregion

    #region refuels

    public function testRefuelOverview(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $browser
                ->visit('/')
                ->loginAs($user)
                ->visit('/refuels')
                ->assertSee('My Refuels');
        });
    }

    public function testRefuelDetails(): void
    {
        $this->browse(function (Browser $browser) {
            $car = Car::factory()->create();
            $user = User::factory()->create();
            $refuel = Refuel::factory()->create([
                'car_id' => $car->id,
                'user_id' => $user->id,
            ]);

            $browser
                ->visit('/')
                ->loginAs($user->id)
                ->visit('/refuels/'.$refuel->id)
                ->assertSee('Refuel on');
        });
    }

    #endregion
}
