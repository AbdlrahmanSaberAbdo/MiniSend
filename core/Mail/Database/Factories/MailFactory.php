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
        $statuses = ['posted', 'Sent', 'Failed'];
        return [
            'sender'    => $this->faker->email(),
            'recipient' => $this->faker->email(),
            'text'      => $this->faker->text(200),
            'html'      =>  $this->faker->text(200),
            'status'    => $statuses[array_rand([0,1,2])],
            'subject'   => $this->faker->title()
        ];
    }
}
