<?php

use Faker\Generator as Faker;

//  博文表
$factory->define(App\Models\Status::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    return [
        'content' => $faker->text(),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
