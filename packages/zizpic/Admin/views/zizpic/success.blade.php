@extends('packages::layouts.front-end')
@section('content')
<div style="margin: 0 auto; margin-top: 100px">
    <center><p> {{ $msg }} </p> </center>
</div>
<script>
    setTimeout(function() {
        window.location.href = baseURL + '/zizpicorders';
    }, 5000);
</script>
@stop