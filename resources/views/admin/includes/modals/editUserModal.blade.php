<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editJobModalLabel{{ $user->id }}">Edit User Rights</h5>
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

                <label for="role">User Type:</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="user" @if ($user->role == 'user') selected @endif>User</option>
                    <option value="admin" @if ($user->role == 'admin') selected @endif>Admin</option>
                    <option value="recruiter" @if ($user->role == 'recruiter') selected @endif>Recruiter</option>
                </select>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
