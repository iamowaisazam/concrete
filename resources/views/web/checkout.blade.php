@extends('web.partial.layout')

@section('css')
    <style>
        /* page/card entrance */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(18px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-page {
            animation: fadeSlideUp .6s ease-out both;
        }

        .animate-card {
            animation: fadeSlideUp .5s .05s ease-out both;
        }

        .animate-aside {
            animation: fadeSlideUp .6s .12s ease-out both;
        }

        /* custom phone select (pure CSS; Tailwind handles colors via utility classes) */
        .csw {
            position: relative;
        }

        .csw .list {
            position: absolute;
            inset-inline-start: 0;
            top: 100%;
            min-width: 220px;
            display: none;
            z-index: 50;
        }

        /* let the phone list render above neighbors */
        .csw .list {
            z-index: 9999;
        }

        /* small entrance animation (matches your style) */
        @keyframes phonePop {
            from {
                opacity: 0;
                transform: translateY(-6px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .csw.open .list {
            display: block;
            animation: phonePop .18s ease-out both;
        }



        .flag {
            width: 20px;
            height: 14px;
            border-radius: 2px;
        }

        @media (prefers-reduced-motion: reduce) {

            .animate-page,
            .animate-card,
            .animate-aside {
                animation: none;
            }
        }

        /* --- plan dropdown --- */
        .plan-dd {
            position: relative;
        }

        .plan-dd .menu {
            position: absolute;
            inset-inline: 0;
            top: calc(100% + .5rem);
            display: none;
            z-index: 60;
        }

        .plan-dd.open .menu {
            display: block;
        }

        /* selected state for options */
        .plan-option.selectedPlan {
            background: #0080ff !important;
            color: #fff !important;
            border-color: #0080ff !important;
        }

        /* make nested text white when selected */
        .plan-option.selectedPlan * {
            color: #fff !important;
        }

        /* dropdown open animation */
        @keyframes popSlide {
            from {
                opacity: 0;
                transform: translateY(-6px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .plan-dd .menu {
            /* you already have positioning; these help the animation look crisp */
            transform-origin: top center;
            will-change: opacity, transform;
        }

        /* when opened, show and animate */
        .plan-dd.open .menu {
            display: block;
            animation: popSlide .22s ease-out both;
        }

        /* respect reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .plan-dd.open .menu {
                animation: none;
            }
        }
    </style>
@endsection

@section('content')
    <section class="min-h-screen bg-[#0f1c2c] dark:bg-gray-100 transition-colors animate-page">
        <div class="max-w-7xl mx-auto px-6 py-8 md:py-12">
            <form class="register-form" enctype="multipart/form-data" action="{{ url('/checkout') }}" method="post">
                @csrf

                <!-- header -->
                <div class="text-center">
                    <h1 class="text-2xl md:text-3xl font-bold text-white dark:text-gray-900 mb-3 text-left">Checkout</h1>
                </div>

                <!-- grid -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    <!-- left: form -->
                    <div class="lg:col-span-8">
                        <div class="animate-card rounded bg-[#0b1624] dark:bg-white    p-5 md:p-7">
                            <!-- accordion (single open) -->
                            <div class="rounded overflow-hidden bg-transparent">
                                <div class="border-b border-white/10 dark:border-gray-200">
                                    <div
                                        class="text-lg w-full text-left px-4 md:px-6 py-4 font-semibold text-white dark:text-gray-900">
                                        Billing Info
                                    </div>
                                </div>

                                <div class="px-4 md:px-6 py-5">
                                    <!-- User Details -->
                                    <div class="mb-6">
                                        <div class="mb-4">
                                            <span
                                                class="text-white dark:text-gray-900 font-semibold text-base inline-flex items-center">
                                                User Details
                                            </span>
                                            <div class="h-0.5 w-28 bg-[#0080ff] mt-2"></div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm text-white/80 dark:text-gray-700 mb-1">First
                                                    Name</label>
                                                <input name="first_name" value="Owais" placeholder="First Name"
                                                    class="sign-input w-full rounded border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900 px-3.5 py-3 focus:outline-none" />
                                                <small class="error error-first_name text-danger text-red-500"></small>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-white/80 dark:text-gray-700 mb-1">Last
                                                    Name</label>
                                                <input name="last_name" value="Azam" placeholder="Last Name"
                                                    class="sign-input w-full rounded border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900 px-3.5 py-3 focus:outline-none" />
                                                <small class="error error-last_name text-danger text-red-500"></small>
                                            </div>

                                            <!-- Phone -->
                                            <div>
                                                <label class="block text-sm text-white/80 dark:text-gray-700 mb-1">Phone
                                                    No</label>

                                                <!-- removed overflow-hidden from this wrapper -->
                                                <div class="flex rounded border border-white/10 dark:border-gray-300">
                                                    <!-- custom select -->
                                                    <div id="customSelect"
                                                        class="csw bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900 flex items-center gap-2 px-3 cursor-pointer">
                                                        <div id="selectedOption" class="flex items-center gap-2">
                                                            <img class="flag" src="https://flagcdn.com/w40/gb.png"
                                                                alt="GB">
                                                            <span>+44</span>
                                                        </div>

                                                        <!-- list -->
                                                        <div id="optionList"
                                                            class="list mt-2 rounded overflow-hidden border border-white/10 dark:border-gray-300 shadow-2xl
                  bg-[#0b1624] dark:bg-white text-white dark:text-gray-900">
                                                            <div class="custom-select-option flex items-center gap-2 px-3 py-2 hover:bg-white/10 dark:hover:bg-gray-100"
                                                                data-code="+44" data-flag="gb">
                                                                <img class="flag" src="https://flagcdn.com/w40/gb.png"
                                                                    alt="GB"><span>+44 (GB)</span>
                                                            </div>
                                                            <div class="custom-select-option flex items-center gap-2 px-3 py-2 hover:bg-white/10 dark:hover:bg-gray-100"
                                                                data-code="+1" data-flag="us">
                                                                <img class="flag" src="https://flagcdn.com/w40/us.png"
                                                                    alt="US"><span>+1 (US)</span>
                                                            </div>
                                                            <div class="custom-select-option flex items-center gap-2 px-3 py-2 hover:bg-white/10 dark:hover:bg-gray-100"
                                                                data-code="+92" data-flag="pk">
                                                                <img class="flag" src="https://flagcdn.com/w40/pk.png"
                                                                    alt="PK"><span>+92 (PK)</span>
                                                            </div>
                                                            <div class="custom-select-option flex items-center gap-2 px-3 py-2 hover:bg-white/10 dark:hover:bg-gray-100"
                                                                data-code="+61" data-flag="au">
                                                                <img class="flag" src="https://flagcdn.com/w40/au.png"
                                                                    alt="AU"><span>+61 (AU)</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input name="phone" type="tel" value="03112239342"
                                                        placeholder="Phone Number"
                                                        class="sign-input flex-1 bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900 px-3.5 py-3 focus:outline-none" />
                                                </div>

                                                <!-- add this hidden field so backend knows which code was chosen -->
                                                <input type="hidden" name="phone_code" id="phone_code" value="+44">

                                                <small class="error error-phone text-danger text-red-500"></small>
                                            </div>


                                            <div>
                                                <label
                                                    class="block text-sm text-white/80 dark:text-gray-700 mb-1">Country</label>
                                                <input name="country" value="Pakistan" placeholder="Country"
                                                    class="sign-input w-full rounded border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900 px-3.5 py-3 focus:outline-none" />
                                                <small class="error error-country text-danger text-red-500"></small>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-white/80 dark:text-gray-700 mb-1">Province
                                                    / State</label>
                                                <input name="state" value="Sindh" placeholder="State"
                                                    class="sign-input w-full rounded border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900 px-3.5 py-3 focus:outline-none" />
                                                <small class="error error-state text-danger text-red-500"></small>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-sm text-white/80 dark:text-gray-700 mb-1">City</label>
                                                <input name="city" value="karachi" placeholder="City"
                                                    class="sign-input w-full rounded border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900 px-3.5 py-3 focus:outline-none" />
                                                <small class="error error-city text-danger text-red-500"></small>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-white/80 dark:text-gray-700 mb-1">Zip
                                                    Code</label>
                                                <input name="zip_code" value="123" placeholder="Zip Code"
                                                    class="sign-input w-full rounded border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900 px-3.5 py-3 focus:outline-none" />
                                                <small class="error error-zip_code text-danger text-red-500"></small>
                                            </div>

                                            <div class="md:col-span-2">
                                                <label
                                                    class="block text-sm text-white/80 dark:text-gray-700 mb-1">Address</label>
                                                <input name="address" value="Address" placeholder="Address"
                                                    class="sign-input w-full rounded border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900 px-3.5 py-3 focus:outline-none" />
                                                <small class="error error-address text-danger text-red-500"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Info -->
                                    <div class="payment_div">
                                        <div class="mb-4">
                                            <span
                                                class="text-white dark:text-gray-900 font-semibold text-base inline-flex items-center">
                                                Payment Info
                                            </span>
                                            <div class="h-0.5 w-28 bg-[#0080ff] mt-2"></div>
                                        </div>

                                        <div class="space-y-3">
                                            <label class="block text-sm text-white/80 dark:text-gray-700">Card Info</label>
                                            <div id="card-element"
                                                class="rounded border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-gray-100 px-3.5 py-3 text-white ">
                                            </div>
                                            <div id="card-errors" class="text-red-500 text-sm"></div>
                                            <small class="error error-payment_method text-danger text-red-500"></small>
                                        </div>
                                    </div>

                                    <input type="hidden" name="plan_id" value="{{ request()->id }}" />

                                    <div class="mt-6">
                                        <button type="submit"
                                            class="w-full md:w-auto inline-flex items-center justify-center rounded bg-[#0080ff] hover:bg-[#006fe0] text-white font-semibold px-5 py-3 shadow-lg shadow-[#0080ff]/30 transition">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- right: summary -->
                    <div class="lg:col-span-4">
                        <aside
                            class="animate-aside rounded bg-[#0b1624] dark:bg-white border border-white/10 dark:border-gray-200  p-5 md:p-6 sticky top-24">
                            <h5 class="text-white dark:text-gray-900 text-lg font-semibold">Order Summary</h5>

                            <div class="mt-6">
                                <h6 class="text-white/90 dark:text-gray-800 font-semibold mb-3">Your Plan</h6>

                                {{-- Selected Plan (always visible) --}}
                                <div id="selectedPlanDisplay"
                                    class="rounded border border-white/10  bg-[#0080ff] px-4 py-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3 text-white">
                                            <i class="fa-brands fa-kickstarter"></i>
                                            <div class="leading-tight">
                                                <div class="font-medium plan-title">Select a plan</div>
                                                <div class="text-xs text-white/60 plan-desc">—</div>
                                            </div>
                                        </div>
                                        <div class="text-right text-white ">
                                            <span class="plan-price">£0.00</span>
                                            <div class="text-xs text-white/60">Per Month</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Trigger + Menu --}}
                                <div id="planDropdown" class="plan-dd mt-3">
                                    <button type="button"
                                        class="plan-trigger w-full inline-flex items-center justify-between rounded border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-gray-50 px-4 py-2 text-white dark:text-gray-900 hover:border-[#0080ff]">
                                        <span>Change Plan</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div
                                        class="menu mt-2 rounded overflow-hidden border border-white/10 dark:border-gray-300 
                                                bg-[#0b1624] dark:bg-white">
                                        <div class="max-h-80 overflow-auto divide-y divide-white/10 dark:divide-gray-200">
                                            @foreach ($plans as $item)
                                                <label data-plan="{{ $item->id }}" data-price="{{ $item->price }}"
                                                    class="plan-option group flex items-center justify-between gap-3 px-4 py-3 cursor-pointer
        bg-[#0f1c2c] dark:bg-gray-50 text-white dark:text-gray-900
        hover:bg-[#0080ff] dark:hover:bg-[#0080ff]
        transition">

                                                    <div class="flex items-center gap-3">
                                                        <i
                                                            class="{{ $item->icon ?? '' }} group-hover:text-white dark:group-hover:text-white"></i>
                                                        <div class="leading-tight">
                                                            <div
                                                                class="font-medium group-hover:text-white dark:group-hover:text-white">
                                                                {{ $item->plan_name }}
                                                            </div>
                                                            <div
                                                                class="text-xs text-white/60 dark:text-gray-500 group-hover:text-white/80 dark:group-hover:text-white/80">
                                                                {{ $item->short_desc }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="text-right group-hover:text-white dark:group-hover:text-white">
                                                        £{{ $item->price }}
                                                        <div
                                                            class="text-xs text-white/60 dark:text-gray-500 group-hover:text-white/80 dark:group-hover:text-white/80">
                                                            Per Month
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <small class="error error-plan_id text-danger text-red-500"></small>

                                <div class="my-6 h-px bg-white/10 dark:bg-gray-200"></div>

                                <h6 class="text-white/90 dark:text-gray-800 font-semibold mb-3">Billing</h6>
                                <ul class="space-y-2 text-white dark:text-gray-900">
                                    <li class="flex items-center justify-between">
                                        <span>Base price</span>
                                        <span class="base-price">£0.00</span>
                                    </li>
                                    <li class="flex items-center justify-between">
                                        <span>Discount</span>
                                        <span>£0.00</span>
                                    </li>
                                    <li class="flex items-center justify-between">
                                        <span>GST</span>
                                        <span>£0.00</span>
                                    </li>
                                    <li
                                        class="flex items-center justify-between pt-3 border-t border-white/10 dark:border-gray-200 font-semibold">
                                        <span class="total-price">Total</span>
                                        <span class="base-price total-price">£0.00</span>
                                    </li>
                                </ul>

                            </div>
                        </aside>
                    </div>

                </div>
            </form>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // keep your existing selectors / behavior
        document.querySelectorAll('.plan-option').forEach(option => {
            option.addEventListener('click', () => {
                document.querySelectorAll('.plan-option').forEach(o => o.classList.remove('actives'));
                option.classList.add('actives');
            });
        });
    </script>

    <script>
        // custom select (phone)
        const cs = document.getElementById("customSelect");
        const selected = document.getElementById("selectedOption");
        const options = document.getElementById("optionList");

        selected.addEventListener("click", () => {
            cs.classList.toggle('open');
        });

        options.querySelectorAll(".custom-select-option").forEach((item) => {
            item.addEventListener("click", () => {
                const flag = item.getAttribute("data-flag");
                const code = item.getAttribute("data-code");

                // update visible selection
                selected.innerHTML =
                    `<img class="flag" src="https://flagcdn.com/w40/${flag}.png" alt="${flag}"> <span>${code}</span>`;

                // NEW: persist code for backend
                document.getElementById('phone_code').value = code; // <— add this

                cs.classList.remove('open');
            });
        });

        document.addEventListener("click", (e) => {
            if (!cs.contains(e.target)) cs.classList.remove('open');
        });
    </script>



    <script>
        $(document).ready(function() {
            // --- STRIPE (unchanged) ---
            let stripe = Stripe("{{ env('STRIPE_PUBLISHABLE_KEY') }}");
            let elements = stripe.elements();
            let card = elements.create('card');
            card.mount('#card-element');

            async function checkpayment() {
                $('#card-errors').text('');
                let response = await stripe.createPaymentMethod({
                    type: 'card',
                    card: card
                });
                if (response.error) {
                    $('input[name=payment_method]').val('');
                    $('#card-errors').text(response.error.message);
                    return false;
                } else {
                    $('input[name=payment_method]').val(response.paymentMethod.id);
                    return true;
                }
            }

            // --- PLAN DROPDOWN ---
            const $dd = $('#planDropdown');
            const $trigger = $dd.find('.plan-trigger');
            const $menu = $dd.find('.menu');

            function updateSelectedPlanDisplay($el) {
                const title = $.trim($el.find('.font-medium').text());
                const desc = $.trim($el.find('.text-xs').first().text());
                const price = $el.data('price');
                $('#selectedPlanDisplay .plan-title').text(title || 'Select a plan');
                $('#selectedPlanDisplay .plan-desc').text(desc || '—');
                $('#selectedPlanDisplay .plan-price').text('£' + (price ?? 0));
            }

            function planCalculation(id) {
                const $el = $(`.plan-option[data-plan='${id}']`);
                if (!$el.length) return;

                // visual selection inside menu
                $('.plan-option').removeClass('selectedPlan');
                $el.addClass('selectedPlan');

                // update price + hidden input
                const price = $el.data('price');
                $(".base-price").text('£' + price);
                $("input[name=plan_id]").val(id).trigger('change');

                // update visible selected card
                updateSelectedPlanDisplay($el);
            }

            // open/close dropdown
            $trigger.on('click', function() {
                $dd.toggleClass('open');
            });
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#planDropdown').length) $dd.removeClass('open');
            });

            // pick a plan from menu
            $(document).on('click', '.plan-option', function() {
                const id = $(this).data('plan');
                planCalculation(id);
                $dd.removeClass('open');
            });

            // show/hide payment section for plan 2 (as you had)
            $("input[name=plan_id]").on('change', function() {
                if ($(this).val() == 2) {
                    $(".payment_div").hide();
                } else {
                    $(".payment_div").show();
                }
            });

            // initialize selection on load
            let initialPlanId = $("input[name=plan_id]").val();
            if (!initialPlanId) {
                // fall back to the first plan in the list
                initialPlanId = $('.plan-option').first().data('plan');
            }
            planCalculation(initialPlanId);

            // --- FORM SUBMIT (unchanged) ---
            $('.register-form').on('submit', async function(e) {
                e.preventDefault();
                $(`.error`).text('');
                $('button[type=submit]').prop('disabled', true);

                // Optional: if you want to enforce card on non-2 plans, re-enable this block:
                // if ($('input[name=plan_id]').val() != 2) {
                //   let res = await checkpayment();
                //   if (!res) {
                //     alert('Please Enter Card Details');
                //     $('button[type=submit]').prop('disabled', false);
                //     return false;
                //   }
                // }

                let formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        alert("Form submitted successfully!");
                        window.location.href = "{{ url('/account-setting/billing') }}";
                        $('button[type=submit]').prop('disabled', false);
                    },
                    error: function(xhr) {
                        if (xhr?.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(key, messages) {
                                $(`.error-${key}`).text(messages);
                            });
                        } else {
                            alert(xhr?.responseJSON?.message);
                        }
                        $('button[type=submit]').prop('disabled', false);
                    }
                });
            });
        });

        // after: $trigger.on('click', ...
        $trigger.on('click', function() {
            $dd.toggleClass('open');
            $trigger.attr('aria-expanded', $dd.hasClass('open'));
        });
    </script>
@endsection
