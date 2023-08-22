<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(3)->create();

        if (is_null(User::where(['email' => 'admin@buckhill.co.uk'])->first())) {
            User::factory()->defaultAdmin()->create();
        }
    }
}
