<?php

use Faker\Generator as Faker;

$factory->define(\App\Task::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(),
        'done' => rand(0, 1) ? true : false,
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        }
    ];
});
