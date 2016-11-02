@extends('maintenance::layouts.main')

@section('title', 'Dashboard')

@section('header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-body no-padding">

                    {!! HTML::script('assets/stevebauman/maintenance/js/calendar/full.js') !!}

                    <div id="calendar" data-event-url="{{ route('maintenance.api.calendar.events.index') }}" class="fc fc-ltr"></div>

                </div>
            </div>
        </div>
    </div>
@stop
