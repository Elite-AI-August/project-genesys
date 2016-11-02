@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    @include('partials.sectionhead')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">

                        <table id="data-grid" class="results table table-hover" data-source="{{ url('/') }}" data-grid="main">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                    <th>Zizpic Status</th>
                                    <th>Paypal Status</th>
                                    <th>Transaction Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ( $results as $result )
                            <tr>
                                <td>
                                    {{ $result['transaction_id'] }}
                                </td>
                                <td>{{ $result['amount'] }}</td>
                                <td>
                                    {{ $result['currency'] }}
                                </td>
                                <td id="status"  >
                                    {{ $result['zizpic_status'] }}
                                </td>
                                <td >
                                    {{ ($result['status']=='Success' || $result['status']=='SuccessWithWarning')?"Ordered":$result['status'] }}
                                </td>
                                <td>
                                    {{ $result['date'] }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" aria-expanded="false">Change status <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="javascript:void(0)" onclick="changeStatus('Pending payment',{{ $result['id'] }})" >Pending payment</a></li>
                                            <li><a href="javascript:void(0)" onclick="changeStatus('Payment complete',{{ $result['id'] }})" >Payment complete</a></li>
                                            <li><a href="javascript:void(0)" onclick="changeStatus('Graphics',{{ $result['id'] }})" >Graphics</a></li>
                                            <li><a href="javascript:void(0)" onclick="changeStatus('Shipped',{{ $result['id'] }})" >Shipped</a></li>

                                            <li class="divider"></li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        <div class="col-md-12">
                            <div class="form-control"><b> Uploaded Image : </b></div>
                            @if(!empty( file_exists(ltrim($shiping_address[0][ 'zizpic_1_image' ],'/')) ) )

                            <!--$requested = __DIR__.'/public'.$uri;-->

                            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                                <a class="thumbnail" href="#">
                                    <img class="img-responsive" src="{{ $shiping_address[0][ 'zizpic_1_image' ] }}" alt=""  width="100%" height="100%" >
                                </a>
                                <div class="form-control"  style="height: auto" >
                                    <p>
                                        {{  (!empty( $shiping_address[0][ 'zizpic_1_word_1' ] ) ) ? $shiping_address[0][ 'zizpic_1_word_1' ]:''   }}

                                    </p>
                                    <p>
                                        {{  (!empty( $shiping_address[0][ 'zizpic_1_word_2' ] ) ) ? $shiping_address[0][ 'zizpic_1_word_2' ]:''   }}

                                    </p>
                                    <p>
                                        {{  (!empty( $shiping_address[0][ 'zizpic_1_word_3' ] ) ) ? $shiping_address[0][ 'zizpic_1_word_3' ]:''   }}

                                    </p>
                                </div>
                            </div>
                            @endif
                            @if(!empty( file_exists(ltrim($shiping_address[0][ 'zizpic_2_image' ],'/')) ) )


                            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                                <a class="thumbnail" href="#">
                                    <img class="img-responsive" src="{{ $shiping_address[0][ 'zizpic_2_image' ] }}" alt="">
                                </a>
                                <div class="form-control"  style="height: auto" >
                                    <p>
                                        {{  (!empty( $shiping_address[0][ 'zizpic_2_word_1' ] ) ) ? $shiping_address[0][ 'zizpic_2_word_1' ]:''   }}

                                    </p>
                                    <p>
                                        {{  (!empty( $shiping_address[0][ 'zizpic_2_word_2' ] ) ) ? $shiping_address[0][ 'zizpic_2_word_2' ]:''   }}

                                    </p>
                                    <p>
                                        {{  (!empty( $shiping_address[0][ 'zizpic_2_word_3' ] ) ) ? $shiping_address[0][ 'zizpic_2_word_3' ]:''   }}

                                    </p>
                                </div>
                            </div>
                            @endif
                            @if(!empty( file_exists(ltrim($shiping_address[0][ 'zizpic_3_image' ],'/')) ) )

                            <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                                <a class="thumbnail" href="#">
                                    <img class="img-responsive" src="{{ $shiping_address[0][ 'zizpic_3_image' ] }}" alt="" width="100%" height="100%">
                                </a>
                                <div class="form-control"  style="height: auto" >
                                    <p>
                                        {{  (!empty( $shiping_address[0][ 'zizpic_3_word_1' ] ) ) ? $shiping_address[0][ 'zizpic_3_word_1' ]:''   }}

                                    </p>
                                    <p>
                                        {{  (!empty( $shiping_address[0][ 'zizpic_3_word_2' ] ) ) ? $shiping_address[0][ 'zizpic_3_word_2' ]:''   }}

                                    </p>
                                    <p>
                                        {{  (!empty( $shiping_address[0][ 'zizpic_3_word_3' ] ) ) ? $shiping_address[0][ 'zizpic_3_word_3' ]:''   }}

                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-12 ">
                            <div class="form-control"><b> Shipping Address : </b></div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2" >
                                Full Name
                            </div>
                            <div class="col-md-2" >
                                {{  (!empty( $shiping_address[0][ 'full_name' ] ) ) ? $shiping_address[0][ 'full_name' ] : 'N/A' }}

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-2" >
                                Email
                            </div>
                            <div class="col-md-2" >
                                {{  (!empty( $shiping_address[0][ 'email' ] ) ) ? $shiping_address[0][ 'email' ] : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2" >
                                Phone
                            </div>
                            <div class="col-md-2" >
                                {{  (!empty( $shiping_address[0][ 'phone_order' ] ) ) ? $shiping_address[0][ 'phone_order' ] : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2" >
                                Address
                            </div>
                            <div class="col-md-2" >
                                {{  (!empty( $shiping_address[0][ 'address' ] ) ) ? $shiping_address[0][ 'address' ] : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2" >
                                City
                            </div>
                            <div class="col-md-2" >
                                {{  (!empty( $shiping_address[0][ 'city' ] ) ) ? $shiping_address[0][ 'city' ] : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2" >
                                Zip
                            </div>
                            <div class="col-md-2" >
                                {{  (!empty( $shiping_address[0][ 'zip' ] ) ) ? $shiping_address[0][ 'zip' ] : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2" >
                                State
                            </div>
                            <div class="col-md-2" >
                                {{  (!empty( $shiping_address[0][ 'state' ] ) ) ? $shiping_address[0][ 'state' ] : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2" >
                                Country
                            </div>
                            <div class="col-md-2" >
                                {{  (!empty( $shiping_address[0][ 'country' ] ) ) ? $shiping_address[0][ 'country' ] : 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
@stop