<?php

use Illuminate\Database\Seeder;

class Categorys_E_TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('categorys_i')->insert([
        [
          'name' => '家電',
        ],
        [
          'name' => '電気',
        ],
        [
          'name' => 'テスト3',
        ],
        [
          'name' => 'テスト4',
        ],
      ]);
    }
}
