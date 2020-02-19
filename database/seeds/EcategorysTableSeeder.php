<?php

use Illuminate\Database\Seeder;

class EcategorysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ecategories')->insert([
        [
          'name' => 'なし',
        ],
        [
          'name' => '食費',
        ],
        [
          'name' => '日用品',
        ],
        [
          'name' => '衣服',
        ],
        [
          'name' => '美容',
        ],        
        [
          'name' => '交際費',
        ],        
        [
          'name' => '医療費',
        ],        
        [
          'name' => '教育費',
        ],        
        [
          'name' => '水道代',
        ],        
        [
          'name' => '電気代',
        ],        
        [
          'name' => 'ガス代',
        ], 
        [
          'name' => 'ネット代',
        ],        
        [
          'name' => '交通費',
        ],        
        [
          'name' => '携帯代',
        ],        
        [
          'name' => '住居費',
        ],        
        ]);
    }
}
