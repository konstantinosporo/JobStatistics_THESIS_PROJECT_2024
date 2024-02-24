<!-- resources/views/includes/delete_confirmation_modal.blade.php -->

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteConfirmationModalLabel{{ $jobDescription->id }}"><i
                    class="bi bi-exclamation-triangle-fill me-2 text-warning"></i>@lang('messages.admin.delete_title')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>@lang('messages.admin.are_you_sure')</p>
        </div>
        <div class="modal-footer">

            <form id="deleteForm{{ $jobDescription->id }}"
                action="{{ route('admin.jobs.delete', ['id' => $jobDescription->id]) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger"><i class="bi bi-trash me-1"></i>@lang('messages.buttons.delete')</button>
            </form>

            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i
                    class="bi bi-x-circle me-1"></i>@lang('messages.admin.cancel')</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('deleteForm{{ $jobDescription->id }}').addEventListener('submit', function(event) {
        // prevent default form submission
        event.preventDefault();

        // submit the form
        this.submit();
    });
</script>
