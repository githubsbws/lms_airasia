{{-- =========================================================
| Login Modal: ฝั่ง User (หน้าบ้าน)
| ด้านบน = Google login (ปุ่มไว้ก่อน ยังไม่ต่อ backend จริง)
| ด้านล่าง = Login ปกติ (username/password)
========================================================== --}}
<style>
    .login-modal .modal-header {
        background: #111;
        color: #fff;
        border-bottom: none;
    }
    .login-modal .modal-title { font-weight: 700; }

    .login-modal .login-line {
        display: flex;
        align-items: center;
        text-align: center;
        margin-bottom: .6rem;
        color: #999;
    }
    .login-modal .login-line::before,
    .login-modal .login-line::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #ddd;
    }
    .login-modal .login-line span { padding: 0 .9rem; }

    .login-modal .btn-login-google {
        background: #dd4b39;
        border: 1px solid #d73925;
        color: #fff;
        font-weight: 600;
    }
    .login-modal .btn-login-google:hover,
    .login-modal .btn-login-google:focus { background: #c23321; color: #fff; }

    .login-modal .btn-login-outsider {
        background: #337ab7;
        border: 1px solid #2e6da4;
        color: #fff;
        font-weight: 600;
    }
    .login-modal .btn-login-outsider:hover,
    .login-modal .btn-login-outsider:focus { background: #286090; color: #fff; }

    .login-modal .modal-footer {
        background: #ddd;
        border-top: none;
        padding: 1rem 1.25rem;
    }
    .login-modal .btn-login-submit {
        background: #000;
        color: #fff;
        font-weight: 600;
        padding: .45rem 1rem;
    }
    .login-modal .btn-login-submit:hover,
    .login-modal .btn-login-submit:focus { background: #333; color: #fff; }
</style>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-modal">

            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">
                    <i class="bi bi-lock-fill me-1"></i> {{ __('auth.login') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-10">

                            @if ($errors->any())
                                <div class="alert alert-danger py-2">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="login-line">
                                <span>{{ __('auth.staff_section') }}</span>
                            </div>

                            {{-- Google Login (UI เฉยๆ ก่อน ยังไม่ผูก Socialite) --}}
                            <button type="button" id="customBtn" class="btn btn-login-google w-100 mb-4">
                                <i class="bi bi-google me-2"></i> {{ __('auth.staff_button') }}
                            </button>

                            <div class="login-line">
                                <span>{{ __('auth.outsider_section') }}</span>
                            </div>

                            {{-- toggle ทั้งฟอร์มและ footer พร้อมกัน --}}
                            <button type="button" class="btn btn-login-outsider w-100 mb-3"
                                    data-bs-toggle="collapse" data-bs-target=".outsider-collapse"
                                    aria-expanded="{{ $errors->any() ? 'true' : 'false' }}">
                                <i class="bi bi-person-fill me-2"></i> {{ __('auth.outsider_button') }}
                            </button>

                            <div class="collapse outsider-collapse {{ $errors->any() ? 'show' : '' }}">

                                <div class="mb-3">
                                    <label for="username" class="form-label">{{ __('auth.username') }}</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                           placeholder="{{ __('auth.username') }}"
                                           value="{{ old('username') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('auth.password') }}</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="{{ __('auth.password') }}" required>
                                </div>

                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    {{-- <div class="form-check mb-0">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">{{ __('auth.remember_me') }}</label>
                                    </div> --}}

                                    <div class="d-flex align-items-center gap-2">
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="small text-decoration-none">
                                                <i class="bi bi-person-plus-fill"></i> {{ __('auth.register') }}
                                            </a>
                                        @endif
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="btn btn-light btn-sm border">
                                                {{ __('auth.forgot_password') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- footer ซ่อนไว้ โผล่มาพร้อมฟอร์ม --}}
                <div class="collapse outsider-collapse {{ $errors->any() ? 'show' : '' }}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-login-submit">
                            {{ __('auth.submit') }}
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('loginModal')).show();
        });
    </script>
@endif

