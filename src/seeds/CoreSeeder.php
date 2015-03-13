<?php

class CoreSeeder extends Seeder {

    public function run()
    {
        $this->command->info('Creating sample core...');
        
        // Uncomment the below to wipe the table clean before populating
        DB::table('types')->truncate();
        DB::table('units')->truncate();
        
        $types = array(
            array(
                'code'    => 'page',
                'name'    => 'Страница',
                'default' => '1'
            ),
            array(
                'code'    => 'news',
                'name'    => 'Новость',
                'default' => '0'
            ),
            array(
                'code'    => 'form',
                'name'    => 'Форма',
                'default' => '0'
            )
        );

        $units = array(
            array(                
                'type_id'   => '1',
                'created_by'   => '1',
                'public_date'   => date_sql(),
                'main'      => '1',
                'active'    => '1',
                'code'      => 'index',
                'url'       => '/',
                'name'      => 'Главная',
                'content'   => 'Главная страница'
            ),
            array(                
                'type_id'   => '1',
                'created_by'   => '1',
                'public_date'   => date_sql(),
                'main'      => '0',
                'active'    => '1',
                'code'      => 'news',
                'url'       => '/news',
                'name'      => 'Новости',
                'content'   => 'Главная новостей'
            ),
            array(                
                'type_id'   => '1',
                'created_by'   => '1',
                'public_date'   => date_sql(),
                'main'      => '0',
                'active'    => '1',
                'code'      => 'contacts',
                'url'       => '/contacts',
                'name'      => 'Контакты',
                'content'   => 'Страница контактов'
            ),
        );
      
        $settings = array(
            array(
                'code'  => 'site_name',
                'type'  => 'string',
                'value_string'  => 'demo site'              
            )
            ,array(
                'code'  => 'site_enable',
                'type'  => 'int',
                'value_int' => 1
            ),
        );
      
        
      
        DB::table('types')->insert($types);
        DB::table('units')->insert($units);
        DB::table('settings')->insert($settings);
    }

}
