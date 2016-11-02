<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'menu_items' , function(Blueprint $table) {
            // These columns are needed for Baum's Nested Set implementation to work.
            // Column names may be changed, but they *must* all exist and be modified
            // in the model.
            // Take a look at the model scaffold comments for details.
            $table->increments( 'id' );
            $table->integer( 'menu_id' )->unsigned();
            $table->integer( 'parent_id' )->nullable();
            $table->integer( 'sort' )->nullable();
            $table->string( 'title' );
            $table->string( 'icon' )->nullable();
            $table->string( 'action' );
            $table->timestamps();
            // Default indexes
            // Add indexes on parent_id column by default. Of course,
            // the correct ones will depend on the application and use case.
            $table->index( 'parent_id' );
            $table->softDeletes();
            $table->foreign( 'menu_id' )->references( 'id' )->on( 'menus' )
                    ->onUpdate( 'restrict' )
                    ->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop( 'menu_items' );
    }

}
