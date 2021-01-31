<?php

namespace App\Database\Seeds;

use CodeIgniter\I18n\Time;

class UsersSeeder extends \CodeIgniter\Database\Seeder
{
  public function run()
  {
    $faker = \Faker\Factory::create('id_ID');


    for ($i = 0; $i < 100; $i++) {
      $data = [
        'name'        => $faker->name(),
        'address'     => $faker->address(),
        'photo'       => '',
        'created_at'  => Time::createFromTimestamp($faker->unixTime()),
        'updated_at'  => Time::now()
      ];

      // // Simple Queries
      // $this->db->query(
      //   "INSERT INTO users (username, email) VALUES(:username:, :email:)",
      //   $data
      // );

      // Using Query Builder
      $this->db->table('users')->insert($data);
    }
  }
}
