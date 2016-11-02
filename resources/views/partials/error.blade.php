@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    @include('partials.sectionhead')
    <section class="content">
        <div class="error-page">
            <h2 style="margin: 0;" class="headline text-{{$color}}"> {{ $error_code }}</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-{{$color}}"></i> {{ $error_title }}</h3>
                <p>
                    {!! $error_message !!}
                </p>
            </div><!-- /.error-content -->
        </div>
    </section>
</div>
@stop



