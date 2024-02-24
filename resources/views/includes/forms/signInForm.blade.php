<div class="container mt-2">
    <div class="row justify-content-center mt-lg-5 ">
        <div class="col-lg-8 col-md-7 col-10">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><i class="bi bi-check2-circle me-1"></i></strong> @lang('messages.user.sign_up_success')
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><i class="bi bi-check2-circle me-1"></i></strong> @lang('messages.user.sign_up_error')
                </div>
            @endif

            <div class="card shadow border-0 mt-lg-5">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-6">
                        @include('includes.svgs.signInSVG')
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body p-4 p-lg-5">
                            <h6 class="card-title text-center display-1 fs-2 signInHeader">@lang('messages.buttons.sign_in')</h6>
                            <form action="" method="post">
                                @csrf

                                <div class="mb-3">
                                    <input type="email" placeholder="@lang('messages.form_fields.email')" name="email"
                                        class="form-control shadow-sm"
                                        value="{{ session('user') ? $user->email : '' }}">

                                </div>
                                <div class="mb-3">
                                    <input type="password" placeholder="@lang('messages.form_fields.password')" name="password"
                                        class="form-control shadow-sm">
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger text-muted alert-warning alert-dismissible fade show m-3"
                                        role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>

                                        @foreach ($errors->all() as $error)
                                            <span><i class="bi bi-exclamation-circle mx-1"></i>
                                                {{ $error }}</span><br>
                                        @endforeach
                                    </div>
                                @endif

                                @if (session('alert'))
                                    <div class="alert text-muted alert-danger alert-dismissible fade show"
                                        role="alert">
                                        <i class="bi bi-exclamation-circle mx-1"></i>
                                        {{ __('messages.form_fields.incorrect_password') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif


                                <div class="container text-center">
                                    <button type="submit"
                                        class="btn btn-primary mt-3 shadow">@lang('messages.buttons.sign_in')</button>
                                </div>
                            </form>

                            <div class="container mt-3 text-center text-container">
                                <p class="text-muted">@lang('messages.auth.not_a_member')</p>
                                <a href="{{ route('signUp') }}">
                                    <button class="btn btn-sm btn-outline-primary shadow">@lang('messages.buttons.sign_up')</button>
                                </a>
                                <p class="fill-text">line css</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
