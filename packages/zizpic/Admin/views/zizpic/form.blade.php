<fieldset>
    <div class="row">
        <div class="col-md-3">
            <img src="{{  url('assets/images/logo.jpg') }}" />
        </div>
        <div class="col-md-offset-1 col-md-4 text-center">
            <h2 class="no-margin" style="color:#291b23;">zizpic order</h2>
        </div>
    </div>

    <div class="row">
        Order: {{ Lang::get( 'zizpic-lang.order' ) }} {!! Form::radio('package',1, null) !!} 1
        {{ Lang::get( 'zizpic-lang.order' ) }} {!! Form::radio('package',3, null,['checked'=>'checked']) !!} 3
    </div>

    <div class="form-group">

        <h5 class="with-bg hidden-lg hidden-md hidden-sm">
            <span class="required">{{ Lang::get( 'zizpic-lang.zizpic' ) }} 1</span>
        </h5>
        <div class="col-sm-4 col-ziz zizpic_1">
            <h5 class='hidden-xs'>
                <span class="required">Zizpic 1</span>
            </h5>
            <div class='image-wrapper'>
                <input type="text" readonly="readonly" class="form-control upload-image" placeholder="{{ Lang::get( 'zizpic-lang.upload_image' ) }}" />

                <div class='error'>
                    Ziz image is mandatory
                </div>
                <input type="file" class="hide" name="zizpic_1_image" />
            </div>
            <h5>
                <span>3  {{ Lang::get( 'zizpic-lang.words_for_zizpic' ) }} 1</span>
            </h5>
            <input type="text" class="form-control" placeholder="Tune" name="zizpic_1_word_1" />
            <input type="text" class="form-control" placeholder="Look" name="zizpic_1_word_2" />
            <input type="text" class="form-control" placeholder="Activate" name="zizpic_1_word_3" />
        </div>
        <h5 class="with-bg hidden-lg hidden-md hidden-sm">
            <span class="required">{{ Lang::get( 'zizpic-lang.zizpic' ) }} 1</span>
        </h5>

        <div class="col-sm-4 col-ziz borders zizpic_2">
            <h5 class='hidden-xs'>
                <span class="required">{{ Lang::get( 'zizpic-lang.zizpic' ) }} 1</span>
            </h5>
            <div class='image-wrapper'>
                <input type="text" readonly="readonly" class="form-control upload-image" placeholder="{{ Lang::get( 'zizpic-lang.upload_image' ) }}" />
                <div class='error'>
                    Ziz image is mandatory
                </div>
                <input type="file" class="hide" name="zizpic_2_image" />
            </div>

            <h5>
                <span>3  {{ Lang::get( 'zizpic-lang.words_for_zizpic' ) }} 1</span>
            </h5>
            <input type="text" class="form-control" placeholder="Tune" name="zizpic_2_word_1" />
            <input type="text" class="form-control" placeholder="Look" name="zizpic_2_word_2" />
            <input type="text" class="form-control" placeholder="Activate" name="zizpic_2_word_3" />
        </div>
        <h5 class="with-bg hidden-lg hidden-md hidden-sm">
            <span class="required">{{ Lang::get( 'zizpic-lang.zizpic' ) }} 1</span>
        </h5>
        <div class='image-wrapper'>
            <input type="text" readonly="readonly" class="form-control upload-image" placeholder="{{ Lang::get( 'zizpic-lang.upload_image' ) }}" />
            <div class='error'>
                Ziz image is mandatory
            </div>
            <input type="file" class="hide" name="zizpic_3_image" />
        </div>
        <h5>
            <span>3  {{ Lang::get( 'zizpic-lang.words_for_zizpic' ) }} 1</span>
        </h5>
        <input type="text" class="form-control" placeholder="Tune" name="zizpic_3_word_1" />
        <input type="text" class="form-control" placeholder="Look" name="zizpic_3_word_2" />
        <input type="text" class="form-control" placeholder="Activate" name="zizpic_3_word_3" />
    </div>
    <div class="clearfix"></div>

    <div class="col-md-12 no-padding">
        <h5 class="with-bg" style="color: black;">
            <span>
                {{ Lang::get( 'zizpic-lang.zipic_artist_you' ) }}
            </span>
        </h5>
    </div>
    <div class="clearfix"></div>
    <div class="form-inline col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-4">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-md-2 col-sm-2 no-padding hidden-xs">
                    <label class="pull-right" for="exampleInputName2">
                        {!! Form::label('name', Lang::get( 'zizpic-lang.name' ),['class'=>'required']) !!}
                    </label>
                </div>
                <div class="col-md-10 col-md-10 no-padding">
                    <div class="pull-left input-holder required">
                        {!! Form::text('name',null, ['class'=>'form-control error', 'placeholder'=>'Name']) !!}
                        <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 no-padding">
        <h5 class="with-bg" style="color: black;">
            <span>{{ Lang::get( 'zizpic-lang.shipment_address' ) }}</span>
        </h5>
    </div>

</fieldset>

<fieldset>
    <center> <legend></legend> </center> </fieldset>

<div class="form-group{{ $errors->first('email', ' has-error') }}">
    {!! Form::label('email', Lang::get( 'zizpic-lang.email' ),['class'=>'col-sm-4 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.email' )]) !!}
        <span class="label label-danger">{{ $errors->first('email', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('full_name', ' has-error') }}">
    {!! Form::label('full_name', Lang::get( 'zizpic-lang.full_name' ),['class'=>'col-sm-4 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('full_name', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.full_name' )]) !!}
        <span class="label label-danger">{{ $errors->first('full_name', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('address', ' has-error') }}">
    {!! Form::label('address', Lang::get( 'zizpic-lang.address' ),['class'=>'col-sm-4 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('address', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.address' )]) !!}
        <span class="label label-danger">{{ $errors->first('address', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('city', ' has-error') }}">
    {!! Form::label('city', Lang::get( 'zizpic-lang.city' ),['class'=>'col-sm-4 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.city' )]) !!}
        <span class="label label-danger">{{ $errors->first('city', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('state', ' has-error') }}">
    {!! Form::label('state', Lang::get( 'zizpic-lang.state' ),['class'=>'col-sm-4 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('state', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.state' )]) !!}
        <span class="label label-danger">{{ $errors->first('state', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('zip', ' has-error') }}">
    {!! Form::label('zip', Lang::get( 'zizpic-lang.zip' ),['class'=>'col-sm-4 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('zip', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.zip' )]) !!}
        <span class="label label-danger">{{ $errors->first('zip', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('country', ' has-error') }}">
    {!! Form::label('country', Lang::get( 'zizpic-lang.country' ),['class'=>'col-sm-4 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('country', null, ['class'=>'form-control', 'placeholder'=>Lang::get( 'zizpic-lang.country' )]) !!}
        <span class="label label-danger">{{ $errors->first('country', ':message') }}</span>
    </div>
</div>
<div class="form-group{{ $errors->first('phone', ' has-error') }}">
    {!! Form::label('phone', Lang::get( 'zizpic-lang.phone' ).'#',['class'=>'col-sm-4 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('phone', null, ['class'=>'form-control ', 'placeholder'=>Lang::get( 'zizpic-lang.phone' )]) !!}
        <span class="label label-danger">{{ $errors->first('phone', ':message') }}</span>
    </div>
</div>
<center> <legend>{{ Lang::get( 'zizpic-lang.billing' ) }}</legend> </center> </fieldset>
<div class="form-group">
    {{ Lang::get( 'zizpic-lang.payment' ) }}
</div>
<div class="form-group">
    <div class="col-md-3">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>{{ Lang::get( 'zizpic-lang.zizpics' ) }}</td>
                    <td> ${{ $prices_details['package_1'] }} </td>
                </tr>
            </tbody>

            <tr>
                <td>{{ Lang::get( 'zizpic-lang.delivery' ) }}</td>
                <td> ${{ $prices_details['shippment'] }}  </td>
            </tr>

            <tbody>
                <tr>
                    <td>{{ Lang::get( 'zizpic-lang.total' ) }}</td>
                    <td> <span class="total_amount">${{ $prices_details['package_1']+$prices_details['shippment'] }}</span>
                        <input type="hidden" name="amount" id='amount' value="{{ number_format($prices_details['package_1']+$prices_details['shippment'], 2) }}">
                        <input type="hidden" name="currency" value="{{$prices_details['currency']}}">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <div class="col-md-6">
            {!! Form::text('coupon_code', null, ['class'=>'form-control ', 'placeholder'=>Lang::get( 'zizpic-lang.coupon' )]) !!}
            {!! Form::hidden('coupon', null, ['class'=>'form-control coupon_id', 'placeholder'=>Lang::get('zicpic-lang.coupon')]) !!}
            <span class="label label-danger">{{ $errors->first('coupon', ':message') }}</span>
        </div>
        <div class="col-md-6">
            {!! Form::button(Lang::get( 'zizpic-lang.submit' ), ['class'=>'form-control btn btn-default coupon']) !!}
            <span class="label label-danger coupon-msg"></span>
        </div>
    </div>
</div>

<div class="form-group">

    <div class="col-md-4">
        {!! Form::button(Lang::get( 'zizpic-lang.visa' ), ['class'=>'form-control btn btn-default']) !!}
    </div>
    <div class="col-md-4 by_paypal_payment">
        {!! Form::button(Lang::get( 'zizpic-lang.paypal' ), ['class'=>'form-control btn btn-primary by-paypal','value'=>'by paypal','id'=>'by_paypal_payment']) !!}
    </div>
    <div class="col-md-4">
        {!! Form::button(Lang::get( 'zizpic-lang.by_phone' ),  ['class'=>'form-control btn btn-info ','id'=>'by_phone']) !!}
    </div>

</div>
<div class="form-group" id="by-phone"  style="display: none">
    <div class="form-group">
        <center><h4>
                {{ Lang::get( 'zizpic-lang.leave_your_phone_number_and_we_will_call_you_for_billing' ) }}
            </h4> </center>
    </div>
    <div class="form-group"  >
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="col-md-6">
                {!! Form::text('phone_order', null, ['class'=>'form-control phone_order ', 'placeholder'=>Lang::get( 'zizpic-lang.phone_number' )]) !!}
                <span class="label label-danger">{{ $errors->first('phone_order', ':message') }}</span>
                {!! Form::hidden('payment_method','',['id'=>'payment_method']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::submit(Lang::get( 'zizpic-lang.submit' ), ['class'=>'form-control btn btn-success']) !!}
            </div>
        </div>
    </div>
</div>