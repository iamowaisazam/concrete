@extends('web.partial.layout')

@section('css')
    <style>
        .dot-divider {
            background-image: linear-gradient(to right, rgba(2, 6, 23, .25) 33%, rgba(255, 255, 255, 0) 0%);
            background-size: 8px 1px;
            background-repeat: repeat-x;
            background-position: bottom;
        }

        .active-pill {
            background: #0080ff;
            color: #fff;
        }

        .shadow-card {
            box-shadow: 0 10px 30px -15px rgba(0, 0, 0, .25);
        }

        /* Accordion chevron */
        details summary::-webkit-details-marker {
            display: none;
        }

        details[open] .chev {
            transform: rotate(180deg);
        }

        .chev {
            transition: transform .25s ease;
        }

        /* Soft fade-up for FAQ cards */
        @keyframes softUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reveal {
            opacity: 0;
            transform: translateY(14px);
        }

        .reveal.in {
            animation: softUp .5s ease forwards;
        }
    </style>
@endsection

@section('content')
    @php
        $current = trim(request()->path(), '/');
        $nav = [
            ['label' => 'Privacy Policy', 'href' => url('/privacy')],
            ['label' => 'Cookie Policy', 'href' => url('/cookiepolicy')],
            ['label' => 'Terms of Service', 'href' => url('/terms')],
            ['label' => 'FAQ', 'href' => url('/faq')],
            ['label' => 'Disclaimer', 'href' => url('/disclaimer')],
        ];
    @endphp

    <section class="relative bg-white dark:bg-[#000f21]">
        <div class="container mx-auto max-w-7xl px-6 lg:px-8 py-10 lg:py-14">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- SIDEBAR (unchanged) -->
                <aside class="lg:col-span-4 xl:col-span-3">
                    <div class="sticky top-20">
                        <div
                            class="rounded-2xl border border-slate-200 bg-white/80 backdrop-blur-sm shadow-card dark:border-white/10 dark:bg-white/[0.04]">
                            <h3 class="px-5 pt-5 pb-3 text-lg font-semibold text-slate-900 dark:text-white">FAQ's</h3>
                            <div class="dot-divider h-px mx-5"></div>
                            <nav class="p-2">
                                @foreach ($nav as $item)
                                    @php
                                        $path = trim(parse_url($item['href'], PHP_URL_PATH), '/');
                                        $isActive = $current === $path;
                                    @endphp
                                    <a href="{{ $item['href'] }}"
                                        class="block rounded-lg px-4 py-3 my-1 text-sm font-medium
                          border border-transparent hover:border-slate-200 dark:hover:border-white/10
                          hover:bg-slate-50 dark:hover:bg-white/[0.06]
                          {{ $isActive ? 'active-pill' : 'text-slate-700 dark:text-slate-200' }}">
                                        {{ $item['label'] }}
                                    </a>
                                    @if (!$loop->last)
                                        <div class="mx-4 dot-divider h-px"></div>
                                    @endif
                                @endforeach
                            </nav>
                        </div>
                    </div>
                </aside>

                <!-- CONTENT: FAQs -->
                <main class="lg:col-span-8 xl:col-span-9">
                    <!-- Header card -->
                    <div
                        class="rounded-2xl bg-white shadow-card border border-slate-200 p-6 md:p-8 mb-8 dark:bg-white/[0.05] dark:border-white/10">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div
                                    class="h-12 w-12 rounded-xl bg-[#0080ff]/10 border border-[#0080ff]/20 grid place-content-center shrink-0">
                                    <svg viewBox="0 0 24 24" class="h-6 w-6 text-[#0080ff]" fill="currentColor">
                                        <path
                                            d="M11 18h2v2h-2v-2Zm1-16C6.48 2 2 6.48 2 12h2a8 8 0 1 1 8 8v2c5.52 0 10-4.48 10-10S17.52 2 12 2Zm-1 5h2v7h-2V7Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white">
                                        Frequently Asked Questions</h1>
                                    <p class="mt-2 text-slate-600 dark:text-slate-300">Quick answers to the most common
                                        questions about Autoboli.</p>
                                </div>
                            </div>

                            <!-- Search -->
                            <div class="w-full md:w-80">
                                <div class="relative">
                                    <input id="faqSearch" type="text"
                                        class="w-full rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.06] px-4 py-3 pl-10 text-slate-700 dark:text-white placeholder-slate-400 outline-none focus:ring-2 focus:ring-[#0080ff]/60"
                                        placeholder="Search questions…">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M15.5 14h-.79l-.28-.27a6.471 6.471 0 0 0 1.57-4.23C16 6.01 13.99 4 11.5 4S7 6.01 7 9.5 9.01 15 11.5 15c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l4.25 4.25 1.49-1.49L15.5 14ZM11.5 13C9.57 13 8 11.43 8 9.5S9.57 6 11.5 6 15 7.57 15 9.5 13.43 13 11.5 13Z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Groups -->
                    <div class="space-y-10">
                        <!-- Group: General -->
                        <section class="reveal">
                            <h2 class="text-xl font-bold text-slate-900 mb-4 dark:text-white">General</h2>
                            <div
                                class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.05] shadow-card divide-y divide-slate-100 dark:divide-white/10">

                                @php
                                    $general = [
                                        [
                                            'q' => 'How do credits work?',
                                            'a' =>
                                                'Credits are used to run data lookups (e.g., valuation pulls, VIN/Reg searches) and certain Pro features. Unused monthly credits roll over for 30 days on Pro/Team plans.',
                                        ],
                                        [
                                            'q' => 'Can I use Autoboli as a solo trader?',
                                            'a' =>
                                                'Absolutely. Solo Traders can use the same analytics and watchlists as dealers, with simple billing and self-serve upgrades.',
                                        ],
                                        [
                                            'q' => 'Does Autoboli cover UK & JP auctions?',
                                            'a' =>
                                                'Yes. We aggregate coverage from major UK houses and a growing list of Japanese auctions. Availability varies by source.',
                                        ],
                                    ];
                                @endphp

                                @foreach ($general as $i => $row)
                                    <details class="group faq-item">
                                        <summary class="flex items-center justify-between gap-4 cursor-pointer px-5 py-4">
                                            <span
                                                class="font-medium text-slate-800 dark:text-slate-100 group-open:text-[#0080ff]">{{ $row['q'] }}</span>
                                            <svg class="chev h-5 w-5 text-slate-400 group-open:text-[#0080ff]"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 15.5 5 8.5l1.4-1.4 5.6 5.59L17.6 7.1 19 8.5l-7 7Z" />
                                            </svg>
                                        </summary>
                                        <div class="px-5 pb-5 text-slate-600 dark:text-slate-300">
                                            {{ $row['a'] }}
                                        </div>
                                    </details>
                                @endforeach

                            </div>
                        </section>

                        <!-- Group: Billing -->
                        <section class="reveal">
                            <h2 class="text-xl font-bold text-slate-900 mb-4 dark:text-white">Billing & Plans</h2>
                            <div
                                class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.05] shadow-card divide-y divide-slate-100 dark:divide-white/10">
                                @php
                                    $billing = [
                                        [
                                            'q' => 'How much does it cost?',
                                            'a' =>
                                                'We offer monthly plans for Solo Traders and Teams. Pricing is based on credit limits and feature tiers (e.g., Reauction Tracker, Compare Auctions). Contact us for enterprise rates.',
                                        ],
                                        [
                                            'q' => 'Can I cancel anytime?',
                                            'a' =>
                                                'Yes. You can cancel anytime from your dashboard—your plan remains active until the end of the billing period.',
                                        ],
                                        [
                                            'q' => 'Do you offer invoices or VAT receipts?',
                                            'a' =>
                                                'Yes. All paid plans generate downloadable VAT invoices for your records.',
                                        ],
                                    ];
                                @endphp

                                @foreach ($billing as $row)
                                    <details class="group faq-item">
                                        <summary class="flex items-center justify-between gap-4 cursor-pointer px-5 py-4">
                                            <span
                                                class="font-medium text-slate-800 dark:text-slate-100 group-open:text-[#0080ff]">{{ $row['q'] }}</span>
                                            <svg class="chev h-5 w-5 text-slate-400 group-open:text-[#0080ff]"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 15.5 5 8.5l1.4-1.4 5.6 5.59L17.6 7.1 19 8.5l-7 7Z" />
                                            </svg>
                                        </summary>
                                        <div class="px-5 pb-5 text-slate-600 dark:text-slate-300">
                                            {{ $row['a'] }}
                                        </div>
                                    </details>
                                @endforeach
                            </div>
                        </section>

                        <!-- Group: Product -->
                        <section class="reveal">
                            <h2 class="text-xl font-bold text-slate-900 mb-4 dark:text-white">Product</h2>
                            <div
                                class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.05] shadow-card divide-y divide-slate-100 dark:divide-white/10">
                                @php
                                    $product = [
                                        [
                                            'q' => 'Can I use created images commercially?',
                                            'a' =>
                                                'Yes. If your plan includes image generation/exports, the outputs are yours to use commercially as permitted by our Terms.',
                                        ],
                                        [
                                            'q' => 'What is Reauction Tracker?',
                                            'a' =>
                                                'We detect vehicles that reappear after failing to sell and show price/condition reasons so you can decide if they’re worth bidding now.',
                                        ],
                                        [
                                            'q' => 'How does Compare Auctions work?',
                                            'a' =>
                                                'You can compare results across auction houses side-by-side to spot the best opportunities by price, model, mileage, and condition.',
                                        ],
                                    ];
                                @endphp

                                @foreach ($product as $row)
                                    <details class="group faq-item">
                                        <summary class="flex items-center justify-between gap-4 cursor-pointer px-5 py-4">
                                            <span
                                                class="font-medium text-slate-800 dark:text-slate-100 group-open:text-[#0080ff]">{{ $row['q'] }}</span>
                                            <svg class="chev h-5 w-5 text-slate-400 group-open:text-[#0080ff]"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 15.5 5 8.5l1.4-1.4 5.6 5.59L17.6 7.1 19 8.5l-7 7Z" />
                                            </svg>
                                        </summary>
                                        <div class="px-5 pb-5 text-slate-600 dark:text-slate-300">
                                            {{ $row['a'] }}
                                        </div>
                                    </details>
                                @endforeach
                            </div>
                        </section>
                    </div>

                    <!-- Contact strip -->
                    <div class="mt-10 rounded-2xl border border-[#0080ff]/30 bg-[#0080ff]/5 p-6 md:p-8">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Still have questions?</h3>
                                <p class="text-slate-600 dark:text-slate-300">We’re here to help. Reach out and we’ll get
                                    back quickly.</p>
                            </div>
                            <a href="{{ url('/contact') }}"
                                class="inline-flex items-center justify-center rounded-xl bg-[#0080ff] text-white font-semibold px-5 py-3 hover:bg-[#006fe0] transition">
                                Contact Support
                            </a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        // Reveal-on-scroll for FAQ groups
        (() => {
            const els = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window)) {
                els.forEach(e => e.classList.add('in'));
                return;
            }
            const io = new IntersectionObserver((entries, obs) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('in');
                        obs.unobserve(e.target);
                    }
                })
            }, {
                threshold: .15
            });
            els.forEach(el => io.observe(el));
        })();

        // Client-side filter for FAQ
        const search = document.getElementById('faqSearch');
        const items = Array.from(document.querySelectorAll('.faq-item'));

        function normalize(s) {
            return (s || '').toLowerCase().trim();
        }

        function filterFAQs() {
            const q = normalize(search.value);
            items.forEach(d => {
                const txt = normalize(d.querySelector('summary')?.innerText + ' ' + d.querySelector('div')
                    ?.innerText);
                d.style.display = txt.includes(q) ? '' : 'none';
            });
        }
        if (search) {
            search.addEventListener('input', filterFAQs);
        }
    </script>
@endsection
