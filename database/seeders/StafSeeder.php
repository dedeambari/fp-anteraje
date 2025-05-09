<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staf;

class StafSeeder extends Seeder
{
    public function run(): void
    {
        Staf::factory()->count(20)->create();
    }
}
