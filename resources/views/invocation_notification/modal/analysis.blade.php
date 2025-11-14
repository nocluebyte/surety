<div class="modal fade" id="analysisModal" tabindex="-1" role="dialog" aria-labelledby="analysisModal" aria-hidden="true">
    {!!Form::open(['route'=>['invocationActionplan',$invocationData->id],'method'=>'POST','id'=>'analysisForm'])!!}
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="analysisModalLabel">Analysis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!!Form::label('remark','Remark')!!}<i class="text-danger">*</i>
                    {!!Form::textarea('remark',null,['class'=>'form-control', 'id' => 'remark'])!!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>


