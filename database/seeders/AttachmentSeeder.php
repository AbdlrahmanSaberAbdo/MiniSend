<?php

namespace Database\Seeders;

use Core\Mail\Models\Attachment;
use Core\Mail\Models\Mail;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attachment::factory()->count(3)->create([
            'attachmentable_id' => Mail::inRandomOrder()->first()->id,
            'attachmentable_type' => 'mail'
        ]);
    }
}
