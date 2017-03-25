<div class="modal" id="upload-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Please Choose files to upload</h4>
            </div>
            <div class="modal-body" style="word-wrap: break-word;">
                <?php echo $__env->make('admin.media.upload-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php $__env->startPush('scripts-add_on'); ?>
<script>
    $(function () {
        var uploadModal = $('#upload-modal'),
            submitBtn = uploadModal.find('button[type=submit]'),
            modalTitle = uploadModal.find('.modal-title'),
            modalBody = uploadModal.find('.modal-body');

        uploadModal.on('shown.bs.modal', function (event) {
            var uploadTrigger = $(event.relatedTarget); // Button that triggered the modal
            $(this).modal('show');
        });
    });
</script>
<?php $__env->stopPush(); ?>