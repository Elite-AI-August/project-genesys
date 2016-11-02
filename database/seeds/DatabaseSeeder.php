<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    /* public function run()
      {
      Model::unguard();

      // $this->call('UserTableSeeder');
      } */

    public function run() {
        DB::table( 'users' )->delete();

        DB::table( 'users' )->insert( array(
            array( 'name' => 'Admin User' , 'email' => 'admin@admin.com' , 'password' => '$2y$10$wx/MRfD0RAbZIIPpgfwVX.M7/kvzKvFwyFYELpil20bU2D2iDndLq' ) ,
        ) );
        Model::unguard();

        DB::table( 'roles' )->delete();
        DB::table( 'roles' )->insert( array(
            array( 'slug' => 'administator' , 'name' => "Administator" ) ,
        ) );

        DB::table( 'role_user' )->delete();

        DB::table( 'role_user' )->insert( array(
            array( 'role_id' => '1' , 'user_id' => '1' ) ,
        ) );

        DB::table( 'permissions' )->delete();

        DB::table( 'permissions' )->insert( array(
            array( 'name' => 'add' , 'slug' => 'add' ) ,
            array( 'name' => 'edit' , 'slug' => 'edit' ) ,
            array( 'name' => 'delete' , 'slug' => 'delete' ) ,
        ) );

        DB::table( 'permission_role' )->delete();

        DB::table( 'permission_role' )->insert( array(
            array( 'permission_id' => '1' , 'role_id' => '1' ) ,
            array( 'permission_id' => '2' , 'role_id' => '1' ) ,
            array( 'permission_id' => '3' , 'role_id' => '1' ) ,
        ) );
        // APp_Setting table
        DB::table( 'app_setting' )->delete();
        DB::table( 'app_setting' )->insert( array(
            array( 'option_name' => 'app_name' , 'option_value' => '<b>WMS</b> PLUS' ) ,
            array( 'option_name' => 'short_app_name' , 'option_value' => 'WMS' ) ,
            array( 'option_name' => 'parent_inventory_id' , 'option_value' => 'no' ) ,
            array( 'option_name' => 'app_name' , 'option_value' => ' http://asas.png' ) ,
            array( 'option_name' => 'logo' , 'option_value' => 'http://sgc.co.il/logo.png' ) ,
            array( 'option_name' => 'assembly' , 'option_value' => 'kit' ) ,
            array( 'option_name' => 'assemblies' , 'option_value' => 'kits' ) ,
            array( 'option_name' => 'part' , 'option_value' => 'unit' ) ,
            array( 'option_name' => 'parts' , 'option_value' => 'units' ) ,
            array( 'option_name' => 'timezone' , 'option_value' => 'Asia/Jerusalem' ) ,
        ) );
        // Metrics
        DB::table( 'metrics' )->delete();
        DB::table( 'metrics' )->insert( array(
            array( 'user_id' => '1' , 'name' => 'unit' , 'symbol' => 'unit' ) ,
        ) );
        // Categories
        DB::table( 'categories' )->delete();
        DB::table( 'categories' )->insert( array(
            array( 'parent_id' => '0' , 'name' => 'no category' ) ,
        ) );
    }

}
