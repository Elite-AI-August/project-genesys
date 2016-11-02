@extends('packages::layouts.front-end')
@section('content')
<body>
    <div class="container">
        {!! Form::model($zizpicOrder, ['route' => ['zizpicorders.store'],'class'=>'form-horizontal','role'=>'form','files' => true,'id'=>'zizpic_order_form']) !!}

        <fieldset class="form-bg">
            <div class="row">
                <div class="col-md-3 logo-adjust">
                    <img src="{{  url('assets/images/logo.png') }}" />
                </div>
                <div class="col-md-offset-1 col-md-4 text-center top-title">
                    <h2 class="no-margin" style="color:#291b23;">{{ Lang::get( 'zizpic-lang.zizpic' ) }} {{ Lang::get( 'zizpic-lang.order' ) }}</h2>
                </div>
            </div>  @if($errors->first('package')){{ 'test--'.$errors->first('package') }} @endif
            <div class="row radio_package">
                Order:  {!! Form::radio('package',1) !!} 1 {{ Lang::get( 'zizpic-lang.zizpic' ) }}
                {!! Form::radio('package',3, ['checked'=>'checked']) !!} 3  {{ Lang::get( 'zizpic-lang.zizpic' ) }}
            </div>
            <div class="form-group">
                <h5 class="with-bg hidden-lg hidden-md hidden-sm">
                    <span class="white-bg required">{{ Lang::get( 'zizpic-lang.zizpic' ) }}1</span>
                </h5>
                <div class="col-sm-4 col-ziz  zizpic_1">
                    <h5 class='hidden-xs'>
                        <span class="white-bg required">{{ Lang::get( 'zizpic-lang.zizpic' ) }} 1</span>
                    </h5>
                    <div class='image-wrapper'>
                        <input type="text" readonly="readonly" class="form-control zizpic-word1 upload-image upload-image-1" placeholder="{{ Lang::get( 'zizpic-lang.upload_image' ) }}" />

                        <img src="" id="zizpic_img_1" class="col-sm-12" >
                        <div class='error zizpic_1_error zizpic_error_1' style='display:{{ ($errors->first('zizpic_1_image'))?"block":"none" }}'  >

                            @if($errors->first('zizpic_1_image'))
                            <center>{{ $errors->first('zizpic_1_image', ':message') }}</center>
                            @else
                            <center> {{ Lang::get('zizpic-lang.ziz_image_is_mandatory')}} </center>
                            @endif
                        </div>
                        <input type="file" class="hide" name="zizpic_1_image" id="zizpic_1_image" onchange="getImg(this, 1);" />
                    </div>
                    <h5 class="top-head">
                        <span>3  {{ Lang::get( 'zizpic-lang.words_for_zizpic' ) }}</span>
                    </h5>
                    <input type="text" class="form-control zizpic-word1" placeholder="Tune" name="zizpic_1_word_1" />
                    <input type="text" class="form-control zizpic-word1" placeholder="Look" name="zizpic_1_word_2" />
                    <input type="text" class="form-control zizpic-word1" placeholder="Activate" name="zizpic_1_word_3" />
                </div>
                <h5 class="with-bg hidden-lg hidden-md hidden-sm">
                    <span class=" required">{{ Lang::get( 'zizpic-lang.zizpic' ) }} 1</span>
                </h5>

                <div class="col-sm-4 col-ziz borders zizpic_2">
                    <h5 class='hidden-xs'>
                        <span class="white-bg required">{{ Lang::get( 'zizpic-lang.zizpic' ) }} 2</span>
                    </h5>
                    <div class='image-wrapper'>
                        <input type="text" readonly="readonly" class="form-control upload-image upload-image-2" placeholder="{{ Lang::get( 'zizpic-lang.upload_image' ) }}" />
                        <img src="" id="zizpic_img_2" class="col-sm-12" >
                        <div class='error zizpic_error_2' style='display:{{ ($errors->first('zizpic_2_image'))?"block":"none" }}'  >
                            @if($errors->first('zizpic_2_image'))
                            <center>{{ $errors->first('zizpic_2_image', ':message') }}</center>
                            @else
                            <center> {{ Lang::get('zizpic-lang.ziz_image_is_mandatory')}} </center>
                            @endif
                        </div>
                        <input type="file" class="hide" name="zizpic_2_image" id="zizpic_2_image" onchange="getImg(this, 2);" />
                    </div>
                    <h5 class="top-head">
                        <span>3  {{ Lang::get( 'zizpic-lang.words_for_zizpic' ) }} </span>
                    </h5>
                    <input type="text" class="form-control" placeholder="Tune" name="zizpic_2_word_1" />
                    <input type="text" class="form-control" placeholder="Look" name="zizpic_2_word_2" />
                    <input type="text" class="form-control" placeholder="Activate" name="zizpic_2_word_3" />
                </div>

                <h5 class="with-bg hidden-lg hidden-md hidden-sm">
                    <span class="required">{{ Lang::get( 'zizpic-lang.zizpic' ) }} 3</span>
                </h5>

                <div class="col-sm-4 col-ziz zizpic_3">
                    <h5 class='hidden-xs'>
                        <span class="white-bg required">{{ Lang::get( 'zizpic-lang.zizpic' ) }} 3</span>
                    </h5>
                    <div class='image-wrapper'>
                        <input type="text" readonly="readonly" class="form-control upload-image upload-image-3" placeholder="{{ Lang::get( 'zizpic-lang.upload_image' ) }}" />
                        <img src="" id="zizpic_img_3" class="col-sm-12" >
                        <div class='error zizpic_error_3' style='display:{{ ($errors->first('zizpic_3_image'))?"block":"none" }}'  >
                            @if($errors->first('zizpic_3_image'))
                            <center>{{ $errors->first('zizpic_3_image', ':message') }}</center>
                            @else
                            <center> {{ Lang::get('zizpic-lang.ziz_image_is_mandatory')}} </center>
                            @endif
                        </div>

                        <input type="file" class="hide" name="zizpic_3_image" id="zizpic_3_image" onchange="getImg(this, 3);" />
                    </div>
                    <h5 class="top-head">
                        <span>3  {{ Lang::get( 'zizpic-lang.words_for_zizpic' ) }} </span>
                    </h5>
                    <input type="text" class="form-control" placeholder="Tune" name="zizpic_3_word_1" />
                    <input type="text" class="form-control" placeholder="Look" name="zizpic_3_word_2" />
                    <input type="text" class="form-control" placeholder="Activate" name="zizpic_3_word_3" />
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12 no-padding">
                    <div class="top-heading-wrp top-heading-wrp-artist">
                        <h5 class="with-bg ">
                            <span>
                                {{ Lang::get( 'zizpic-lang.zipic_artist_you' ) }}
                            </span>
                        </h5>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4 ship-box">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 no-padding hidden-xs">
                                <label class="pull-right" for="exampleInputName2">
                                    <span class="required white-bg">{{ Lang::get( 'zizpic-lang.name') }}</span>
                                </label>
                            </div>
                            <div class="col-md-9 col-md-9 no-padding">
                                <div class="pull-left input-holder required">
                                    {!! Form::text('name',null, ['class'=>($errors->first('name'))?"error form-control validate-input":"form-control validate-input" , 'placeholder'=>Lang::get( 'zizpic-lang.name' )]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 no-padding">
                    <div class="top-heading-wrp shipment">
                        <h5 class="with-bg ">
                            <span>{{ Lang::get( 'zizpic-lang.shipment_address' ) }}</span>
                        </h5>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4 ship-box">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 no-padding hidden-xs">
                                <label class="pull-right" for="exampleInputName2">
                                    <span class="white-bg required">{{ Lang::get( 'zizpic-lang.email') }}</span>
                                </label>
                            </div>
                            <div class="col-md-9 col-md-9 no-padding">
                                <div class="pull-left input-holder required">
                                    {!! Form::text('email', null, [ 'id' =>'email','class'=>($errors->first('email'))?"error form-control validate-input":"form-control validate-input", 'placeholder'=>Lang::get( 'zizpic-lang.email' )]) !!}
                                    <span>To be used for receipt and shipment updates</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4 ship-box">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3  no-padding hidden-xs full-name">
                                <label class="pull-right" for="exampleInputName2">
                                    <span class="white-bg required">{{ Lang::get( 'zizpic-lang.full_name') }}</span>
                                </label>
                            </div>
                            <div class="col-md-9 col-md-9 no-padding">
                                <div class="pull-left input-holder required">
                                    {!! Form::text('full_name', null, ['id'=>'full_name','class'=>($errors->first('full_name'))?"error validate-input form-control":"form-control validate-input", 'placeholder'=>Lang::get( 'zizpic-lang.full_name' )]) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4 ship-box">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3  no-padding hidden-xs">
                                <label class="pull-right" for="exampleInputName2">
                                    <span class="white-bg required">{{ Lang::get( 'zizpic-lang.address') }}</span>
                                </label>
                            </div>
                            <div class="col-md-9 col-md-9 no-padding">
                                <div class="pull-left input-holder required">
                                    {!! Form::text('address', null, ['class'=>($errors->first('address'))?"error form-control validate-input":"form-control validate-input", 'placeholder'=>Lang::get( 'zizpic-lang.address' )]) !!}


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4 ship-box">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 no-padding hidden-xs">
                                <label class="pull-right" for="exampleInputName2">
                                    <span class="white-bg required">{{ Lang::get( 'zizpic-lang.city') }}</span>
                                </label>
                            </div>
                            <div class="col-md-9 col-md-9 no-padding">
                                <div class="pull-left input-holder required">
                                    {!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.city' )]) !!}
                                    <span class="label label-danger">{{ $errors->first('city', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4 ship-box">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 no-padding hidden-xs">
                                <label class="pull-right" for="exampleInputName2">
                                    <span class="white-bg white-bg-state required">{{ Lang::get( 'zizpic-lang.state') }}</span>
                                </label>
                            </div>
                            <div class="col-md-9 col-md-9 no-padding">
                                <div class="pull-left input-holder required">
                                    {!! Form::text('state', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.state' )]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4 ship-box">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 no-padding hidden-xs">
                                <label class="pull-right" for="exampleInputName2">
                                    <span class="white-bg required">{{ Lang::get( 'zizpic-lang.zip') }}</span>
                                </label>
                            </div>
                            <div class="col-md-9 col-md-9 no-padding">
                                <div class="pull-left input-holder required">
                                    {!! Form::text('zip', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.zip' )]) !!}
                                    <span class="label label-danger">{{ $errors->first('zip', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4 ship-box">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 no-padding hidden-xs">
                                <label class="pull-right" for="exampleInputName2">
                                    <span class="white-bg required">{{ Lang::get( 'zizpic-lang.country') }}</span>
                                </label>
                            </div>
                            <div class="col-md-9 col-md-9 no-padding">
                                <div class="pull-left input-holder required">
                                    {!! Form::text('country', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.country' )]) !!}
                                    <span class="label label-danger">{{ $errors->first('country', ':message') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4 ship-box">
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="col-md-3 col-sm-3 no-padding hidden-xs">
                                <label class="pull-right" for="exampleInputName2">
                                    <span class="white-bg required">{{ Lang::get( 'zizpic-lang.phone') }}#</span>
                                </label>
                            </div>
                            <div class="col-md-9 col-md-9 no-padding">
                                <div class="pull-left input-holder required">
                                    {!! Form::text('phone', null, ['class'=>($errors->first('phone'))?"error validate-input form-control":"form-control validate-input", 'placeholder'=>Lang::get( 'zizpic-lang.phone' )]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 no-padding">
                    <div class="top-heading-wrp billing-inq">
                        <h5 class="with-bg billing " style="color: black;">
                            <span>{{ Lang::get( 'zizpic-lang.billing' ) }}</span>
                        </h5>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="  col-md-12 ">
                    <div class="form-group">
                        <div class="col-md-3 billing-lf">
                            <span class="pay-inq">PAYMENT</span>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>{{ Lang::get( 'zizpic-lang.zizpics' ) }}</td>
                                        <td class="pkg-price"> <span id="price" > {{ $prices_details['package_3'] }}$  </span>
                                            <input type="hidden" id="zizpic_1" value="{{ $prices_details['package_1'] }}">
                                            <input type="hidden" id="zizpic_3" value="{{ $prices_details['package_3'] }}">
                                            <input type="hidden" id="zizpic_shipment" value="{{ $prices_details['shippment'] }}">
                                        </td>
                                    </tr>
                                </tbody>

                                <tr>
                                    <td >{{ Lang::get( 'zizpic-lang.delivery' ) }}</td>
                                    <td class="pkg-price">{{trim($prices_details['shippment'])}}$</td>
                                </tr>
                                <tr class="zc" style="display: none; background: #DBFFB4" >
                                    <td>ZC</td>
                                    <td id="zc_discount"> </td>
                                </tr>

                                <tbody>
                                    <tr>
                                        <td>{{ Lang::get( 'zizpic-lang.total' ) }}</td>
                                        <td> <span class="total_amount">{{ $prices_details['package_3']+$prices_details['shippment']}}$</span>
                                            <input type="hidden" name="amount" id='amount' value="{{ number_format($prices_details['package_3']+$prices_details['shippment'], 2) }}">
                                            <input type="hidden" name="currency" value="{{$prices_details['currency']}}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 billing-rh">
                            <div class="col-md-2 coupon-icon"> <img src="{{ url('assets/images/imgo.jpg') }}" > </div>
                            <div class="col-md-5 coupon-code-txt">
                                <div class="row">
                                    {!! Form::text('coupon_code', null, ['class'=>'form-control ', 'placeholder'=>Lang::get( 'zizpic-lang.coupon' )]) !!}
                                    {!! Form::hidden('zizcode', null, ['class'=>'form-control coupon_id', 'placeholder'=>Lang::get('zicpic-lang.coupon')]) !!}
                                    <span class="coupon-msg"></span>
                                </div>
                            </div>
                            <div class="col-md-5 coupon-code-submit">
                                <div class="row">
                                    {!! Form::button(Lang::get( 'zizpic-lang.submit' ), ['class'=>'form-control btn btn-default coupon','id'=>'coupon_submit']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="  col-md-12 payoption text-center">
                    <div class="form-group" id="pay_option_menu">
                        <div id="pay_option">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-3">
                                {!! Form::button('', ['class'=>'form-control btn btn-default','id'=>'visa']) !!}
                            </div>
                            <div class="col-md-3 by_paypal_payment">
                                {!! Form::button('', ['class'=>'form-control btn default by-paypal','value'=>'by paypal','id'=>'by_paypal_payment']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::button("",  ['class'=>'form-control btn default','id'=>'by_phone']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="by-phone"  style="display: none">
                    <div class="form-group">
                        <center><span class="leave_phn_num">
                                {{ Lang::get( 'zizpic-lang.leave_your_phone_number_and_we_will_call_you_for_billing' ) }}
                            </span> </center>
                    </div>
                    <div class="form-group"  >
                        <div class="col-md-2"></div>
                        <div class="col-md-8 btm-wrp">
                            <div class="col-md-1 left-inq "></div>
                            <div class="col-md-2 left-inq phone_order_lebel ">{{ Lang::get( 'zizpic-lang.phone') }} #</div>
                            <div class="col-md-3 left-inq ">
                                <div class="row phone_order_append" >
                                    {!! Form::text('phone_order', null, ['class'=>'form-control phone_order ', 'placeholder'=>Lang::get( 'zizpic-lang.phone_number' )]) !!}
                                    <span class="label label-danger">{{ $errors->first('phone_order', ':message') }}</span>
                                    {!! Form::hidden('payment_method','',['id'=>'payment_method']) !!}
                                </div>
                            </div>

                            <div class="col-md-4 right-inq "><div class="row">
                                    {!! Form::submit(Lang::get( 'zizpic-lang.submit_order' ), ['class'=>'form-control btn ','id'=>'form_submit']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </fieldset>
        {!! Form::close() !!}
    </div>
    @stop