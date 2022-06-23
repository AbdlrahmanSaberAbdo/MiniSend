<?php

namespace Core\Mail\Database\Factories;

use Core\Mail\Models\Attachment as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttachmentFactory extends Factory
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
            'filepath' => 'public/files/' . $this->faker->word . '.txt',
        ];
    }
}
