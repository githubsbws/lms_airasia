{{-- =========================================================
| Login Modal: ฝั่ง User (หน้าบ้าน)
| ด้านบน = Google login (ปุ่มไว้ก่อน ยังไม่ต่อ backend จริง)
| ด้านล่าง = Login ปกติ (username/password)
========================================================== --}}
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">{{ __('auth.login') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Google Login (UI เฉยๆ ก่อน ยังไม่ผูก Socialite) --}}
                <button type="button" class="btn btn-outline-dark w-100 d-flex align-items-center justify-content-center gap-2 mb-3" disabled>
                    <i class="bi bi-google"></i>
                    {{ __('auth.login_with_google') }}
                </button>

                <div class="d-flex align-items-center my-3">
                    <hr class="flex-grow-1">
                    <span class="px-2 text-muted small">{{ __('auth.or') }}</span>
                    <hr class="flex-grow-1">
                </div>

                {{-- Login ปกติ: username + password --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="username" class="form-label">{{ __('auth.username') }}</label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('auth.password') }}</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            required>
                    </div>

                    {{-- <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">{{ __('auth.remember_me') }}</label>
                    </div> --}}

                    <button type="submit" class="btn btn-danger w-100">
                        {{ __('auth.submit') }}
                    </button>

                </form>

            </div>

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

