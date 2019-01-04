<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Parmanently</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure about this ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm">Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('#confirmDelete').on('show.bs.modal', function (e) {
        var message = $(e.relatedTarget).attr('data-message');
        $(this).find('.modal-body p').text(message);
        var title = $(e.relatedTarget).attr('data-title');
        $(this).find('.modal-title').text(title);

        var form = $(e.relatedTarget).attr('data-form');
        $(this).find('.modal-footer #confirm').data('form', form);
    });

    $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
        var form = "#"+$(this).data('form');
        $(form).submit();
    });
</script>