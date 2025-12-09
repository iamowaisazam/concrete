@extends('web.partial.layout')

@section('hideNavbar', true)
@section('hideFooter', true)

@section('css')
    <style>
        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slideUp {
            animation: slideUpFade .9s ease-out forwards;
        }
    </style>
@endsection

@section('content')
    <!-- Minimal header (same as login/register) -->
    <header class="absolute inset-x-0 top-0 z-20">
        <div class="mx-auto px-8 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('public/theme/assets/web/images/nave-icon.png') }}" alt="AutoBoli" class="h-8 w-auto block">
            </a>

            <div class="flex items-center gap-3">
                <button data-theme-toggle
                    class="flex items-center justify-center p-2 rounded-full text-sm font-medium text-white dark:text-gray-900 bg-transparent transition"
                    aria-label="Toggle theme">
                    <span class="material-symbols-outlined text-xl" data-theme-icon>flare</span>
                </button>


                <a href="{{ url('/') }}"
                    class="text-white dark:text-gray-900 rounded-md px-2 lg:px-4 py-2 font-medium cursor-pointer transform text-sm border border-[#353F4C] dark:border-gray-300 hover:bg-[#0080ff] hover:border-[#0080ff] transition bg-transparent">
                    Back to Home
                </a>
            </div>
        </div>
    </header>

    <!-- Page -->
    <div
        class="relative min-h-screen flex items-center justify-center bg-[#000f21] dark:bg-gray-100 overflow-hidden pt-20 transition-colors">
        <!-- decorative bottom background (same motif as login) -->
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-[42%]">
            <div class="absolute right-0 bottom-0 w-[120%] h-full -skew-y-3 origin-bottom-right bg-[#0080ff]"></div>
            <div
                class="absolute right-0 bottom-0 w-[120%] h-full -skew-y-3 origin-bottom-right bg-[radial-gradient(#7b3fe6_1.2px,transparent_1.2px)] [background-size:16px_16px] opacity-30">
            </div>
        </div>

        <!-- Card -->
        <div class="container mx-auto px-4 py-12">
            <div class="mx-auto w-full max-w-lg">
                <div
                    class="rounded bg-[#0f1c2c] dark:bg-white shadow-2xl px-6 sm:px-10 md:px-12 py-10 relative z-10 animate-slideUp transition-colors">

                    <!-- Heading -->
                    <div class="text-center">
                        <h1 class="text-3xl font-bold mb-2 text-white dark:text-gray-900">Email Verification</h1>
                        <p class="text-white/70 dark:text-gray-600">Enter the 6-character code sent to your email.</p>
                    </div>

                    <!-- Alerts -->
                    <div id="alertContainer" class="mt-6"></div>

                    <!-- Form -->
                    <form id="verificationForm" class="mt-4 space-y-5">
                        <div>
                            <label for="token"
                                class="block text-xs font-semibold text-slate-200 dark:text-gray-700 mb-1">
                                Verification Code
                            </label>
                            <div class="relative">
                                <input id="token" name="token" maxlength="6" autocomplete="off" inputmode="latin"
                                    class="w-full rounded-lg border border-slate-300 dark:border-gray-300 bg-transparent dark:bg-gray-100 px-4 pr-28 py-3
                         text-white dark:text-gray-900 tracking-[0.35em] font-mono uppercase placeholder-white/40"
                                    placeholder="XXXXXX">
                                <button type="button" id="pasteBtn"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 rounded-md text-sm font-medium border
                               border-slate-500/50 text-white/90 hover:text-white bg-white/5 hover:bg-white/10
                               dark:text-gray-800 dark:bg-gray-100 dark:hover:bg-gray-200 dark:border-gray-300">
                                    Paste
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-white/60 dark:text-gray-500">Only letters and numbers.</p>
                        </div>

                        <button type="submit" id="submitBtn"
                            class="w-full rounded-lg bg-[#0080ff] hover:bg-[#0059B3] text-white font-semibold py-3 shadow-md transition inline-flex items-center justify-center gap-2">
                            <span id="submitText">Verify Email</span>
                            <svg id="submitSpinner" class="hidden animate-spin h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4A4 4 0 004 12z"></path>
                            </svg>
                        </button>
                    </form>

                    <!-- Resend -->
                    <div class="mt-6 text-center text-white/70 dark:text-gray-600">
                        Didn’t receive the code?
                        <a href="#" id="resendLink"
                            class="font-semibold text-[#66aaff] hover:text-white dark:text-[#0059B3] dark:hover:text-[#003f86] underline underline-offset-2">
                            Resend
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Tailwind-y alert
        function showAlert(message, type = 'info') {
            const colors = {
                success: 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30',
                danger: 'bg-rose-500/15 text-rose-300 border-rose-500/30',
                info: 'bg-blue-500/15 text-blue-300 border-blue-500/30'
            };
            const alert = document.createElement('div');
            alert.className =
                `flex items-start justify-between gap-3 rounded-lg border px-4 py-3 text-sm ${colors[type] ?? colors.info}`;
            alert.innerHTML = `
      <div class="pr-6">${message}</div>
      <button type="button" class="shrink-0 text-white/70 hover:text-white dark:text-gray-700" aria-label="Close">&times;</button>
    `;
            alert.querySelector('button').addEventListener('click', () => alert.remove());
            const wrap = document.getElementById('alertContainer');
            wrap.innerHTML = '';
            wrap.appendChild(alert);
        }

        const form = document.getElementById('verificationForm');
        const tokenInput = document.getElementById('token');
        const pasteBtn = document.getElementById('pasteBtn');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');
        const resendLink = document.getElementById('resendLink');

        const tokenPattern = /^[A-Z0-9]{6}$/;

        // Auto read clipboard on load (silent fail if blocked)
        window.addEventListener('load', async () => {
            try {
                const text = (await navigator.clipboard.readText() || '').trim();
                if (tokenPattern.test(text)) {
                    tokenInput.value = text.toUpperCase();
                    showAlert('Code automatically pasted from clipboard!', 'info');
                    setTimeout(() => form.dispatchEvent(new Event('submit')), 800);
                }
            } catch (_) {}
        });

        pasteBtn.addEventListener('click', async () => {
            try {
                const text = (await navigator.clipboard.readText() || '').trim();
                tokenInput.value = text.toUpperCase();
                showAlert('Code pasted successfully!', 'info');
            } catch (_) {
                showAlert('Unable to access clipboard. Please paste manually.', 'danger');
            }
        });

        tokenInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^a-z0-9]/gi, '').toUpperCase().slice(0, 6);
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const token = tokenInput.value.trim().toUpperCase();

            if (!tokenPattern.test(token)) {
                showAlert('Please enter a valid 6-character verification code.', 'danger');
                return;
            }

            submitBtn.disabled = true;
            submitSpinner.classList.remove('hidden');
            submitText.textContent = 'Verifying...';

            try {
                const res = await fetch("{{ route('verify.email.submit') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        token,
                        email: "{{ $email ?? '' }}"
                    })
                });

                const data = await res.json();
                if (data.success) {
                    showAlert(data.message || 'Email verified successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect_url || "{{ url('/login') }}";
                    }, 1200);
                } else {
                    showAlert(data.message || 'Invalid verification code.', 'danger');
                    submitBtn.disabled = false;
                    submitSpinner.classList.add('hidden');
                    submitText.textContent = 'Verify Email';
                }
            } catch (err) {
                showAlert('Something went wrong. Please try again.', 'danger');
                submitBtn.disabled = false;
                submitSpinner.classList.add('hidden');
                submitText.textContent = 'Verify Email';
            }
        });

        resendLink.addEventListener('click', async (e) => {
            e.preventDefault();
            submitBtn.disabled = true;
            submitSpinner.classList.remove('hidden');
            submitText.textContent = 'Sending...';

            try {
                const res = await fetch("{{ route('verify.email.resend') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: "{{ $email ?? '' }}"
                    })
                });
                const data = await res.json();
                if (data.success) {
                    showAlert(data.message || 'A new verification code has been sent!', 'success');
                } else {
                    showAlert(data.message || 'Failed to resend verification code.', 'danger');
                }
            } catch (_) {
                showAlert('Something went wrong. Please try again.', 'danger');
            } finally {
                submitBtn.disabled = false;
                submitSpinner.classList.add('hidden');
                submitText.textContent = 'Verify Email';
            }
        });
    </script>
@endsection
