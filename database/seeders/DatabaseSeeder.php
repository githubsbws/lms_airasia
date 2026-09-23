<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users::factory(10)->create();

        Users::factory()->create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'superuser' => 1, // เพื่อทดสอบ bypass permission ตาม design.md
        ]);
    }
}
