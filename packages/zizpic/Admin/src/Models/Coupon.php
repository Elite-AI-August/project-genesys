<?php

namespace Zizpic\Admin\Models;

class Coupon extends BaseModel {

    /**
     * The metrics table.
     *
     * @var string
     */
    protected $table = 'copouns';
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];
    protected $fillable = ['id' , 'exp_date' , 'used_limit' , 'name' , 'amount_usd' , 'amount_nis' , 'package' ];

    /**
     * The hasMany inventory items relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes() {
        return $this->hasMany( 'Zizpic\Admin\Models\CouponCode' , 'copoun_id' , 'id' );
    }

}
