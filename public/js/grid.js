var Grid;

;(function(window, document, $, undefined)
{

    'use strict';

    Grid = Grid || {
        Index: {}
    };

    // Initialize functions
    Grid.Index.init = function()
    {
        Grid.Index
            .listeners()
            .datePicker()
        ;
    };

    // Add Listeners
    Grid.Index.listeners = function()
    {
        $(document)
            .on('click', '[data-grid-row]', Grid.Index.checkRow)
            .on('click', '[data-grid-row] a', Grid.Index.titleClick)
            .on('click', '[data-grid-checkbox]', Grid.Index.checkboxes)
            .on('click', '[data-grid-calendar-preset]', Grid.Index.calendarPresets)
        ;

        return this;
    };

    // Date range picker initialization
    Grid.Index.datePicker = function()
    {
        var startDate, endDate, config, filter;

        var filters = _.compact(
            String(window.location.hash.slice(3)).split('/').splice(2)
        );

        config = {
            opens: 'left'
        };

        _.each(filters, function(route)
        {
            filter = route.split(':');

            if (filter[0] === 'created_at' && filter[1] !== undefined && filter[2] !== undefined)
            {
                startDate = moment(filter[1]);

                endDate = moment(filter[2]);
            }
        });

        if (startDate && endDate)
        {
            $('[data-grid-calendar]').val(
                startDate.format('MM/DD/YYYY') + ' - ' + endDate.format('MM/DD/YYYY')
            );

            config = {
                startDate: startDate,
                endDate: endDate,
                opens: 'left'
            };
        }

        $(document).on('click', '.range_inputs .applyBtn', function()
        {
            var start = $('input[name="daterangepicker_start"]');

            start.trigger('change');

            $('[data-grid-calendar]').val(
                moment(start.val()).format('MM/DD/YYYY') + ' - ' + moment($('input[name="daterangepicker_end"]').val()).format('MM/DD/YYYY')
            );
        });

        Grid.Index.datePicker = $('[data-grid-calendar]').daterangepicker(config, function(start, end, label)
        {
            $('input[name="daterangepicker_start"]').trigger('change');
        });

        $('.daterangepicker_start_input').attr('data-grid', $('[data-grid]').data('grid'));

        $('.daterangepicker_end_input').attr('data-grid', $('[data-grid]').data('grid'));

        $('input[name="daterangepicker_start"]')
            .attr('data-format', 'MM/DD/YYYY')
            .attr('data-range-start', '')
            .attr('data-range-filter', 'created_at')
        ;

        $('input[name="daterangepicker_end"]')
            .attr('data-format', 'MM/DD/YYYY')
            .attr('data-range-end', '')
            .attr('data-range-filter', 'created_at')
        ;

        return this;
    };

    // Handle Data Grid checkboxes
    Grid.Index.checkboxes = function(event)
    {
        event.stopPropagation();

        var type = $(this).attr('data-grid-checkbox');

        if (type === 'all')
        {
            $('[data-grid-checkbox]').not(this).not('[data-grid-checkbox][disabled]').prop('checked', this.checked);

            $('[data-grid-row]').not('[data-grid-row][disabled]').not(this).toggleClass('active', this.checked);
        }

        $(this).parents('[data-grid-row]').not('[data-grid-row][disabled]').toggleClass('active');

        Grid.Index.bulkStatus();
    };

    // Handle Data Grid row checking
    Grid.Index.checkRow = function()
    {
        if ($(this).find('[data-grid-checkbox]').prop('disabled')) return false;

        $(this).toggleClass('active');

        var checkbox = $(this).find('[data-grid-checkbox]');

        checkbox.prop('checked', ! checkbox.prop('checked'));

        Grid.Index.bulkStatus();
    };

    Grid.Index.bulkStatus = function()
    {
        var rows = $('[data-grid-checkbox]').not('[data-grid-checkbox="all"]').not('[data-grid-checkbox][disabled]').length;

        var checked = $('[data-grid-checkbox]:checked').not('[data-grid-checkbox="all"]').not('[data-grid-checkbox][disabled]').length;

        $('[data-grid-bulk-action]').closest('li').toggleClass('disabled', ! checked);

        if (checked > 0)
        {
            $('[data-grid-bulk-action="delete"]').attr('data-modal', true);
        }
        else
        {
            $('[data-grid-bulk-action="delete"]').removeAttr('data-modal');
        }

        $('[data-grid-checkbox="all"]')
            .prop('disabled', rows < 1)
            .prop('checked', rows < 1 ? false : rows === checked)
        ;

        return this;
    };

    Grid.Index.exporterStatus = function(grid)
    {
        $('[data-grid-exporter]').closest('li').toggleClass('disabled', grid.pagination.filtered == 0);

        return this;
    };

    // Handle Data Grid calendar
    Grid.Index.calendarPresets = function(event)
    {
        event.preventDefault();

        var start, end;

        switch ($(this).data('grid-calendar-preset'))
        {
            case 'day':
                start = end = moment().subtract(1, 'day').startOf('day').format('MM/DD/YYYY');
                break;

            case 'week':
                start = moment().startOf('week').format('MM/DD/YYYY');
                end   = moment().endOf('week').format('MM/DD/YYYY');
                break;

            case 'month':
                start = moment().startOf('month').format('MM/DD/YYYY');
                end   = moment().endOf('month').format('MM/DD/YYYY');
                break;

            default:
        }

        $('input[name="daterangepicker_start"]').val(start);

        $('input[name="daterangepicker_end"]').val(end);

        $('.range_inputs .applyBtn').trigger('click');
    };

    // Ignore row selection on title click
    Grid.Index.titleClick = function(event)
    {
        event.stopPropagation();
    };

    // Job done, lets run.
    Grid.Index.init();

})(window, document, jQuery);