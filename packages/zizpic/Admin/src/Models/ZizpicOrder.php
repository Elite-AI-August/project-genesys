<?php

namespace Zizpic\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class ZizpicOrder extends BaseModel {

    /**
     * The metrics table.
     * 
     * @var string
     */
    protected $table = 'orders';
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];
    protected $fillable = ['name' , 'email' , 'phone' , 'zizcode' , 'phone_order' , 'payment_method' , 'status' , 'data' , 'address' , 'city' , 'country' , 'state' , 'zip' , 'full_name' ,
        'zizpic_1_image' , 'zizpic_2_image' , 'zizpic_3_image' , 'zizpic_1_word_1' , 'zizpic_1_word_2' , 'zizpic_1_word_3' , 'zizpic_2_word_1' ,
        'zizpic_2_word_2' , 'zizpic_2_word_2' , 'zizpic_2_word_3' ,
        'zizpic_3_word_1' , 'zizpic_3_word_2' , 'zizpic_3_word_3' ];

}
