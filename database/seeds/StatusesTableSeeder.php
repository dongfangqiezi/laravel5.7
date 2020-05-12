<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  给id为1，2的用户添加一百条假博文
        $user_ids = ['1','2'];
        $faker = app(Faker\Generator::class);

        $statuses = factory(Status::class)->times(100)->make()->each(function ($status) use ($faker, $user_ids) {
            $status->user_id = $faker->randomElement($user_ids);
        });

        Status::insert($statuses->toArray());
    }
}
