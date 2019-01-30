<div class="modal fade" id="alert" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p style="font-size: 18px">Select at least one category.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<script>
    $('#alert').on('show.bs.modal', function (e) {
        console.log( $(e.relatedTarget));
        var message = $(e.relatedTarget).attr('data-message');
        $(this).find('.modal-body p').text(message);
    });
</script>