var stock_list;
jQuery(function ($) {
    'use strict';
    var chosen = $('.chosen').chosen();
    var oTable = $('#stock-by-location').DataTable({
        dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>" +
                "<'row'<'col-xs-12't>>" +
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
        processing: true,
        serverSide: true,
        ajax: {
            url: baseURL + '/admin/inventory/locations/' + $('#location_id').val() + '/getStock',
            data: function (d) {
                d.inventory_id = $('select[name=inventory_id]').val();
            }
        },
        columns: [
            {data: 'name', name: 'name', 'title': 'Item'},
            {data: 'serial_no', name: 'serial_no', 'title': 'S/N'},
            {data: 'quantity', name: 'quantity', 'title': 'Quantity'},
            {data: 'action', name: 'action', 'title': 'Action', 'orderable': false},
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
            });
        }
    });
    $('#search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });
// Delete Function
    $('button .delete-Btn').click(function () {
        e.preventDefault;
        /*var currentForm = this;
         bootbox.confirm("Are you sure you want to delete?", function (result) {
         if (result) {
         currentForm.submit();
         }
         });*/
    });
    $('.preventSubmitOnEnter').on('keyup keypress', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });
    /*$('#addStock select[name="inventory"]').change(function () {
     if ($(this).val() != '') {
     if ($.fn.dataTable.isDataTable('#stock_list')) {
     stock_list.destroy();
     stock_list = $('#stock_list').DataTable({
     "ajax": baseURL + '/inventories/' + $(this).val() + '/get_stocks_for_transaction'
     });
     }
     else {
     stock_list = $('#stock_list').DataTable({
     "ajax": baseURL + '/inventories/' + $(this).val() + '/get_stocks_for_transaction'
     });
     }
     }
     });*/

    $('body').on('click', '.preventSubmit', function (e) {
        e.preventDefault;
        return false;
    });
    $('#addStock').on('shown.bs.modal', function () {
        $('.chosen', this).chosen('destroy').chosen();
    });
    $('#addStock select[name="inventory"]').change(function () {
        if ($(this).val() != '') {
            if ($.fn.dataTable.isDataTable('#stock_list_inventory')) {
                stock_list.destroy();
                stock_list = $('#stock_list_inventory').DataTable({
                    "ajax": baseURL + '/locations/' + $(this).val() + '/get_stocks_for_transaction_by_location'
                });
            }
            else {
                stock_list = $('#stock_list_inventory').DataTable({
                    "ajax": baseURL + '/locations/' + $(this).val() + '/get_stocks_for_transaction_by_location'
                });
            }
        }
    });

    $('body').on('click', '.preventSubmit', function (e) {
        e.preventDefault;
        return false;
    });

    $('body').on('click', '.addStockRecord', function (e) {
        e.preventDefault;
        var form = $('#location_transaction');
        form.attr('action', $('#updateStocks').val());
        $('<input/>').attr('type', 'hidden').attr('name', 'stock_id[]').addClass('stock_' + $(this).attr('data-stock-id')).val($(this).attr('data-stock-id')).appendTo(form);
        $('<input/>').attr('type', 'hidden').attr('name', 'stock_quantity[]').addClass('stock_' + $(this).attr('data-stock-id')).val($(this).attr('data-stock-quantity')).appendTo(form);
        $('<input/>').attr('type', 'hidden').attr('name', 'stock_serial[]').addClass('stock_' + $(this).attr('data-stock-id')).val($(this).attr('data-stock-serial_no')).appendTo(form);
        $('<input/>').attr('type', 'hidden').attr('name', 'stock_location_id[]').addClass('stock_' + $(this).attr('data-stock-id')).val($(this).attr('data-stock-location_id')).appendTo(form);
        $('<input/>').attr('type', 'hidden').attr('name', 'reason[]').addClass('stock_' + $(this).attr('data-stock-id')).val('').appendTo(form);

        form.submit();
    });

    $('body').on('click', '.deleteStockRecord', function (e) {
        e.preventDefault;
        var form = $('#location_transaction');
        form.attr('action', $('#updateStocks').val());
        form.find('.stock_' + $(this).attr('data-stock-id')).remove();
        form.submit();
    });
    /*$('.deletion-form').submit(function (e) {
     alert('submit');
     e.preventDefault;
     /*var currentForm = this;
     bootbox.confirm("Are you sure you want to delete?", function (result) {
     if (result) {
     currentForm.submit();
     }
     });
     });*/
    new Vue({
        el: '#inventory_form',
        data: {
            inventory: window.inventory,
            parts: window.parts,
            newPart: {
                part_id: '',
                part_quantity: '',
                part_name: ''
            },
            validation: {
                part_quantity: false
            }
        },
        ready: function () {
            if (this.inventory.is_assembly == 1) {
                inventory.$set('is_assembly', true);
            }
            else {
                inventory.$set('is_assembly', false);
            }
        },
        filters: {
            partQuantityValidator: {
                write: function (val) {
                    val = parseInt(val);
                    if (val > 0 && val != '') {
                        this.validation.part_quantity = true;
                    } else {
                        this.validation.part_quantity = false;
                    }
                    return val
                }
            }
        },
        // computed property for form validation state
        computed: {
            isValid: function () {
                var valid = true
                for (var key in this.validation) {
                    if (!this.validation[key]) {
                        valid = false;
                    }
                }
                return valid
            }
        },
        methods: {
            addPart: function (e) {
                e.preventDefault();
                console.log(this.inventory.is_assembly);
                if (this.isValid) {
                    this.newPart.part_id = $('#kit_create_chosen').val();
                    this.newPart.part_name = $('#kit_create_chosen option[value="' + $('#kit_create_chosen').val() + '"]').text();
                    this.parts.push(this.newPart);
                    this.newPart = {
                        part_id: '',
                        part_quantity: '',
                        part_name: ''
                    };
                    this.validation.part_quantity = false;
                } else {
                    console.log('validation error');
                }
            },
            removePart: function (part) {
                this.parts.$remove(part);
            }
        }
    });
    new Vue({
        el: '#inventory_kit_form',
        data: {
            inventory: window.inventory,
            parts: window.parts,
            newPart: {
                part_id: '',
                part_quantity: '',
                part_name: ''
            },
            validation: {
                part_id: false,
                part_quantity: false
            }
        },
        ready: function () {
            $('.kit-stocks-datatable').DataTable({
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'f>>r>" +
                        "<'row'<'col-xs-12't>>" +
                        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>"
            });
        },
        filters: {
            partQuantityValidator: {
                write: function (val) {
                    console.log('write');
                    val = parseInt(val);
                    var partQuantity = parseInt(this.part.pivot.quantity);
                    var stockQuantity = parseInt(this.stock.quantity);
                    var stockUsedQuantity = parseInt(this.stock.usedQuantity);
                    if (val > partQuantity) {
                        if (partQuantity >= stockQuantity + stockUsedQuantity) {
                            return stockQuantity + stockUsedQuantity;
                        }
                        return partQuantity;
                    } else if (stockQuantity == 0 && stockUsedQuantity > 0) {
                        if (val <= stockUsedQuantity) {
                            return val;
                        } else {
                            return stockUsedQuantity;
                        }
                    } else if (stockQuantity == stockUsedQuantity) {
                        if (val < stockUsedQuantity)
                            return val;
                        return stockUsedQuantity;
                    }
                    console.log(stockQuantity);
                    return parseInt(val);
                },
                read: function (val) {
                    console.log('read');

                    val = parseInt(val);
                    var total = 0;
                    this.usedQunaity = val;
                    $.each(this.part.stocks, function (k, v) {
                        total += parseInt(v.usedQuantity);
                    });
                    this.part.$set('usedQuantity', total);
                    this.part.missedQuantity = this.part.pivot.quantity - total;
                    return val;
                }
            }
        },
        // computed property for form validation state
        computed: {
        },
        methods: {
            addPart: function (e) {
                e.preventDefault();
                console.log(this.inventory.is_assembly);
                if (this.isValid) {
                    this.newPart.part_name = $("#part_id option[value='" + this.newPart.part_id + "']").text();
                    this.parts.push(this.newPart)
                    this.newPart = {
                        part_id: '',
                        part_quantity: '',
                        part_name: ''
                    }
                    this.validation.part_quantity = false;
                    this.validation.part_id = false;
                }
            },
            removePart: function (part) {
                this.parts.$remove(part);
            }
        }
    });
});
function recountTable(table) {
}
function getStockList(v, url)
{
    window.location = url + '/' + v;
}



$("#savestock").on('click', function (e) {

    e.preventDefault();
    var chk = 0;
    $.each($('input[name="quantity[]"]'), function () {
        var id = $(this).attr('id');
        console.log(id);
        var data = parseInt($(this).attr('data'));
        var qty = parseInt($(this).val());
        if (!$.isNumeric(qty))
        {
            chk = 1;
            $('#' + id).css('border', '1px solid red');
        }
        if (qty > data)
        {
            chk = 1;
            $('#' + id).css('border', '1px solid red');
        }

    });
    if (chk == 0)
    {
        $('#kitstock').submit();
    }

});

// Add transaction and move location

// Split Stocks

function splitStocks(stock_id)
{
    $('#splid_id_' + stock_id).show();
}

function createTrans(stock_id)
{
    $('#create_trans_' + stock_id).show();
}

$("#saveKitTransaction").on('click', function () {
    var error_msg;
    var data = $('#kitTransaction').serialize();
    //var state = $.trim($('.state_id').val());

    var chk = 0;
    var reason = 0;
    $.each($('select[name="state[]"]'), function () {
        if ($(this).val())
        {
            chk = 1;
        }

    });
    $.each($('textarea[name="name[]"]'), function () {
        if ($(this).val())
        {
            reason = 1;
        }

    });
    var quantity = $.trim($('#quantity').val());
    var name = $.trim($('#name').val());
    $('span.state').hide();
    $('span.quantity').hide();
    $('span.name').hide();
    if (chk == 0)
    {
        error_msg = 'Select State';
        $('span.state').html(error_msg).show();
        return false;
    }
    if (reason == 0)
    {
        error_msg = 'Enter reason';
        $('span.name').html(error_msg).show();
        return false;
    }
    if (quantity == '')
    {
        error_msg = 'Enter quantity';
        $('span.quantity').html(error_msg).show();
        return false;
    }

    $.ajax({
        url: "create",
        type: "get",
        data: data,
        success: function (response) {
            $('.close').click();
            bootbox.alert(response, function () {
                window.location.href = "";
            });
        }
    });
});

$("#saveKitTransactionKit").on('click', function () {
    var error_msg;
    var data = $('#kitTransaction').serialize();
    var state = $.trim($('#state').val());
    var quantity = $.trim($('#quantity').val());
    var name = $.trim($('#name').val());
    var kit_lists = $.trim($('#kit_lists').val());
    $('span.state').hide();
    $('span.quantity').hide();
    $('span.name').hide();
    $('span.kitname').hide();
    if (kit_lists == '')
    {
        error_msg = 'Select kit';
        $('span.kitname').html(error_msg).show();
        return false;
    }
    if (state == '')
    {
        error_msg = 'Select State';
        $('span.state').html(error_msg).show();
        return false;
    }
    if (name == '')
    {
        error_msg = 'Enter reason';
        $('span.name').html(error_msg).show();
        return false;
    }
    if (quantity == '')
    {
        error_msg = 'Enter quantity';
        $('span.quantity').html(error_msg).show();
        return false;
    }

    $.ajax({
        url: "inventories/create",
        type: "get",
        data: data,
        success: function (response) {
            $('.close').click();
            bootbox.alert(response, function () {
                window.location.href = "";
            });
        }
    });
});

$('.error').css('color', 'red');

$("#location_transaction").validate({
    rules: {
        name: {
        },
        no_of_boxes: {
            number: true
        },
        weight_of_shipment: {
            number: true

        },
    },
    // Specify the validation error messages
    messages: {
        name: {required: 'Please write comment'},
        no_of_boxes: {required: 'Enter no of boxes',
            number: 'Please enter only integer'},
        weight_of_shipment: {required: 'Enter weight of shipment',
            number: 'Please enter weight of shipment'},
    }
});

var qty = 0;
var arr = [];
var c = 0;
var chk = 0;
var total_kit_qty = 0;
$('input[type="checkbox"]').click(function (e) {
    var all_kit_qty = $('#total_kit_qty').val();

    var total = 0;
    $('input[name="inventory_id[]"]').each(function () {

        var id = $(this).attr('id');


        if ($('#' + id).is(":checked"))
        {
            $('#qty_' + id).attr("readonly", false);
            //   total_kit_qty = $('#qty_' + id).attr('max');
            chk = 1;
            c = $('#qty_' + id).val();
            total = total + parseInt(c);
            console.log(total + '--' + c);
        }
    });
    if (total > all_kit_qty)
    {
        //  e.preventDefault();
        $('#error_msg').html('<p style="padding:5px;">Total quantity should not exceed more than ' + all_kit_qty + '</p>').show();
    } else {
        $('#error_msg').hide();
    }
});

$('#field_type').change(function () {
    var v = $(this).val();
    console.log(v);
    $('.show_field').hide();
    $('.notice_msg').hide();
    $('#field_textarea').removeAttr('required');
    if (v == 'select' || v == 'multiple')
    {
        $('.show_field').show();
        $('#field_textarea').attr('required', 'required');
        $('.show_field').after('<p class="notice_msg" style="margin-left:100px" >Separate each choice with line break</p>');

    }
    if (v == 'radio')
    {
        $('.show_field').show();
        $('#field_textarea').attr('required', 'required');
        $('.show_field').after('<p class="notice_msg" style="margin-left:100px" >Separate each choice with line break</p>');
    }
    if (v == 'checkbox')
    {
        $('.show_field').show();
        $('#field_textarea').attr('required', 'required');
        $('.show_field').after('<p class="notice_msg" style="margin-left:100px" >Separate each choice with line break</p>');

    }
});

