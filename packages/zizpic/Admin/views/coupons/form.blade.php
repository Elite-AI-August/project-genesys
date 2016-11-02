<div class="form-group{{ $errors->first('name', ' has-error') }}">
    {!! Form::label('name', 'Name:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('name',null, ['class'=>'form-control', 'placeholder'=>'Name']) !!}
        <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('exp_date', ' has-error') }}">
    {!! Form::label('exp_date', 'Expiration Date:',['class'=>'col-sm-2 control-label','readonly'=>'readonly']) !!}
    <div class="col-md-4">
        {!! Form::text('exp_date', null, ['class'=>'form-control', 'placeholder'=>'Expiration date','id'=>'exp_date','readonly'=>'readonly']) !!}
        <span class="label label-danger">{{ $errors->first('exp_date', ':message') }}</span>
    </div>
</div>
<div class="form-group{{ $errors->first('used_limit', ' has-error') }}">
    {!! Form::label('usage_limit', 'Usage limit:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('used_limit', null, ['class'=>'form-control', 'placeholder'=>'Usage limit']) !!}
        <span class="label label-danger">{{ $errors->first('used_limit', ':message') }}</span>
    </div>
</div>
<div class="form-group{{ $errors->first('amount_usd', ' has-error') }}">
    {!! Form::label('amount_usd', 'Amount usd:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('amount_usd', null, ['class'=>'form-control', 'placeholder'=>'Amount usd']) !!}
        <span class="label label-danger">{{ $errors->first('amount_usd', ':message') }}</span>
    </div>
</div>
<div class="form-group{{ $errors->first('amount_nis', ' has-error') }}">
    {!! Form::label('amount_nis', 'Amount nis:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('amount_nis', null, ['class'=>'form-control', 'placeholder'=>'Amount nis']) !!}
        <span class="label label-danger">{{ $errors->first('amount_nis', ':message') }}</span>
    </div>
</div>
<div class="form-group{{ $errors->first('package', ' has-error') }}">
    {!! Form::label('package', 'Package:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::select('package',  $package,null, ['class'=>'form-control']) !!}
        <span class="label label-danger">{{ $errors->first('category_name', ':message') }}</span>
    </div>


</div>
@if(!isset($zizpicCoupons->id))

<div class="form-group{{ $errors->first('total_coupon', ' has-error') }}">
    {!! Form::label('total_coupon', 'Total Zizcode:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('total_coupon', null, ['class'=>'form-control', 'placeholder'=>'Total zizcode']) !!}
        <span class="label label-danger">{{ $errors->first('total_coupon', ':message') }}</span>
    </div>
</div>
@endif
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
        <input type="button" class="btn btn-primary" value="Back" onclick="return window.history.back();">
    </div>
</div>
