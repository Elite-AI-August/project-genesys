<?php

namespace App;

use Validator;
use Input;
use App\AppSettings;
use Illuminate\Database\Eloquent\Model;

class CustomFields extends Model {

    protected $table = 'custom_fields';
    protected $guarded = ['id' , 'created_at' , 'updated_at' ];
    protected $fillable = ['fieldable' , 'field_name' , 'field_type' , 'field_value' , 'field_placeholder' , 'field_rules' ];

    public function app_setting() {
        return $this->belongsTo( 'App\AppSettings' , 'fieldable' );
    }

}
