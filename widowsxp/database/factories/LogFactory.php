<?php

use Faker\Generator as Faker;

$factory->define(WidowsXP\Log::class, function (Faker $faker) {
    return [
	    'uname' => $faker->uname,
	    'compname' => $faker->compname,
	    'ipaddress' => $faker->ipaddress,
	    'os_version' => $faker->os_version,
	    'os_build' => $faker->os_build,
	    'bios_version' => $faker->bios_version,
	    'bios_date' => $faker->bios_date,
	    'model' => $faker->model,
	    'serial' => $faker->serial,
	    'date' => $faker->date,
    ];
});
