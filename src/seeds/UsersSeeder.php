<?php

class UsersSeeder extends Seeder {

    public function run()
    {
        $this->command->info('Creating sample users...');
        
        // Uncomment the below to wipe the table clean before populating
       	DB::table('roles')->truncate();
        DB::table('users')->truncate();
      	DB::table('role_user')->truncate();

      	$roles = array(
            array(
                'role' => 'admin'
            ),
            array(
                'role' => 'manager'
            ),
            array(
                'role' => 'user'
            )
        );

      	$users = array(
            array(                
                'email'	=> 'admin@admin.ru',
                'password' => Hash::make('admin@admin.ru')
            )
        );
      
		    $role_user = array(
            array(
              'user_id' => 1, 
              'role_id' => 1
           	)
        );
        
      
        DB::table('roles')->insert($roles);
      	DB::table('users')->insert($users);
        DB::table('role_user')->insert($role_user);
    }

}
