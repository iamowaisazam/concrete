@extends('web.partial.layout')

@section('hideNavbar', true)
@section('hideFooter', true)

@section('css')
    <style>
        /* Animations (minimal, necessary) */
        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(28px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .animate-slideUp {
            animation: slideUpFade .6s ease-out forwards
        }

        /* Progress shimmer */
        .progress-sheen {
            position: relative;
            isolation: isolate
        }

        .progress-sheen::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(255, 255, 255, .22) 40%, transparent 80%);
            transform: translateX(-100%);
            animation: sheenMove 2.2s linear infinite;
            pointer-events: none;
        }

        @keyframes sheenMove {
            to {
                transform: translateX(100%)
            }
        }

        /* Smooth color change (same idea as login) */
        html {
            transition: background-color .3s, color .3s
        }

        /* Ensure dropdown OPTION rows look correct in both themes */
        select option,
        select optgroup {
            background-color: #ffffff;
            /* light bg */
            color: #111827;
            /* slate-900-ish */
        }

        .dark select option,
        .dark select optgroup {
            background-color: #0f1c2c;
            /* your dark card bg */
            color: #f9fafb;
            /* near white text */
        }

        /* Respect reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .animate-slideUp {
                animation: none
            }

            .progress-sheen::after {
                animation: none
            }
        }

        .bg-black\/10 {
            background-color: #B2C0CE !important;
            color: white !important;
        }

        @media (prefers-color-scheme: dark) {
            .bg-black\/10 {
                background-color: #2C3E50 !important;
                /* Dark mode background */
            }
        }
    </style>
@endsection

@section('content')

    <header class="absolute inset-x-0 top-0 z-20">
        <div class="mx-auto px-6 md:px-8 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('public/theme/assets/web/images/nave-icon.png') }}" alt="AutoBoli" class="h-8 w-auto block">
            </a>
            <div class="flex items-center gap-3">
                <!-- Theme toggle button (same pattern as login) -->
                <button data-theme-toggle
                    class="flex items-center justify-center p-2 rounded-full text-sm font-medium text-gray-900 dark:text-white bg-transparent transition"
                    aria-label="Toggle theme">
                    <span class="material-symbols-outlined text-xl" data-theme-icon>flare</span>
                </button>

                <a href="{{ url('/') }}"
                    class="rounded-md px-2 lg:px-4 py-2 font-medium cursor-pointer transform text-sm  bg-[#0080ff] hover:bg-[#0080ff] text-white hover:border-[#0080ff] transition">
                    Back to Home
                </a>
            </div>
        </div>
    </header>

    <section class="min-h-screen w-full flex items-center justify-center md:pt-0 bg-[#f5f6f7] dark:bg-[#000f21]">

        <!-- decorative bottom background -->
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-[42%] overflow-hidden pt-20 transition-colors">
            <div class="absolute w-[100%] h-full -skew-y-3 origin-bottom-right bg-[#0080ff]"></div>
            <div
                class="absolute  w-[100%] h-full -skew-y-3 origin-bottom-right bg-[radial-gradient(#7b3fe6_1.2px,transparent_1.2px)] [background-size:16px_16px] opacity-30 ">
            </div>
        </div>

        {{-- LEFT: Content + Step Form --}}
        <div class="h-full w-full max-w-4xl mx-auto overflow-y-auto flex flex-col gap-6 lg:gap-10 p-6 md:p-10 lg:p-14 mt-5">
            {{-- Heading --}}
            <div class="mt-2">
                <h1
                    class="text-3xl md:text-4xl lg:text-5xl font-bold text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] text-center">
                    Create your Autoboli Account
                </h1>
                <p class="text-[#353F4C] dark:text-[var(--dark-text-secondary)]/80 text-base md:text-lg text-center ">
                    Built for dealers & traders — fast onboarding, powerful insights.
                </p>
            </div>

            {{-- Stepper --}}
            <div class="relative rounded-lg px-4 py-3 bg-white dark:bg-[var(--dark-theme-secondary)]">
                <ol class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <li class="pointer-events-none flex items-center gap-3 step-item step-active" data-step-li="1">
                        <span class="flex h-9 w-9 items-center justify-center rounded bg-[#0080ff] shadow">1</span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-black dark:text-white truncate">Company</p>
                            <p class="text-xs text-black/60 dark:text-white/60 truncate">Business details</p>
                        </div>
                    </li>
                    <li class="pointer-events-none flex items-center gap-3 step-item" data-step-li="2">
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded bg-black/10 dark:bg-white/10 text-black dark:text-white">2</span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-black dark:text-white truncate">User</p>
                            <p class="text-xs text-black/60 dark:text-white/60 truncate">Personal Info</p>
                        </div>
                    </li>
                    <li class="pointer-events-none flex items-center gap-3 step-item" data-step-li="3">
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded bg-black/10 dark:bg-white/10 text-black dark:text-white">3</span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-black dark:text-white truncate">Proofs</p>
                            <p class="text-xs text-black/60 dark:text-white/60 truncate">Docs</p>
                        </div>
                    </li>
                    <li class="pointer-events-none flex items-center gap-3 step-item" data-step-li="4">
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded bg-black/10 dark:bg-white/10 text-black dark:text-white">4</span>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-black dark:text-white truncate">Login Details</p>
                            <p class="text-xs text-black/60 dark:text-white/60 truncate">Email & password</p>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="-mt-4">
                <div class="h-2 rounded-full bg-[#B2C0CE] dark:bg-white/10 overflow-hidden">
                    <div id="progressBar"
                        class="h-full w-0 bg-gradient-to-r from-[#0080ff] to-[#46a1ff] progress-sheen transition-[width] duration-500 ease-out">
                    </div>
                </div>
                <div class="mt-2 flex items-center justify-end text-xs text-black/60 dark:text-white/60">
                    <span>Step <span id="progressText">1</span> of 4</span>
                </div>
            </div>

            {{-- Card --}}
            <div
                class="w-full max-w-5xl mx-auto rounded-lg -mt-4 bg-[var(--light-theme-primary)] dark:bg-[var(--dark-theme-secondary)] shadow-2xl p-5 md:p-8 animate-slideUp">
                <div id="stepHeader" class="mb-4">
                    <h2 class="text-2xl md:text-3xl font-semibold capitalize tracking-tight text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)]"
                        data-step-title>
                        Company information
                    </h2>
                    <p class="mt-1 text-sm text-black/70 dark:text-white/70" data-step-sub>
                        Provide your company details.
                    </p>
                </div>

                {{-- Inline error --}}
                <div id="inlineError"
                    class="hidden mt-3 rounded-md border border-red-500/30 bg-red-500/10 text-red-700 dark:text-red-200 p-3 text-sm my-2">
                </div>

                {{-- FORM --}}
                <form class="register-form" enctype="multipart/form-data" action="{{ url('/register_submit') }}"
                    method="POST" id="stepForm">
                    @csrf
                    <input type="hidden" name="payment_method" value="">

                    {{-- STEP 1 --}}
                    <div class="step-pane active space-y-6" data-step="1">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input name="companyName"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Company / Trading or Business Name"
                                value="{{ old('companyName', 'My Company') }}">

                            <input name="companyAddress1"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Company Address 1" value="{{ old('companyAddress1', 'Company Address 1') }}">


                            <div x-data="{ open: false, selected: 'Motor Dealer' }" class="relative"
                                :class="{ 'dark': window.matchMedia('(prefers-color-scheme: light)').matches }">

                                <!-- Hidden input for form submission -->
                                <input type="hidden" name="businessType" :value="selected">

                                <!-- Dropdown Button -->
                                <div @click="open = !open"
                                    class="cursor-pointer w-full flex justify-between items-center bg-white dark:bg-[#0F1C2C] text-gray-900 dark:text-white px-4 py-3 rounded-md border border-gray-300 dark:border-gray-600 shadow-sm hover:shadow-md transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span x-text="selected"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 ml-2 transition-transform duration-200"
                                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.outside="open = false" x-transition
                                    class="absolute z-40 mt-2 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg overflow-hidden">
                                    <ul class="py-1">
                                        <li @click="selected = 'Motor Dealer'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition dark:text-white">
                                            Motor Dealer</li>
                                        <li @click="selected = 'Motor Trader'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition dark:text-white">
                                            Motor Trader</li>
                                        <li @click="selected = 'Independent Dealer'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition dark:text-white">
                                            Independent Dealer</li>
                                        <li @click="selected = 'Other'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition dark:text-white">
                                            Other</li>
                                    </ul>
                                </div>
                            </div>
                            <input name="companyAddress2"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Company Address 2 (Optional)"
                                value="{{ old('companyAddress2', 'Company Address 2') }}">

                            <input name="companyReg"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Company Reg. Number (Optional)"
                                value="{{ old('companyReg', 'Company Reg. Number') }}">

                            <input name="townCity"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25 dark:text-white"
                                placeholder="Town / City" value="{{ old('townCity', 'Town / City') }}">

                            <input name="website" type="url"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Website (Optional)" value="{{ old('website', 'https://autodroid.co.uk/') }}">

                            <input name="country"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Country" value="{{ old('country', 'Country') }}">

                            <input name="businessEmail" type="email"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Business Email (Optional)"
                                value="{{ old('businessEmail', 'business@gmail.com') }}">

                            <input name="postcode"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Postcode / Zip code" value="{{ old('postcode', '123') }}">

                            <!-- Motor Trade Insurance -->
                            <div x-data="{ open: false, selected: 'Yes' }" class="relative">
                                <input type="hidden" name="motorTradeInsurance" :value="selected">

                                <!-- Dropdown Button -->
                                <div @click="open = !open"
                                    class="cursor-pointer w-full flex justify-between items-center bg-white dark:bg-[#0F1C2C] text-gray-900 dark:text-white px-4 py-3 rounded-md border border-black/20 dark:border-white/20 shadow-sm hover:shadow-md transition focus:outline-none focus:ring-2 focus:ring-[#0080ff] focus:ring-opacity-50">
                                    <span x-text="selected || 'Motor Trade Insurance?'"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 ml-2 transition-transform duration-200"
                                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.outside="open = false" x-transition
                                    class="absolute z-40 mt-2 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg overflow-hidden">
                                    <ul class="py-1 text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)]">
                                        <li @click="selected = 'Yes'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Motor Trade Insurance?</li>
                                        <li @click="selected = 'Yes'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Yes</li>
                                        <li @click="selected = 'No'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            No</li>
                                        <li @click="selected = 'Pending'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Pending</li>
                                    </ul>
                                </div>
                            </div>


                            <input name="telephone" type="tel"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Telephone" value="{{ old('telephone', '03112239342') }}">

                            <input name="vatNumber"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="VAT Number (if applicable)" value="{{ old('vatNumber', '123') }}">
                        </div>
                    </div>

                    {{-- STEP 2 --}}
                    <div class="step-pane hidden space-y-6" data-step="2">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input name="firstName"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="First Name" value="{{ old('firstName', 'Owais') }}">

                            <input name="surname"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Surname" value="{{ old('surname', 'Azam') }}">

                            <!-- Referral Source -->
                            <div x-data="{ open: false, selected: '' }" class="relative overflow-visible">
                                <input type="hidden" name="ReferralSource" :value="selected">

                                <!-- Dropdown Button -->
                                <div @click="open = !open"
                                    class="cursor-pointer w-full flex justify-between items-center bg-white dark:bg-[#0F1C2C] text-gray-900 dark:text-white px-4 py-3 rounded-md border border-black/20 dark:border-white/20 shadow-sm hover:shadow-md transition focus:outline-none focus:ring-2 focus:ring-[#0080ff] focus:ring-opacity-50">
                                    <span x-text="selected || 'Referral Source?'"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 ml-2 transition-transform duration-200"
                                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.outside="open = false" x-transition
                                    class="absolute z-40 mt-2 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg overflow-hidden">
                                    <ul class="py-1 text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)]">
                                        <li @click="selected = 'Google Search'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Google Search</li>
                                        <li @click="selected = 'Social Media'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Social Media</li>
                                        <li @click="selected = 'Online Advertisement'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Online Advertisement</li>
                                        <li @click="selected = 'Friend / Colleague '; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Friend / Colleague</li>
                                        <li @click="selected = 'Dealership Partner'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Dealership Partner</li>
                                        <li @click="selected = 'Trade Event or Expo'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Trade Event or Expo</li>
                                        <li @click="selected = 'Vehicle Trader Forum'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Vehicle Trader Forum</li>
                                        <li @click="selected = 'Other'; open = false"
                                            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-blue-700 transition">
                                            Other</li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <div class="flex rounded-lg overflow-hidden border border-black/20 dark:border-white/20">
                                    <select
                                        class="bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-3 py-3">
                                        <option value="+44">+44</option>
                                        <option value="+1">+1</option>
                                        <option value="+92" selected>+92</option>
                                        <option value="+61">+61</option>
                                    </select>
                                    <input name="phone" type="tel"
                                        class="flex-1 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 focus:outline-none"
                                        placeholder="Phone Number" value="{{ old('phone', '03112239342') }}">
                                </div>
                                <small class="error error-phone text-red-500"></small>
                            </div>

                            <input name="title"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Position" value="{{ old('position', 'Owais Azam') }}">
                        </div>

                        {{-- Profile Image --}}
                        <div>
                            <label class="block text-sm text-black/80 dark:text-white/80 mb-1">Profile Image <span
                                    class="text-red-500">*</span></label>
                            <label
                                class="inline-flex items-center justify-center rounded-lg border border-dashed border-black/25 dark:border-white/25 px-4 py-3 text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] hover:bg-black/5 dark:hover:bg-white/5 cursor-pointer transition">
                                Select file (Max. 4MB)
                                <input name="avatar" type="file" class="fileName" accept=".jpg,.jpeg,.png,.pdf"
                                    hidden>
                            </label>
                            <div class="mt-2 text-sm text-black/60 dark:text-white/60" data-file="avatar">No file chosen.
                            </div>
                            <small class="error error-avatar text-red-500"></small>
                            <small class="block text-xs mt-1 text-black/50 dark:text-white/50">Accepted: .jpg, .png or
                                .pdf</small>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $id }}">

                    {{-- STEP 3 --}}
                    <div class="step-pane hidden space-y-6" data-step="3">
                        <h3
                            class="text-lg font-semibold text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)]">
                            Proof Documents</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm text-black/80 dark:text-white/80 mb-1">
                                    Proof of motor trade <span class="text-red-500">*</span>
                                </label>
                                <label
                                    class="inline-flex items-center justify-center rounded-lg border border-dashed border-black/25 dark:border-white/25 px-4 py-3 text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] hover:bg-black/5 dark:hover:bg-white/5 cursor-pointer transition">
                                    Select file (Max. 4MB)
                                    <input name="proof_motor_trade" type="file" class="fileName"
                                        accept=".jpg,.jpeg,.png,.pdf" hidden>
                                </label>
                                <div class="mt-2 text-sm text-black/60 dark:text-white/60" data-file="proof_motor_trade">
                                    No file chosen.</div>
                                <small class="error error-proof_motor_trade text-red-500"></small>
                                <small class="block text-xs mt-1 text-black/50 dark:text-white/50">Accepted: .jpg, .png,
                                    .pdf</small>
                            </div>

                            <div>
                                <label class="block text-sm text-black/80 dark:text-white/80 mb-1">
                                    Proof of address <span class="text-red-500">*</span>
                                </label>
                                <label
                                    class="inline-flex items-center justify-center rounded-lg border border-dashed border-black/25 dark:border-white/25 px-4 py-3 text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] hover:bg-black/5 dark:hover:bg-white/5 cursor-pointer transition">
                                    Select file (Max. 4MB)
                                    <input name="proof_address" type="file" class="fileName"
                                        accept=".jpg,.jpeg,.png,.pdf" hidden>
                                </label>
                                <div class="mt-2 text-sm text-black/60 dark:text-white/60" data-file="proof_address">No
                                    file chosen.</div>
                                <small class="error error-proof_address text-red-500"></small>
                                <small class="block text-xs mt-1 text-black/50 dark:text-white/50">Accepted: .jpg, .png,
                                    .pdf</small>
                            </div>
                        </div>
                    </div>

                    {{-- STEP 4 --}}
                    <div class="step-pane hidden space-y-6" data-step="4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="email" name="personalEmail"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Personal / Login Email"
                                value="{{ old('personalEmail', 'iamowaisazam@gmail1.com') }}">

                            <input type="password" name="password"
                                class="w-full rounded border border-black/20 dark:border-white/20 bg-transparent text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] px-4 py-3 placeholder-black/50 dark:placeholder-white/50 focus:outline-none focus:border-[#0080ff] focus:ring-4 focus:ring-[#0080ff]/25"
                                placeholder="Password" value="{{ old('password', 'owais123') }}">
                        </div>

                        <p class="text-xs text-black/60 dark:text-white/60">
                            By submitting this form, you agree to the
                            <a href="/autoboli/terms" target="_blank" class="underline text-[#0080ff]">Terms &
                                Conditions</a>
                            and
                            <a href="/autoboli/privacy" target="_blank" class="underline text-[#0080ff]">Privacy
                                Policy</a>.
                        </p>
                    </div>

                    <div class="w-full flex items-center justify-between">
                        <div>
                            <p class="mt-6 text-center text-black/70 dark:text-white/80">
                                Already have an account?
                                <a href="{{ url('/login') }}" class="font-semibold text-[#0080ff] hover:underline">Log
                                    in</a>
                            </p>
                        </div>
                        {{-- NAV BUTTONS --}}
                        <div class="mt-8 flex flex-wrap items-center gap-3">
                            <button type="button"
                                class="inline-flex items-center gap-2 rounded px-4 py-2 border border-black/15 dark:border-white/15 bg-black/5 dark:bg-white/10 text-[var(--light-text-primary)] dark:text-[var(--dark-text-primary)] hover:bg-black/10 dark:hover:bg-white/15 transition"
                                id="prevStep">
                                <span class="material-symbols-outlined">arrow_back</span> Back
                            </button>

                            <button type="button"
                                class="inline-flex items-center gap-2 rounded px-4 py-2 bg-[#0080ff] text-white hover:brightness-110 transition"
                                id="nextStep">
                                <span class="material-symbols-outlined">arrow_forward</span> Next step
                            </button>

                            <button type="submit"
                                class="hidden inline-flex items-center gap-2 rounded px-4 py-2 bg-[#0080ff] text-white hover:brightness-110 transition"
                                id="submitBtn">
                                <span class="material-symbols-outlined">check_circle</span> Submit Application
                            </button>
                        </div>
                    </div>
                </form>


            </div>
        </div>

    </section>

@endsection

@section('js')
    <script>
        // ------- Elements -------
        const panes = [...document.querySelectorAll('.step-pane')];
        const nextBtn = document.getElementById('nextStep');
        const prevBtn = document.getElementById('prevStep');
        const submitBtn = document.getElementById('submitBtn');
        const inlineError = document.getElementById('inlineError');
        const stepLis = [...document.querySelectorAll('[data-step-li]')];
        const headerTitle = document.querySelector('[data-step-title]');
        const headerSub = document.querySelector('[data-step-sub]');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        const meta = {
            1: {
                title: 'Company information',
                sub: 'Provide your company details.'
            },
            2: {
                title: 'User information & avatar',
                sub: 'Add your personal details and profile image.'
            },
            3: {
                title: 'Proof documents',
                sub: 'Upload required proof documents.'
            },
            4: {
                title: 'Security',
                sub: 'Set your login email & password.'
            },
        };

        let currentStep = 1;
        const totalSteps = 4;

        // ------- Helpers -------
        function setProgress() {
            const pct = ((currentStep - 1) / (totalSteps - 1)) * 100;
            progressBar.style.width = pct + '%';
            if (progressText) progressText.textContent = currentStep;
        }

        function switchPane(next) {
            const cur = panes.find(p => Number(p.dataset.step) === currentStep);
            const nxt = panes.find(p => Number(p.dataset.step) === next);
            if (!cur || !nxt) return;
            cur.classList.add('hidden');
            nxt.classList.remove('hidden');
        }

        function updateStepperUI() {
            stepLis.forEach(li => {
                const n = Number(li.dataset.stepLi);
                const badge = li.querySelector('span');

                if (badge) {
                    // Reset badge
                    badge.classList.remove('text-[#0080ff]', 'bg-[#0080ff]', 'shadow', 'bg-[#0F1C2C]');
                    badge.classList.add('bg-black/10', 'dark:bg-white/10', 'text-[#0080ff]', 'dark:text-white');
                }

                if (n < currentStep) {
                    if (badge) {
                        badge.classList.remove('bg-black/10', 'dark:bg-white/10', 'text-[#0080ff]',
                            'dark:text-white');
                        badge.classList.add('bg-[#0F1C2C]', 'text-white');
                    }
                }
                if (n === currentStep) {
                    if (badge) {
                        badge.classList.remove('bg-black/10', 'dark:bg-white/10', 'text-black', 'dark:text-white',
                            'bg-neutral-500');
                        badge.classList.add('bg-[#0080ff]', 'text-white', 'shadow');
                    }
                }
                li.setAttribute('aria-current', n === currentStep ? 'step' : 'false');
            });
        }

        function updateHeader() {
            headerTitle.textContent = meta[currentStep].title;
            if (headerSub) headerSub.textContent = meta[currentStep].sub;
        }

        function updateButtons() {
            prevBtn.classList.toggle('opacity-60', currentStep === 1);
            prevBtn.classList.toggle('pointer-events-none', currentStep === 1);
            nextBtn.classList.toggle('hidden', currentStep === totalSteps);
            submitBtn.classList.toggle('hidden', currentStep !== totalSteps);
        }

        function showInlineError(msg) {
            inlineError.textContent = msg || 'Please check the required fields.';
            inlineError.classList.remove('hidden');
        }

        function clearInlineError() {
            inlineError.classList.add('hidden');
            inlineError.textContent = '';
        }

        // File rules
        const FILE_MAX = 4 * 1024 * 1024;
        const FILE_TYPES = ['image/jpeg', 'image/png', 'application/pdf'];

        function validFile(input, required = false) {
            const has = input.files && input.files.length;
            if (!has) return !required ? true : (showInlineError('Please select required file.'), false);
            const f = input.files[0];
            if (f.size > FILE_MAX) {
                showInlineError('Selected file is larger than 4MB.');
                return false;
            }
            if (!FILE_TYPES.includes(f.type)) {
                showInlineError('Invalid file type. Use JPG, PNG or PDF.');
                return false;
            }
            return true;
        }

        function validateStep() {
            const required = {
                1: ['companyName', 'companyAddress1', 'businessType', 'townCity', 'country', 'postcode'],
                2: ['firstName', 'surname', 'title', 'phone', 'avatar'],
                3: ['proof_motor_trade', 'proof_address'],
                4: ['personalEmail', 'password'],
            } [currentStep] || [];

            for (const name of required) {
                const el = document.querySelector(`[name="${name}"]`);
                if (!el) continue;

                if (el.type === 'file') {
                    if (!validFile(el, true)) return false;
                } else if (!el.value || !el.value.trim()) {
                    showInlineError('Please fill the required fields to continue.');
                    el.focus();
                    return false;
                }
            }
            clearInlineError();
            return true;
        }

        function go(step) {
            const target = Math.max(1, Math.min(totalSteps, step));
            if (target === currentStep) return;
            switchPane(target);
            currentStep = target;
            updateHeader();
            updateStepperUI();
            updateButtons();
            setProgress();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // ------- Events -------
        panes.forEach(p => p.classList.toggle('hidden', Number(p.dataset.step) !== 1));
        updateHeader();
        updateStepperUI();
        updateButtons();
        setProgress();

        nextBtn.addEventListener('click', () => {
            if (!validateStep()) return;
            nextBtn.classList.add('opacity-60', 'pointer-events-none');
            setTimeout(() => {
                nextBtn.classList.remove('opacity-60', 'pointer-events-none');
                go(currentStep + 1);
            }, 200);
        });

        prevBtn.addEventListener('click', () => go(currentStep - 1));

        stepLis.forEach(li => {
            li.addEventListener('click', () => {
                const target = Number(li.dataset.stepLi);
                if (target > currentStep && !validateStep()) return;
                go(target);
            });
        });

        // file name preview
        document.querySelectorAll('.fileName').forEach(input => {
            input.addEventListener('change', function() {
                const box = document.querySelector(`[data-file="${this.name}"]`);
                if (box) box.textContent = this.files.length ? this.files[0].name : 'No file chosen.';
            });
        });

        // AJAX submit
        $(document).ready(function() {
            $('.register-form').on('submit', function(e) {
                e.preventDefault();

                // Reset previous errors
                $('.error').text('');
                $('#submitBtn')
                    .addClass('opacity-60 pointer-events-none')
                    .html('<span class="material-symbols-outlined">hourglass_top</span> Submitting…');

                const formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(r) {
                        if (r.success && r.redirect_url) {
                            toastr.success(r.message || "Registration successful!", "Success", {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 3000,
                                positionClass: "toast-top-right"
                            });
                            setTimeout(() => {
                                window.location.href = r.redirect_url;
                            }, 1200);
                        } else {
                            toastr.info(r.message || "Form submitted successfully!", "Info", {
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    },

                    error: function(xhr) {
                        // Laravel Validation Errors
                        if (xhr?.responseJSON?.errors) {
                            let errorCount = 0;

                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                const msg = messages[0];
                                $(`.error-${field}`).text(msg); // inline error
                                toastr.error(msg, "Validation Error", {
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-top-right"
                                });
                                errorCount++;
                            });

                            if (errorCount > 0) {
                                toastr.warning("Please fix the highlighted errors.",
                                    "Form Incomplete", {
                                        closeButton: true,
                                        progressBar: true
                                    });
                            }

                        } else {
                            toastr.error(xhr?.responseJSON?.message || "Something went wrong!",
                                "Error", {
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-top-right"
                                });
                        }
                    },

                    complete: function() {
                        $('#submitBtn')
                            .removeClass('opacity-60 pointer-events-none')
                            .html(
                                '<span class="material-symbols-outlined">check_circle</span> Submit Application'
                            );
                    }
                });
            });
        });
    </script>
@endsection
