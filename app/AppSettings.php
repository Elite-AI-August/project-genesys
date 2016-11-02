<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model {

    /**
     * The metrics table.
     *
     * @var string
     */
    protected $table = 'app_setting';
    protected $guarded = ['id' , 'created_at' , 'updated_at' ];
    protected $fillable = ['option_name' , 'option_value' ];

    /**
     * The hasMany inventory items relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
}
