<?php

namespace Database\Seeders;

use Core\Mail\Models\Mail;
use Illuminate\Database\Seeder;

class MailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mail::factory()->count(3)->create();
    }
}
