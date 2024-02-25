<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="editJobModalLabel{{ $user->id }}">@lang('messages.admin_user_table.edit_rights')</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      @if (session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('admin.viewUsers.updateUser', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <label for="role">@lang('messages.admin_user_table.user_type')</label>
        <select name="role" id="role" class="form-select" required>
          <option value="user" @if ($user->role == 'user') selected @endif>@lang('messages.user.user')</option>
          <option value="admin" @if ($user->role == 'admin') selected @endif>@lang('messages.admin.admin')</option>
          <option value="recruiter" @if ($user->role == 'recruiter') selected @endif>@lang('messages.recruiter.recruiter')</option>
        </select>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>@lang('messages.admin_user_table.update_user_button')
          </button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
              class="bi bi-x-circle me-1"></i>@lang('messages.admin.cancel')
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
