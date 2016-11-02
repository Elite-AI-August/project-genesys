<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', isset($user->name)?$user->name:null, array('class' => 'form-control')) !!}
    <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
</div>

<div class="form-group">
    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email', isset($user->email)?$user->email:null, array('class' => 'form-control')) !!}
    <span class="label label-danger">{{ $errors->first('email', ':message') }}</span>
</div>

<div class="form-group">
    {!! Form::label('password', 'Password ') !!}
    {!! Form::password('password', array('class' => 'form-control')) !!}
    <span class="label label-danger">{{ $errors->first('password', ':message') }}</span>
</div>
<div class="form-group">
    {!! Form::label('password_confirmation', 'Validate Password') !!}
    {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
    <span class="label label-danger">{{ $errors->first('password_confirmation', ':message') }}</span>
</div>
<div class="form-group">
    {!! Form::label('roles', 'Role') !!}
    <select class="form-control" id="roles" name="roles[]">
        @foreach($roles as $key => $value)

        <option @if(isset($user_roles) && in_array($key, $user_roles))  selected='selected'  @endif value="{{$key}}">{{$value}}</option>
        }
        @endforeach
    </select>
    <span class="label label-danger">{{ $errors->first('roles', ':message') }}</span>
</div>
<!--<div class="form-group">
    {!! Form::label('image', 'Picture') !!}
    {!! Form::file('image', array('class' => 'form-control')) !!}
    <span class="label label-danger">{{ $errors->first('image', ':message') }}</span>
</div>-->

@if(count($data))
@foreach ( $data as $key => $customFieldData )
@if ( $key == 'select_box' )
@foreach ( $customFieldData as $key => $name )
<div class="form-group">
    {!! Form::label($name, str_replace('_'," ",$name)) !!}
    <select class="form-control"  name="{{str_replace(" ",'_',$name)}}" id="{{str_replace(" ",'_',$name)}}" >
        @foreach ( $data[ 'select' ][ $key ] as $select => $choice )
        <option value="{{$choice}}" @if(isset($custom_record[str_replace(' ',"_",$name)]) && $custom_record[str_replace(' ',"_",$name)] ==$choice) {{ 'selected' }} @endif  >{{ $choice }}</option>
        @endforeach
    </select>
</div>
@endforeach
@endif
@if ( $key == 'radio_box' )
@foreach ( $customFieldData as $key => $name )
<div class="form-group">
    {!! Form::label($name, str_replace('_'," ",$name)) !!}
    @foreach ( $data[ 'radio' ][ $key ] as $radio => $choice )
    <p>{{$choice}}
        {!! Form::radio($name, $choice) !!}
    </p>
    @endforeach
</div>
@endforeach
@endif

<!--@if ( $key === 'check_box' )
@foreach ( $customFieldData as $key => $name )
<div class="form-group">
    {!! Form::label($name, $name) !!}
    @foreach ( $data[ 'checkbox' ][ $key ] as $checkbox => $choice )
    <p>{{$choice}}
        {!! Form::checkbox($name.'[]', $choice,(isset($custom_record[$name]) && $custom_record[$name]==$name)?'checked':null ) !!}
    </p>
    @endforeach
</div>
@endforeach
@endif-->


@if ( $key == 'text_box' )
@foreach ( $customFieldData as $key => $name )
<div class="form-group">
    {!! Form::label($name, str_replace('_'," ",$name)) !!}
    @foreach ( $data[ 'text' ][ $key ] as $text => $choice )
    <p>
        {!! Form::text($name, (isset($custom_record[str_replace(' ',"_",$name)]))?$custom_record[str_replace(' ',"_",$name)]:'') !!}
    </p>
    @endforeach
</div>
@endforeach
@endif

@if ( $key == 'file_name' )
@foreach ( $customFieldData as $file => $name )
<div class="form-group">
    {!! Form::label($name, str_replace('_'," ",$name)) !!}
    {!! Form::file('file_name[]', array('class' => 'form-control')) !!}
</div>
@endforeach
@endif

@endforeach
@endif
