<?php

use Illuminate\Database\Seeder;

class IcategorysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('icategories')->insert([
        [
          'name' => 'なし',
        ],
        [
          'name' => '給料',
        ],
        [
          'name' => 'おこづかい',
        ],
        [
          'name' => '賞与',
        ],
        [
          'name' => '副業',
        ],
        [
          'name' => '投資',
        ],
        [
          'name' => '臨時収入',
        ],
        ]);
    }
}
