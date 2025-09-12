@php
    $settings = App\Models\Setting::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend.global.css_support', $settings)
    <style>
        .otp-input {
            font-size: 2rem;
            text-align: center;
            letter-spacing: 0.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            width: 100%;
            margin: 1rem 0;
        }

        .otp-input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .resend-btn {
            background: none;
            border: none;
            color: #3b82f6;
            text-decoration: underline;
            cursor: pointer;
        }

        .resend-btn:hover {
            color: #1d4ed8;
        }

        .resend-btn:disabled {
            color: #9ca3af;
            cursor: not-allowed;
        }

        .countdown {
            color: #ef4444;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light-gray" id="body">
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh">
        <div class="d-flex flex-column justify-content-between">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-10">
                    <div class="card card-default mb-0">
                        <div class="card-header pb-0"></div>
                        <div class="card-body px-5 pb-5 pt-0">

                            <h4 class="text-dark mb-6 text-center">
                                <i class="fas fa-shield-alt text-primary me-2"></i>
                                Email Verification
                            </h4>

                            <div class="text-center mb-4">
                                <p class="text-muted">
                                    We've sent a 6-digit verification code to:
                                </p>
                                <strong class="text-primary">{{ $email }}</strong>
                            </div>

                            {{-- Show session error message --}}
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                </div>
                            @endif

                            {{-- Show session success message --}}
                            @if (session('success'))
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Show validation errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="otpForm" method="POST" action="{{ route('verifyOtp') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="otp_code" class="form-label">Enter Verification Code</label>
                                        <input type="text" id="otp_code" name="otp_code"
                                            class="form-control otp-input @error('otp_code') is-invalid @enderror"
                                            maxlength="6" pattern="[0-9]{6}" placeholder="000000"
                                            value="{{ $otp ?? '' }}" required autocomplete="off">
                                        @error('otp_code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button id="verifyBtn" type="submit"
                                            class="btn btn-primary btn-block btn-pill mb-4">
                                            <i class="fas fa-check me-2"></i>
                                            <span id="verifyBtnText">Verify & Login</span>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <p class="text-muted mb-2">Didn't receive the code?</p>
                                <button type="button" class="resend-btn" id="resendBtn" onclick="resendOtp()">
                                    Resend OTP
                                </button>
                                <div id="countdown" class="mt-2"></div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('adminLogin') }}" class="text-muted">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Back to Login
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.global.js_support', $settings)

    <script>
        let countdownTimer;
        let timeLeft = 60; // 60 seconds cooldown for resend

        $(document).ready(function() {
            // Auto-focus on OTP input
            $('#otp_code').focus();

            // Only allow numbers in OTP input
            $('#otp_code').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Auto-submit when 6 digits are entered
            $('#otp_code').on('input', function() {
                if (this.value.length === 6) {
                    $('#otpForm').submit();
                }
            });

            // Auto-submit if OTP is pre-filled from URL
            @if ($otp)
                if ($('#otp_code').val().length === 6) {
                    // Show loading state
                    $('#verifyBtn').prop('disabled', true);
                    $('#verifyBtnText').text('Verifying...');

                    // Auto-submit after a short delay to show the loading state
                    setTimeout(function() {
                        $('#otpForm').submit();
                    }, 500);
                }
            @endif

            // Start countdown
            startCountdown();
        });

        function resendOtp() {
            if (timeLeft > 0) return;

            $('#resendBtn').prop('disabled', true);
            $('#resendBtn').text('Sending...');

            $.ajax({
                url: '{{ route('resendOtp') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: '{{ $email }}'
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('OTP sent successfully!', 'success');
                        timeLeft = 60;
                        startCountdown();
                    } else {
                        showAlert(response.message || 'Failed to send OTP', 'error');
                    }
                },
                error: function() {
                    showAlert('Failed to send OTP. Please try again.', 'error');
                },
                complete: function() {
                    $('#resendBtn').prop('disabled', false);
                    $('#resendBtn').text('Resend OTP');
                }
            });
        }

        function startCountdown() {
            timeLeft = 60;
            $('#resendBtn').prop('disabled', true);

            countdownTimer = setInterval(function() {
                timeLeft--;
                $('#countdown').html(`Resend available in <span class="countdown">${timeLeft}</span> seconds`);

                if (timeLeft <= 0) {
                    clearInterval(countdownTimer);
                    $('#resendBtn').prop('disabled', false);
                    $('#countdown').html('');
                }
            }, 1000);
        }

        function showAlert(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

            $('.card-body').prepend(alertHtml);

            // Auto-hide after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        }
    </script>
</body>

</html>
