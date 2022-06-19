<?php

namespace Core\Mail\Database\Factories;

use Core\Mail\Models\Mail as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sender' => $this->faker->text(100),
            'recipient' => '',
            'text' => '',
            'html' => '',
            'status' => '',
            'subject' => ''
        ];
    }
}
