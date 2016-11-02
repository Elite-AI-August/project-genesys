<div class="modal fade" id="create-metric-modal" tabindex="-1 " role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            {!!
                Form::open([
                    'url' => route('packages.metrics.store'),
                    'class' => 'form-horizontal ajax-form-post clear-form',
                    'data-status-target' => '#metric-status',
                    'data-refresh-target' => '#metric-select'
                ])
            !!}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Create a Metric</h4>
            </div>

            <div class="modal-body">

                <div id="metric-status"></div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>

                    <div class="col-md-4">
                        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Kilometers']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Symbol</label>

                    <div class="col-md-4">
                        {!! Form::text('symbol', null, ['class'=>'form-control', 'placeholder'=>'Kms']) !!}
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

            {!! Form::close() !!}

        </div>

    </div>
</div>
