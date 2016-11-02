<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Zizpic | {{   isset($page_title)?$page_title:'Order' }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <!-- jQuery 2.1.4 -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
     <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap.css')}}" /> 
    <link rel="stylesheet" type="text/css" href="{{ url('css/font.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ url('css/font-awesome.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('css/responsive.css') }}" />
    <script src="{{ url('js/jquery.min.js') }} "></script>
    <script src="{{ url('js/bootstrap.min.js') }}" type="text/javascript"></script>
     @if(isset($lang) && $lang=='he')
   
     <style type="text/css">
        .inptSec label{ right:auto; left:364px; text-align:left; }
        .payment{ float:right;}
        .payInfo span{ float:right; }
        .payInfo span.itemPrice{ text-align:left;  width:43%;}
        .payInfo span { float: right; width: 57%;}
        .billing h4{ margin-left:0; margin-right:20px; }
        .codeInputSec input{ padding-left: 140px;  padding-right: 10px; text-align:right; }
        .codeInputSec input[type="submit"]{ right:auto; left:0; text-align:center; } 
        #zizpic_item {
          float: right;
          margin-right: -5px;
          padding-left: 5px;
          text-align: right;
          width: auto;
        }
        .logo {
          right: 30px !important;
        }
    </style>
        <link href="{{ url('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />
     <script type="text/javascript"> 
        var currency = "₪"; 
        var language = "he";
        var package_1 = {{ $prices_details['package_1'] }};
        var package_3 = {{ $prices_details['package_3'] }};
        var shipment = {{ $prices_details['shippment'] }};
        var gift = '{{ Lang::get('zizpic-lang.gift') }}';
        var free = '{{ Lang::get('zizpic-lang.free') }}';
    </script>    
    @else 
    <script type="text/javascript"> 
        var currency = "$"; 
        var language = "en";
        var package_1 = {{ $prices_details['package_1'] }};
        var package_3 = {{ $prices_details['package_3'] }};
        var shipment = {{ $prices_details['shippment'] }};
        var gift = "{{ Lang::get('zizpic-lang.gift') }}";
        var free = "{{ Lang::get('zizpic-lang.free') }}";
         
    </script>
    @endif
      
    </head>
