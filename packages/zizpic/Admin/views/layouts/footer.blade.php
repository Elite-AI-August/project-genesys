
<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
    var path;
    jQuery(document).ready(function($) {
        $('body').on('click', '.upload-image', function() {
            $(this).parent().find('input[type="file"]').click();
        });
    });
 
    function getImg(input, id)
    {
        if (input.files && input.files[0]) {
            console.log(/^image/.test(input.files[0].type));
            console.log(input.files[0].type);
            if (/^image/.test(input.files[0].type)) {
                var filerdr = new FileReader();
                filerdr.onload = function(e) {
                    $('#zizpic_img_' + id).addClass('zizpic_img');
                    $('#zizpic_img_' + id).attr('src', e.target.result).show();
                    $('.zizpic_1_error').hide();
                }
                var data = filerdr.readAsDataURL(input.files[0]);
            } else
            {
                $('#zizpic_img_' + id).hide();
                $('.zizpic_error_' + id).html('Upload valid image type').show();
            }
        }
    }




var invalid_coupon = "{{ Lang::get('zizpic-lang.invalid_coupon') }}";
var coupon_code_applied = "{{ Lang::get('zizpic-lang.coupon_code_applied')}}";
</script>
<script type="text/javascript">
    var baseURL = '{{ url(Request::segment(1)) }}';
</script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="{{ url('js/bootbox.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/custom-zizpic.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/icheck.js') }}" type="text/javascript"></script>
<script type="text/javascript">

    $('input[name="zizpackage2"]').iCheck({
        checkboxClass: 'icheckbox_polaris checked',
        radioClass: 'iradio_polaris checked',
        increaseArea: '20%'
    });
</script>

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
