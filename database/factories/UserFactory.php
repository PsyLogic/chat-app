<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'profile_img' => 'https://via.placeholder.com/150',
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Message::class, function (Faker $faker) {
    do{
        $sender = rand(1,15);
        $receiver = rand(1,15);
    }while($sender === $receiver);

    return [
        'sender' => $sender,
        'receiver' => $receiver,
        'text' => $faker->sentence,
        'read' => $faker->boolean
    ];
});
