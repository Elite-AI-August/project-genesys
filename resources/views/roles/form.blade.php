<div class="form-group{{ $errors->first('name', ' has-error') }}">
    {!! Form::label('name', 'Name:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('name',null, ['class'=>'form-control', 'placeholder'=>'Name']) !!}
        <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
    </div>
</div>
<div class="form-group{{ $errors->first('slug', ' has-error') }}">
    {!! Form::label('slug', 'Slug:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('slug',null, ['class'=>'form-control', 'placeholder'=>'Slug']) !!}
        <span class="label label-danger">{{ $errors->first('slug', ':message') }}</span>
    </div>
</div>
<div class="form-group{{ $errors->first('description', ' has-error') }}">
    {!! Form::label('description', 'Description:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea('description',null, ['class'=>'form-control', 'placeholder'=>'Description']) !!}
        <span class="label label-danger">{{ $errors->first('description', ':message') }}</span>
    </div>
</div>
<div class="form-group{{ $errors->first('permissions', ' has-error') }}">
    @foreach ($permissions as $permission)
    <div class="col-md-3">
        {!! Form::checkbox('permission[]',$permission->id,in_array($permission->slug,$role_permissions)) !!}
        {{ $permission->name }}
    </div>
    @endforeach;
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
        <input type="button" class="btn btn-primary" value="Back" onclick="return window.history.back();">
    </div>
</div>
