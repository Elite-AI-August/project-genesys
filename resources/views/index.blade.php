<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/font.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
    
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/responsive.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
  </head>

  <body>
       
          <div class="container zpForm">
               <div class="row">
               	<div class="col-md-12">
                    	<div class="topHeader">
                              <a href="#" class="logo"><img src="images/logo.png" alt="" /></a>
                              <h2>zizpic order</h2>
                         </div>
                    </div>
               </div>
               <div class="row">
               	<div class="col-md-12">
                    	<div class="chooseOrder has-js">
                         	<span>Order:</span>
                              <label class="label_radio r_on" for="radio-01"><input name="sample-radio" id="radio-01" value="1" type="radio" checked="">1 zizpic</label>
                              <label class="label_radio" for="radio-02"><input name="sample-radio" id="radio-02" value="2" type="radio">3 zizpics</label>
                         </div>
                    </div>
               </div>
               <div class="row zizpic3">
               	<div class="col-md-4">
                    	<div class="upImg">
                         	<div class="upImgHD">Zizpic 1<span>*</span></div>
                              <div class="fileUpload">Upload Image</div>
                              <div class="threeWords">3 Words for zizpic 1 </div>
                              <input type="text" name="" value="" placeholder="Tune" />
                              <input type="text" name="" value="" placeholder="Look" />
                              <input type="text" name="" value="" placeholder="Activate" />
                         </div>
                    </div>
                    <div class="col-md-4">
                    	<div class="upImg">
                         	<div class="upImgHD">Zizpic 2<span>*</span></div>
                              <div class="fileUpload">Upload Image</div>
                              <div class="threeWords">3 Words for zizpic 1 </div>
                              <input type="text" name="" value="" placeholder="Tune" />
                              <input type="text" name="" value="" placeholder="Look" />
                              <input type="text" name="" value="" placeholder="Activate" />
                         </div>
                    </div>
                    <div class="col-md-4 bdr0">
                    	<div class="upImg">
                         	<div class="upImgHD">Zizpic 3<span>*</span></div>
                              <div class="fileUpload">Upload Image</div>
                              <div class="threeWords">3 Words for zizpic 3 </div>
                              <input type="text" name="" value="" placeholder="Tune" />
                              <input type="text" name="" value="" placeholder="Look" />
                              <input type="text" name="" value="" placeholder="Activate" />
                         </div>
                    </div>
               </div>
               <div class="row">
               	<div class="col-md-12 zizpicArtist">
                    	<h3><span>Zizpic Artist(You!)</span></h3>
                         <div class="inptSec">
                         	<label for="nm">Name<span>*</span></label>
                         	<input type="text" name="" value="" />
                         </div>
                    </div>
               </div>
               <div class="row">
               	<div class="zizpicArtist shipAddress">
                    	<h3><span>Shipment Address</span></h3>
                    	<div class="inptSec">
                         	<label for="nm">Email<span>*</span></label>
                         	<input type="text" name="" value="" />
                              <span class="note">To be used for reciept and shipment updates</span>
                         </div>
                         <div class="inptSec">
                         	<label for="nm">Full Name<span>*</span></label>
                         	<input type="text" name="" value="" />
                         </div>
                         <div class="inptSec">
                         	<label for="nm">Address 1<span>*</span></label>
                         	<input type="text" name="" value="" placeholder="Street address, P.O. box, apartment, suite, unit, building" />
                         </div>
                         <div class="inptSec">
                         	<label for="nm">City<span>*</span></label>
                         	<input type="text" name="" value="" />
                         </div>
                         <div class="inptSec">
                         	<label for="nm">State<span>*</span></label>
                         	<input type="text" name="" value="" placeholder="Province/Region" />
                         </div>
                         <div class="inptSec">
                         	<label for="nm">ZIP<span>*</span></label>
                         	<input type="text" class="mandotary" name="" value="" placeholder="This field is mandatory" />
                         </div>
                         <div class="inptSec">
                         	<label for="nm">Country<span>*</span></label>
                         	<input type="text" name="" value="" />
                         </div>
                         <div class="inptSec">
                         	<label for="nm">Phone#</label>
                         	<input type="text" name="" value="" />
                         </div>
                         
                         <div class="billing">
                              <h3><span>Billing</span></h3>
                              <div class="payment">
                              	<h4>Payment</h4>
                                   <div class="payInfo whiteBG">
                                   	<span class="itemNm">3 Zizpics</span>
                                        <span class="itemPrice">35$</span>
                                   </div>
                                   <div class="payInfo">
                                   	<span class="itemNm">Delivery</span>
                                        <span class="itemPrice">5$</span>
                                   </div>
                                   <div class="payInfo greenBG">
                                   	<span class="itemNm">ZC</span>
                                        <span class="itemPrice">-18$</span>
                                   </div>
                                   <div class="payInfo total">
                                   	<span class="itemNm">Total</span>
                                        <span class="itemPrice">22$</span>
                                   </div>
                                   
                              </div>
                              <div class="billingCode">
                              	<img src="images/zc.png" alt="" />
                                   <div class="codeInputSec">
                                   	<input type="text" name="" value="354d88" />
                                        <input type="submit" name="" value="Submit" />
                                   </div>
                              </div>
                              
                         </div>
                         
                         <div class="billingType">
                              	
                                   	<div class="bt">
                                        	<ul class="cards">
                                             	<li><a href="#"><img src="images/ax.png" alt="" /></a></li>
                                                  <li><a href="#"><img src="images/master.png" alt="" /></a></li>
                                                  <li><a href="#"><img src="images/visa.png" alt="" /></a></li>
                                             </ul>
                                        </div>
                                        <div class="bt">
                                        	<a href="#"><img src="images/paypal.png" alt="" /></a>
                                        </div>
                                        <div class="bt byPhone">
                                        	<a href="#">By Phone</a>
                                        </div>
                                   
                              </div>
                         
                    </div>
               </div>
               
          </div>


<script>
    function setupLabel() {
        if ($('.label_check input').length) {
            $('.label_check').each(function(){ 
                $(this).removeClass('c_on');
            });
            $('.label_check input:checked').each(function(){ 
                $(this).parent('label').addClass('c_on');
            });                
        };
        if ($('.label_radio input').length) {
            $('.label_radio').each(function(){ 
                $(this).removeClass('r_on');
            });
            $('.label_radio input:checked').each(function(){ 
                $(this).parent('label').addClass('r_on');
            });
        };
    };
    $(document).ready(function(){
        $('.label_check, .label_radio').click(function(){
            setupLabel();
        });
        setupLabel(); 
    });
</script>
  </body>
</html>
