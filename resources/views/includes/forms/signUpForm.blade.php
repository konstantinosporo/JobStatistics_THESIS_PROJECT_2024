<div class="container mt-5">
  <div class="row justify-content-center mt-lg-5">
    <div class="col-lg-9 col-md-7 col-12">
      <div class="card shadow border-0 mt-lg-5">
        <div class="row d-flex justify-content-around align-content-around p-lg-3">
          <div class="col-lg-6">
            @include('includes.svgs.signUpSVG')
          </div>
          <div class="col-lg-5">
            <div class="card-body card m-3 p-3 shadow border-0">
              <h3 class="card-title text-center display-1 fs-3 mb-3">@lang('messages.auth.create_account')</h3>
              <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert"
                style="display: none;">
                @lang('messages.content.registration_successful')
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <form action="" method="post">
                @csrf <!-- Hidden input field containing the unique token of the signUp -->

                <input type="text" placeholder="@lang('messages.form_fields.username')" name="name" class="form-control mt-2">
                <input type="password" placeholder="@lang('messages.form_fields.password')" name="password" class="form-control mt-2">
                <input type="password" placeholder="@lang('messages.form_fields.confirm_password')" name="password_confirmation"
                  class="form-control mt-2">
                <input type="email" placeholder="@lang('messages.form_fields.email')" name="email" class="form-control mt-2">

                <div class="form-check mt-2 d-flex justify-content-between flex-wrap">
                  <div>
                    <input type="radio" id="admin" name="role" value="admin" class="form-check-input">
                    <label for="admin" class="form-check-label">@lang('messages.buttons.sign_up_admin')</label>
                  </div>
                  <div class="div">
                    <input type="radio" id="recruiter" name="role" value="recruiter" class="form-check-input">
                    <label for="recruiter" class="form-check-label">@lang('messages.buttons.sign_up_recruiter')</label>
                  </div>
                </div>

                @if ($errors->any())
                  <div class="alert alert-danger text-muted alert-warning alert-dismissible fade show m-3"
                    role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    @foreach ($errors->all() as $error)
                      <div><i class="bi bi-exclamation-circle"></i> {{ $error }}</div>
                    @endforeach
                  </div>
                @endif



                <div class="container text-center">
                  <button type="submit" class="btn btn-primary mt-3">@lang('messages.buttons.sign_up')</button>
                </div>
              </form>


              <div class="container mt-3 text-center text-container">
                <p class="text-muted">@lang('messages.auth.already_a_member')</p>
                <a href="{{ route('signIn') }}">
                  <button class="btn btn-sm btn-outline-primary shadow">@lang('messages.buttons.sign_in')</button>
                </a>
                <p class="fill-text">@lang('messages.misc.or')</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
