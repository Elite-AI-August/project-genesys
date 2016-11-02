<?php

namespace App\Helpers;

use Packages;
use Mail;
use Auth;
use Config;
use View;
use Input;
use session;
use Crypt;
use Hash;
use Menu;
use Inventory\Admin\Models\KitStockMap;
use Inventory\Admin\Models\AppSetting;
use Inventory\Admin\Models\Location;
use Illuminate\Support\Str;
use App\RoleUsers;
use App\Role;
use App\User;
use Phoenix\EloquentMeta\MetaTrait;
use App\AppSettings;
use Inventory\Admin\Models\CustomFields;

class Helper {

    /**
     * function used to check stock in kit
     *
     * @param = null
     */
    public static function check_stock_in_kit( $stock_id = 0 ) {
        $stock_count = KitStockMap::where( 'stock_id' , $stock_id )->count();
        return $stock_count;
    }

    public function get_app_name() {
        $app_name = AppSetting::where( 'option_name' , 'inventory' )->lists( 'option_value' );

        return $app_name[ 'option_value' ];
    }

    public function addMetaData( $input = array() , $model ) {
        $result = 0;
        $checkbox = Input::get( 'check' );
        foreach ( $input as $key => $value ) {
            $status = $model->addMeta( $key , $value );
            if ( $status ) {
                $result++;
            }
//            if ( count( $checkbox ) > 0 ) {
//                foreach ( $checkbox as $key => $value ) {
//                    $model->addMeta( 'check_' . $key , $value );
//                }
//            }
        }
        return ($result > 0) ? true : false;
    }

    public function updateMetaData( $input = array() , $model ) {
        $result = 0;
        $model = $model::find( $model->id );
        $checkbox = Input::get( 'check' );
        foreach ( $input as $key => $value ) {
            $status = $model->updateMeta( $key , $value );
            if ( $status ) {
                $result++;
            }
//            if ( count( $checkbox ) > 0 ) {
//                foreach ( $checkbox as $key => $value ) {
//                    $model->updateMeta( 'check_' . $key , $value );
//                }
//            }
        }
        return ($result > 0) ? true : false;
    }

    public function getCustomFields( $option_value ) {
        $app_setting_record = AppSettings::where( 'option_name' , 'fieldable_type' )
                        ->where( 'option_value' , $option_value )->get();
        $custom_record = CustomFields::where( 'fieldable' , $app_setting_record[ 0 ][ 'id' ] )->get();
        $data = [ ];
        foreach ( $custom_record as $key => $value ) {
            if ( $value->field_type == 'select' ) {
                $data[ 'select_box' ][] = $value->field_name;
                $data[ 'select' ][] = preg_split( "/\\r\\n|\\r|\\n/" , $value->field_value );
            }
            if ( $value->field_type == 'radio' ) {
                $data[ 'radio_box' ][] = $value->field_name;
                $data[ 'radio' ][] = preg_split( "/\\r\\n|\\r|\\n/" , $value->field_value );
            }
            if ( $value->field_type == 'text' ) {
                $data[ 'text_box' ][] = $value->field_name;
                $data[ 'text' ][] = preg_split( "/\\r\\n|\\r|\\n/" , $value->field_value );
            }
            if ( $value->field_type == 'checkbox' ) {
                $data[ 'check_box' ][] = $value->field_name;
                $data[ 'checkbox' ][] = preg_split( "/\\r\\n|\\r|\\n/" , $value->field_value );
            }
            if ( $value->field_type == 'file' ) {
                $data[ 'file_name' ][] = $value->field_name;
                $data[ 'file' ][] = "";
            }
        }
        return $data;
    }

    public function addFileToMeta( $model , $action ) {
        if ( Input::hasFile( 'file_name' ) ) {
            foreach ( Input::file( 'file_name' ) as $key => $file ) {
                if ( $action == 'add' ) {
                    $file->move( public_path() . '/user_files/' , $model->id . '.' . $file->getClientOriginalExtension() );
                    @unlink( public_path() . '/user_files/' , $model->id . '.' . $file->getClientOriginalExtension() );
                    $img_path = '/user_files/' . $model->id . '.' . $file->getClientOriginalExtension();
                    $model->addMeta( 'file_name_' . $key , $img_path );
                }
                if ( $action == 'update' ) {
                    $file->move( public_path() . '/user_files/' , $model->id . '.' . $file->getClientOriginalExtension() );
                    @unlink( public_path() . '/user_files/' , $model->id . '.' . $file->getClientOriginalExtension() );
                    $img_path = '/user_files/' . $model->id . '.' . $file->getClientOriginalExtension();
                    $model->updateMeta( 'file_name_' . $key , $img_path );
                }
            }
        }
    }

    public function generateRandomString() {
        $randomString = mt_rand( 1000000 , 9999999 );
        $code = $this->check_is_coupon_exist( $randomString );
        return $code;
    }

    public function check_is_coupon_exist( $code ) {
        $result = \Zizpic\Admin\Models\CouponCode::where( 'code' , $code )->count();
        if ( $result == 0 ) {
            return $code;
        }
        else {
            $this->generateRandomString();
        }
    }

}
