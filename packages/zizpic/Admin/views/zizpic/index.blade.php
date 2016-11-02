@extends('packages::layouts.front-end')
@section('content')
<body class="@if(isset($lang) && $lang=='he') he @endif">
    <div class="container zpForm">
        <div class="row">
            <div class="col-sm-12">
                <div class="topHeader">
                    <a href="#" class="logo"><img src="{{ url('images/logo.png') }}" alt="" /></a>
                    <h2>{{ Lang::get( 'zizpic-lang.zizpic_order' ) }}</h2>
                </div>
            </div>
        </div>
        {!! Form::model($zizpicOrder, ['route' => ['zizpicorders.store'],'class'=>'form-horizontal','role'=>'form','files' => true,'id'=>'zizpic_order_form']) !!}
        <div class="row">
            <div class="col-sm-12">
                <div class="chooseOrder has-js">
                    <span>{{ Lang::get( 'zizpic-lang.order' ) }}:</span>
                    <label class="label_radio r_on" for="radio-01">

                        <input name="zizpackage" id="radio-01" value="1" type="radio" >
                        1
                        {{ Lang::get( 'zizpic-lang.zizpic' ) }}

                    </label>


                    <label class="label_radio" for="radio-02">

                        <input name="zizpackage" id="radio-02" value="3" checked="" type="radio">3 {{ Lang::get( 'zizpic-lang.zizpics' ) }}</label>
                </div>
            </div>
        </div>
        <div class="row zizpic3">
            <div class="col-sm-4 zizpic_1 @if(isset($lang) && $lang=='he') bdr0 @endif">
                <div class="upImg zizpic_1_0">
                    <div class="upImgHD">
                        <div class="uIHD">
                            <span class="uiTxt">   {{ Lang::get( 'zizpic-lang.zizpic_1' ) }}
                            </span><span>*</span>
                        </div>
                    </div>


                    <div class="fileUpload zizpic-word1 upload-image upload-image-1">{{ Lang::get( 'zizpic-lang.upload_image' ) }}</div>

                    <div class="fileUploadImg fileUploadImg-zizpic_img_1">
                        <div class="upImgCenter">
                            <img alt="" src="" id="zizpic_img_1">
                        </div>
                    </div>
                    <div class='error zizpic_1_error zizpic_error_1' style='display:{{ ($errors->first('zizpic_1_image'))?"block":"none" }}'  >

                        @if($errors->first('zizpic_1_image'))
                        <center>{{ $errors->first('zizpic_1_image', ':message') }}</center>
                        @else
                        <center> {{ Lang::get('zizpic-lang.ziz_image_is_mandatory')}} </center>
                        @endif
                    </div>
                    <input type="file" class="hide" name="zizpic_1_image" id="zizpic_1_image" onchange="getImg(this, 1);" />

                    <div class="threeWords"> {{ Lang::get( 'zizpic-lang.words_for_zizpic' ) }} </div>
                    <input type="text" class=" zizpic-word1 not-space" placeholder="Tune" name="zizpic_1_word_1" />
                    <input type="text" class=" zizpic-word1 not-space" placeholder="Look" name="zizpic_1_word_2" />
                    <input type="text" class="zizpic-word1 mrgn0 not-space" placeholder="Activate" name="zizpic_1_word_3" />

                </div>
            </div>
            <div class="col-sm-4 zizpic_2">
                <div class="upImg ">
                    <div class="upImgHD">

                        <div class="uIHD">
                            <span class="uiTxt">   {{ Lang::get( 'zizpic-lang.zizpic_2' ) }}
                            </span><span>*</span>
                        </div>

                    </div>


                    <div class="fileUpload  upload-image upload-image-2">{{ Lang::get( 'zizpic-lang.upload_image' ) }}</div>
                    <div class="fileUploadImg fileUploadImg-zizpic_img_2">
                        <div class="upImgCenter">
                            <img alt="" src="{{ url('images/upImg2.jpg') }}" id="zizpic_img_2">
                        </div>
                    </div>
                    <div class='error zizpic_error_2' style='display:{{ ($errors->first('zizpic_2_image'))?"block":"none" }}'  >
                        @if($errors->first('zizpic_2_image'))
                        <center>{{ $errors->first('zizpic_2_image', ':message') }}</center>
                        @else
                        <center> {{ Lang::get('zizpic-lang.ziz_image_is_mandatory')}} </center>
                        @endif
                    </div>
                    <input type="file" class="hide" name="zizpic_2_image" id="zizpic_2_image" onchange="getImg(this, 2);" />

                    <div class="threeWords"> {{ Lang::get( 'zizpic-lang.words_for_zizpic' ) }} </div>

                    <input type="text" class="not-space" placeholder="Tune" name="zizpic_2_word_1" />
                    <input type="text" class="not-space" placeholder="Look" name="zizpic_2_word_2" />
                    <input type="text" class="mrgn0 not-space" placeholder="Activate" name="zizpic_2_word_3" />
                </div>
            </div>
            <div class="col-sm-4 zizpic_3 @if(isset($lang) && $lang=='en') bdr0 @endif">
                <div class="upImg ">
                    <div class="upImgHD">

                        <div class="uIHD">
                            <span class="uiTxt">   {{ Lang::get( 'zizpic-lang.zizpic_3' ) }}
                            </span><span>*</span>
                        </div>

                    </div>
                    <div class="fileUpload upload-image upload-image-3">{{ Lang::get( 'zizpic-lang.upload_image' ) }}</div>
                    <div class="fileUploadImg fileUploadImg-zizpic_img_3">
                        <div class="upImgCenter">
                            <img alt="" src="{{ url('images/upImg3.jpg') }}" id="zizpic_img_3" >
                        </div>
                    </div>
                    <div class='error zizpic_error_3' style='display:{{ ($errors->first('zizpic_3_image'))?"block":"none" }}'  >
                        @if($errors->first('zizpic_3_image'))
                        <center>{{ $errors->first('zizpic_3_image', ':message') }}</center>
                        @else
                        <center> {{ Lang::get('zizpic-lang.ziz_image_is_mandatory')}} </center>
                        @endif
                    </div>
                    <input type="file" class="hide" name="zizpic_3_image" id="zizpic_3_image" onchange="getImg(this, 3);" />

                    <div class="threeWords"> {{ Lang::get( 'zizpic-lang.words_for_zizpic' ) }} </div>

                    <input type="text" class="zizpic-word3 not-space" placeholder="Tune" name="zizpic_3_word_1" />
                    <input type="text" class=" zizpic-word3 not-space" placeholder="Look" name="zizpic_3_word_2" />
                    <input type="text" class=" zizpic-word3 mrgn0 not-space" placeholder="Activate" name="zizpic_3_word_3" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 zizpicArtist">


                <h3><span>{{ Lang::get( 'zizpic-lang.zipic_artist_you' ) }}</span></h3>
                <div class="inptSec">
                    <label for="nm"><span class="lb_text">{{ Lang::get( 'zizpic-lang.name' ) }}</span><span>*</span></label>
                    {!! Form::text('name',null, ['class'=>($errors->first('name'))?"error  validate-input":"validate-input" , 'placeholder'=>Lang::get( 'zizpic-lang.name' )]) !!}
                </div>

            </div>
        </div>
        <div class="row">
            <div class="zizpicArtist shipAddress">
                <h3><span>{{ Lang::get( 'zizpic-lang.shipment_address' ) }}</span></h3>
                <div class="inptSec">
                    <label for="nm">
                        <span class="lb_text">
                            {{ Lang::get( 'zizpic-lang.email') }}
                        </span>
                        <span>*</span></label>
                    {!! Form::text('email', null, [ 'id' =>'email','class'=>($errors->first('email'))?"error validate-input":"validate-input", 'placeholder'=>Lang::get( 'zizpic-lang.email' )]) !!}
                    <span class="note"> {{ Lang::get( 'zizpic-lang.msg_beneath_email') }} </span>
                </div>
                <div class="inptSec">
                    <label for="nm"><span class="lb_text">{{ Lang::get( 'zizpic-lang.full_name') }}</span><span>*</span></label>
                    {!! Form::text('full_name', null, ['id'=>'full_name','class'=>($errors->first('full_name'))?"error validate-input ":"validate-input", 'placeholder'=>Lang::get( 'zizpic-lang.full_name' )]) !!}
                </div>
                <div class="inptSec">
                    <label for="nm"><span class="lb_text">{{ Lang::get( 'zizpic-lang.address') }} 1 </span><span>*</span></label>
                    {!! Form::text('address', null, ['class'=>($errors->first('address'))?"error validate-input":"  validate-input", 'placeholder'=>Lang::get( 'zizpic-lang.address_placeholder' )]) !!}
                </div>
                <div class="inptSec">
                    <label for="nm"><span class="lb_text">{{ Lang::get( 'zizpic-lang.city') }}</span><span>*</span></label>
                    {!! Form::text('city', null, ['class'=>'', 'placeholder'=>Lang::get( 'zizpic-lang.city' )]) !!}

                </div>
                @if(isset($lang) && $lang=='en')
                <div class="inptSec">
                    <label for="nm"><span class="lb_text">{{ Lang::get( 'zizpic-lang.state') }}</span><span></span></label>
                    {!! Form::text('state', null, ['class'=>'', 'placeholder'=>Lang::get( 'zizpic-lang.state_placeholder' )]) !!}
                </div>
                @endif
                <div class="inptSec">
                    <label for="nm"><span class="lb_text">{{ Lang::get( 'zizpic-lang.zip') }}</span><span>*</span></label>
                    {!! Form::text('zip', null, ['class'=>'', 'placeholder'=>Lang::get( 'zizpic-lang.zip' )]) !!}
                </div>
                <div class="inptSec">
                    <label for="nm"><span class="lb_text">{{ Lang::get( 'zizpic-lang.country') }}</span><span>*</span></label>
                    {!! Form::text('country', null, ['class'=>'', 'placeholder'=>Lang::get( 'zizpic-lang.country' )]) !!}
                </div>
                <div class="inptSec">
                    <label for="nm"><span class="lb_text">{{ Lang::get( 'zizpic-lang.phone') }}#</span>
                        <span>*</span>
                    </label>
                    {!! Form::text('phone', null, ['class'=>($errors->first('phone'))?"error validate-input ":" validate-input", 'placeholder'=>Lang::get( 'zizpic-lang.phone' )]) !!}
                    <span class="note">{{ Lang::get( 'zizpic-lang.for_door_to_door_delivery_use_only' ) }}</span>
                </div>

                <div class="billing">
                    <h3><span>{{ Lang::get( 'zizpic-lang.billing') }}</span></h3>
                    <div class="billingCode">
                        <img src="{{ url('images/zc.png') }}" alt="" />
                        <div class="codeInputSec">

                            {!! Form::text('coupon_code', null, ['class'=>'', 'placeholder'=>Lang::get( 'zizpic-lang.zizcode' )]) !!}
                            {!! Form::hidden('zizcode', null, ['class'=>'form-control coupon_id']) !!}
                            <p><span class="coupon-msg"></span></p>
                            {!! Form::submit(Lang::get( 'zizpic-lang.submit' ), ['class'=>' btn btn-default coupon','id'=>'coupon_submit']) !!}
                        </div>
                    </div>
                    <div class="payment">
                        <h4>{{ Lang::get( 'zizpic-lang.payment') }}</h4>
                        <div class="payInfo whiteBG">
                            <span class="itemNm"> <span id="zizpic_item"> 3 </span> {{ Lang::get( 'zizpic-lang.zizpics') }}</span>
                            <span class="itemPrice price"> @if(isset($lang) && $lang=='he')  ₪ @endif  {{ $prices_details['package_3'] }} @if(isset($lang) && $lang=='en') $  @endif </span>
                            <input type="hidden" id="zizpic_1" value="{{ $prices_details['package_1'] }}">
                            <input type="hidden" id="zizpic_3" value="{{ $prices_details['package_3'] }}">
<!--                            <input type="hidden" id="zizpic_shipment" value="{{ $prices_details['shippment'] }}">-->
                        </div>
                        <div class="payInfo">
                            <span class="itemNm">{{ Lang::get( 'zizpic-lang.delivery') }}</span>
                            <span class="itemPrice pkg-price">{{ Lang::get( 'zizpic-lang.free') }}</span>
                        </div>
                        <div class="payInfo greenBG zc" style="display: none; ">
                            <span class="itemNm">{{ Lang::get( 'zizpic-lang.zc') }}</span>
                            <span class="itemPrice " id="zc_discount"></span>
                        </div>
                        <div class="payInfo total">
                            <span class="itemNm">{{ Lang::get( 'zizpic-lang.total') }}</span>
                            <span class="itemPrice total_amount"> @if(isset($lang) && $lang=='he')  ₪ @endif {{ $prices_details['package_3']}} @if(isset($lang) && $lang=='en') $  @endif</span>
                            <input type="hidden" name="amount" id='amount' value="{{ number_format($prices_details['package_3']) }}">
                            <input type="hidden" name="currency" value="{{$prices_details['currency']}}">

                        </div>

                    </div>

                </div>

                <div class="billingType">
                    <div class="bt">
                        <ul class="cards" id="visa">
                            <li><a href="javascript:void(0)"><img src="{{ url('images/ax.png') }}" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="{{ url('images/master.png') }}" alt="" /></a></li>
                            <li><a href="javascript:void(0)"><img src="{{ url('images/visa.png') }}"   alt="" /></a></li>
                        </ul>
                    </div>
                    <div class="bt by_paypal_payment">

                        <button class="btn btn-paypal by-paypal" id="by_paypal_payment"></button>
                    </div>
                    <div class="bt byPhone" id="by_phone">
                        <a href="javascript:void(0)" >{{ Lang::get( 'zizpic-lang.by_phone') }}</a>
                    </div>

                </div>
                <div class="ShowSec" id="by-phone">
                    <p class="leave_phn_num">Leave your phone number and we will call you for billing </p>
                    <ul>
                        <li>
                            {!! Form::text('phone_order', null, ['class'=>'phone_order ', 'placeholder'=>Lang::get( 'zizpic-lang.phone_number' )]) !!}
                            {!! Form::hidden('payment_method','',['id'=>'payment_method']) !!}
                        </li>
                        <li>
                            {!! Form::submit(Lang::get( 'zizpic-lang.submit_order' ), ['class'=>'btn btn-success','id'=>'form_submit']) !!}

                        </li>
                    </ul>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    @stop