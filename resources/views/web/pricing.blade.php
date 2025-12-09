@extends('web.partial.layout')
@section('css')
    <style>
        /* sheen effect */
        .card-sheen::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(120deg, rgba(255, 255, 255, .06), transparent 40%);
            opacity: .4;
            border-radius: inherit;
        }

        :root {
            --brand: #0080ff;
        }
    </style>
@endsection

@section('content')
    <section
        class="min-h-screen w-full bg-[#000f21] dark:bg-gray-100 text-white dark:text-gray-900 pt-28 pb-20 transition-colors">
        <div class="max-w-7xl mx-auto px-6">

            {{-- Header --}}
            <div class="text-center mb-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 dark:bg-gray-200 border border-white/10 dark:border-gray-300 text-sm text-white dark:text-gray-800">
                    <span>Monthly</span> <span class="opacity-30">•</span> <span>Yearly</span>
                    <span class="ml-1 text-[#8abfff] text-xs">Up to 20% OFF</span>
                </div>
                <h1 class="mt-5 text-3xl md:text-5xl font-bold text-white dark:text-gray-900">
                    Flexible plans for AI content creators
                </h1>
                <p class="mt-2 text-white/70 dark:text-gray-700">Choose the best plan for your needs.</p>
            </div>

            {{-- Billing Toggle --}}
            <div class="flex items-center justify-center mb-8">
                <div
                    class="inline-flex rounded-xl border border-white/10 dark:border-gray-300 bg-white/5 dark:bg-gray-200 p-1">
                    <button id="billMonthly"
                        class="focusable active px-4 py-2 text-sm rounded-lg bg-[#1a2640] dark:bg-gray-800 border border-white/10 dark:border-gray-400 text-white dark:text-gray-100">
                        Monthly
                    </button>
                    <button id="billYearly"
                        class=" px-4 py-2 text-sm rounded-lg hover:bg-white/10 dark:hover:bg-gray-300 text-white hover:text-black">
                        Yearly <span class="ml-1 text-[#8abfff]">–20%</span>
                    </button>
                </div>
            </div>

            {{-- Pricing Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 py-14 gap-6 lg:gap-0">

                {{-- Free --}}
                <div
                    class="relative rounded-l-xl border border-white/10 dark:border-gray-300 bg-[#0f1c2c]/70 dark:bg-white p-5 lg:p-6 card-sheen transition-colors">
                    <h3 class="text-xl font-semibold text-white dark:text-gray-900">Free</h3>
                    <div class="mt-2 text-white dark:text-gray-800">
                        <span class="text-3xl font-bold" data-price data-month="0" data-plan="Free">$0</span>
                        <span class="text-white/60 dark:text-gray-600">/month</span>
                    </div>
                    <a href="{{ url('/register?plan_id=4') }}"
                        class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-[#0080ff] font-semibold px-4 py-2.5 text-white hover:bg-[#006fe0] transition focusable">
                        Get Started
                    </a>
                    <div class="border-b border-dashed border-white/60 dark:border-[#0080ff]/10  py-5"></div>
                    <ul class="mt-4 space-y-5 text-sm py-5 text-white/90 dark:text-gray-800 py5">
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check mt-1 text-[#8abfff]"></i> Image
                            Generation — 3 AI models</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-check mt-1 text-[#8abfff]"></i> Image
                            Editing — 1 project</li>
                    </ul>
                </div>

                {{-- Entry --}}
                <div
                    class="relative rounded lg:rounded-none border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-white p-5 lg:p-6 card-sheen">
                    <h3 class="text-xl font-semibold text-white dark:text-gray-900">Entry</h3>
                    <div class="mt-2 text-white dark:text-gray-800">
                        <span class="text-3xl font-bold" data-price data-month="10" data-plan="Entry">$10</span>
                        <span class="text-white/60 dark:text-gray-600">/month</span>
                    </div>
                    <a href="{{ url('/register?plan_id=4') }}"
                        class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-[#0080ff] font-semibold px-4 py-2.5 text-white hover:bg-[#006fe0] transition focusable">
                        Get Started
                    </a>
                    <div class="border-b border-dashed border-white/60 dark:border-[#0080ff]/10  py-5"></div>
                    <ul class="mt-4 space-y-5 text-sm py-5 text-white/90 dark:text-gray-800 py5">
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Image Generation — 9 AI models</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Video Generation — 18 AI models</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Image Editing — 5 projects</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Parallel jobs — 2 gens at a time</li>
                    </ul>
                </div>

                {{-- Core --}}
                <div
                    class="relative rounded lg:rounded-none border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-white p-5 lg:p-6 card-sheen">
                    <h3 class="text-xl font-semibold text-white dark:text-gray-900">Core</h3>
                    <div class="mt-2 text-white dark:text-gray-800">
                        <span class="text-3xl font-bold" data-price data-month="30" data-plan="Core">$30</span>
                        <span class="text-white/60 dark:text-gray-600">/month</span>
                    </div>
                    <a href="{{ url('/register?plan_id=4') }}"
                        class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-[#0080ff] font-semibold px-4 py-2.5 text-white hover:bg-[#006fe0] transition focusable">
                        Get Started
                    </a>
                    <div class="border-b border-dashed border-white/60 dark:border-[#0080ff]/10  py-5"></div>
                    <ul class="mt-4 space-y-5 text-sm py-5 text-white/90 dark:text-gray-800 py5">
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Image Generation — 10 AI models</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Video Generation — 24 AI models</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Image Editing — 15 projects</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Parallel jobs — 4 gens at a time</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Model Training</li>
                    </ul>
                </div>

                {{-- Plus --}}
                <div class="relative border-2 border-[#0080ff]/60 dark:border-[#0080ff]/70 bg-[#08457E]/30 dark:bg-blue-100/60 p-5 lg:p-6 ring-1 ring-[#0080ff]/20 shadow-[0_0_0_4px_rgba(0,128,255,.05)] lg:-my-10 rounded-xl text-white dark:text-gray-900 transition-colors"
                    style="padding-top: 60px;">
                    <span
                        class="absolute right-4 -top-3 text-xs bg-[#0080ff] text-white px-2 py-1 rounded-md font-semibold shadow">
                        Most popular
                    </span>
                    <h3 class="text-xl font-semibold">Plus</h3>
                    <div class="mt-2">
                        <span class="text-3xl font-extrabold" data-price data-month="65" data-plan="Plus">$65</span>
                        <span class="text-white/60 dark:text-gray-600">/month</span>
                    </div>
                    <a href="{{ url('/register?plan_id=4') }}"
                        class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-[#0080ff] font-semibold px-4 py-2.5 text-white hover:bg-[#006fe0] transition focusable">
                        Get Started
                    </a>
                    <div class="border-b border-dashed border-white/60 dark:border-[#0080ff]/10  py-5"></div>
                    <ul class="mt-4 space-y-3 text-sm py-5">
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Image Generation — 10 AI models</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Video Generation — 24 AI models</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Image Editing — 50 projects</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Parallel jobs — 8 gens at a time</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Model Training</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Top-up Credits</li>
                    </ul>
                </div>

                {{-- Ultra --}}
                <div
                    class="relative rounded-r-xl border border-white/10 dark:border-gray-300 bg-[#0f1c2c] dark:bg-white p-5 lg:p-6 card-sheen">
                    <h3 class="text-xl font-semibold text-white dark:text-gray-900">Ultra</h3>
                    <div class="mt-2 text-white dark:text-gray-800">
                        <span class="text-3xl font-bold" data-price data-month="175" data-plan="Ultra">$175</span>
                        <span class="text-white/60 dark:text-gray-600">/month</span>
                    </div>
                    <a href="{{ url('/register?plan_id=4') }}"
                        class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-[#0080ff] font-semibold px-4 py-2.5 text-white hover:bg-[#006fe0] transition focusable">
                        Get Started
                    </a>
                    <div class="border-b border-dashed border-white/60 dark:border-[#0080ff]/10  py-5"></div>
                    <ul class="mt-4 space-y-5 text-sm py-5 text-white/90 dark:text-gray-800 py5">
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Image Generation — 10 AI models</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Video Generation — 24 AI models</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Image Editing — Unlimited projects</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Parallel jobs — 10 gens at a time</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Model Training</li>
                        <li><i class="fa-solid fa-check text-[#8abfff]"></i> Top-up Credits</li>
                    </ul>
                </div>

            </div>

            {{-- Comparison Table --}}
            <div class="mt-16">
                <h2 class="text-2xl font-semibold mb-5 text-white dark:text-gray-900">
                    Compare features and model access across all plans
                </h2>

                <div class="overflow-x-auto rounded border-[1px] border-[#FFFFFF]/10 dark:border-[#E2E8F0] cmp-wrap">
                    <table class="cmp-table min-w-[980px] w-full text-left text-[15px]">

                        {{-- Header with plan names --}}
                        <thead
                            class="z-10 border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0] text-white/85 dark:text-gray-900">
                            <tr class="text-xs md:text-sm">
                                <th class="py-4 px-4 cmp-sticky-col font-semibold sticky  top-0"></th>
                                <th class="py-4 px-4"><span
                                        class="material-symbols-outlined text-sm align-middle ml-1">info</span> Free</th>
                                <th class="py-4 px-4"><span
                                        class="material-symbols-outlined text-sm align-middle ml-1">help</span> Entry</th>
                                <th class="py-4 px-4"><span
                                        class="material-symbols-outlined text-sm align-middle ml-1">insights</span> Core
                                </th>
                                <th class="py-4 px-4 is-plus"><span
                                        class="material-symbols-outlined text-sm align-middle ml-1">whatshot</span> Plus
                                </th>
                                <th class="py-4 px-4"><span
                                        class="material-symbols-outlined text-sm align-middle ml-1">bolt</span> Ultra</th>
                            </tr>
                        </thead>



                        <tbody class=" ">
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <td colspan="6" class="py-5 px-4">
                                    <div class="font-semibold">Dashboard & Insights
                                    </div>
                                </td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2 flex items-center gap-2">
                                        Auction Overview
                                    </div>
                                </th>
                                <td class="py-3 px-4 ">40 <span class="text-white/60 dark:text-gray-600">/day</span></td>
                                <td class="py-3 px-4">3,000 <span class="text-white/60 dark:text-gray-600">/month</span>
                                </td>
                                <td class="py-3 px-4">15,000 <span class="text-white/60 dark:text-gray-600">/month</span>
                                </td>
                                <td class="py-3 px-4 is-plus">35,000 <span
                                        class="text-white/60 dark:text-gray-600">/month</span></td>
                                <td class="py-3 px-4">100,000 <span class="text-white/60 dark:text-gray-600">/month</span>
                                </td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Interest Based </div>
                                </th>
                                <td class="py-3 px-4">1</td>
                                <td class="py-3 px-4">2</td>
                                <td class="py-3 px-4">4</td>
                                <td class="py-3 px-4 is-plus">8</td>
                                <td class="py-3 px-4">10</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Watched List</div>
                                </th>
                                <td class="py-3 px-4">30 days</td>
                                <td class="py-3 px-4">Unlimited</td>
                                <td class="py-3 px-4">Unlimited</td>
                                <td class="py-3 px-4 is-plus">Unlimited</td>
                                <td class="py-3 px-4">Unlimited</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Alerted List </div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4"><span
                                        class="tick material-symbols-outlined align-middle">check_circle</span></td>
                                <td class="py-3 px-4"><span
                                        class="tick material-symbols-outlined align-middle">check_circle</span></td>
                                <td class="py-3 px-4 is-plus"><span
                                        class="tick material-symbols-outlined align-middle">check_circle</span></td>
                                <td class="py-3 px-4"><span
                                        class="tick material-symbols-outlined align-middle">check_circle</span></td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Vehicle Sales Overview</div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4"><span
                                        class="tick material-symbols-outlined align-middle">check_circle</span></td>
                                <td class="py-3 px-4"><span
                                        class="tick material-symbols-outlined align-middle">check_circle</span></td>
                                <td class="py-3 px-4 is-plus"><span
                                        class="tick material-symbols-outlined align-middle">check_circle</span></td>
                                <td class="py-3 px-4"><span
                                        class="tick material-symbols-outlined align-middle">check_circle</span></td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <td colspan="6" class="py-6 px-4">
                                    <div class="text-white dark:text-gray-900 font-semibold">Interest Based </div>
                                </td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Save Custom Search (Interest)</div>
                                </th>
                                <td class="py-3 px-4">40 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4">15,000 images</td>
                                <td class="py-3 px-4 is-plus">35,000 images</td>
                                <td class="py-3 px-4">100,000 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Discover Matching Auctions</div>
                                </th>
                                <td class="py-3 px-4">8 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4 is-plus">7,000 images</td>
                                <td class="py-3 px-4">20,000 images</td>
                            </tr>


                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Past Auction Records</div>
                                </th>
                                <td class="py-3 px-4">1 image</td>
                                <td class="py-3 px-4">120 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4 is-plus">1,400 images</td>
                                <td class="py-3 px-4">4,000 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">3-Month Price Trend Graph</div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">100 images</td>
                                <td class="py-3 px-4">500 images</td>
                                <td class="py-3 px-4 is-plus">1,166 images</td>
                                <td class="py-3 px-4">3,333 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Real-Time Vehicle Valuation</div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">6.6 images</td>
                                <td class="py-3 px-4">333 images</td>
                                <td class="py-3 px-4 is-plus">777 images</td>
                                <td class="py-3 px-4">2,222 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Best Auction Match Finder</div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">6.6 images</td>
                                <td class="py-3 px-4">333 images</td>
                                <td class="py-3 px-4 is-plus">777 images</td>
                                <td class="py-3 px-4">2,222 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <td colspan="6" class="py-6 px-4">
                                    <div class="text-white dark:text-gray-900 font-semibold">Auction Data </div>
                                </td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Auction Market Snapshot</div>
                                </th>
                                <td class="py-3 px-4">40 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4">15,000 images</td>
                                <td class="py-3 px-4 is-plus">35,000 images</td>
                                <td class="py-3 px-4">100,000 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Live Online Auctions</div>
                                </th>
                                <td class="py-3 px-4">8 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4 is-plus">7,000 images</td>
                                <td class="py-3 px-4">20,000 images</td>
                            </tr>


                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Scheduled Timed Auctions</div>
                                </th>
                                <td class="py-3 px-4">1 image</td>
                                <td class="py-3 px-4">120 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4 is-plus">1,400 images</td>
                                <td class="py-3 px-4">4,000 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Auction Vehicle Insights</div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">100 images</td>
                                <td class="py-3 px-4">500 images</td>
                                <td class="py-3 px-4 is-plus">1,166 images</td>
                                <td class="py-3 px-4">3,333 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Auction Alerts & Notifications</div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">6.6 images</td>
                                <td class="py-3 px-4">333 images</td>
                                <td class="py-3 px-4 is-plus">777 images</td>
                                <td class="py-3 px-4">2,222 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Live Auction Screen</div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">6.6 images</td>
                                <td class="py-3 px-4">333 images</td>
                                <td class="py-3 px-4 is-plus">777 images</td>
                                <td class="py-3 px-4">2,222 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Auction Schedule </div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">6.6 images</td>
                                <td class="py-3 px-4">333 images</td>
                                <td class="py-3 px-4 is-plus">777 images</td>
                                <td class="py-3 px-4">2,222 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Reaction Tracker </div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">6.6 images</td>
                                <td class="py-3 px-4">333 images</td>
                                <td class="py-3 px-4 is-plus">777 images</td>
                                <td class="py-3 px-4">2,222 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Upcoming Auction Vehicles </div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">6.6 images</td>
                                <td class="py-3 px-4">333 images</td>
                                <td class="py-3 px-4 is-plus">777 images</td>
                                <td class="py-3 px-4">2,222 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Historical Auction Data </div>
                                </th>
                                <td class="py-3 px-4 cross">✖</td>
                                <td class="py-3 px-4">6.6 images</td>
                                <td class="py-3 px-4">333 images</td>
                                <td class="py-3 px-4 is-plus">777 images</td>
                                <td class="py-3 px-4">2,222 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <td colspan="6" class="py-6 px-4">
                                    <div class="text-white dark:text-gray-900 font-semibold">Vehicle Valuation </div>
                                </td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Instant Vehicle Valuation</div>
                                </th>
                                <td class="py-3 px-4">40 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4">15,000 images</td>
                                <td class="py-3 px-4 is-plus">35,000 images</td>
                                <td class="py-3 px-4">100,000 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Smart Bid Recommendation</div>
                                </th>
                                <td class="py-3 px-4">8 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4 is-plus">7,000 images</td>
                                <td class="py-3 px-4">20,000 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <td colspan="6" class="py-6 px-4">
                                    <div class="text-white dark:text-gray-900 font-semibold">More </div>
                                </td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Comparison Tool</div>
                                </th>
                                <td class="py-3 px-4">40 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4">15,000 images</td>
                                <td class="py-3 px-4 is-plus">35,000 images</td>
                                <td class="py-3 px-4">100,000 images</td>
                            </tr>

                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">VIN Report Credits</div>
                                </th>
                                <td class="py-3 px-4">8 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4 is-plus">7,000 images</td>
                                <td class="py-3 px-4">20,000 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Industry News & Insights</div>
                                </th>
                                <td class="py-3 px-4">8 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4 is-plus">7,000 images</td>
                                <td class="py-3 px-4">20,000 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Sub-User Account Access</div>
                                </th>
                                <td class="py-3 px-4">8 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4 is-plus">7,000 images</td>
                                <td class="py-3 px-4">20,000 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Light/Dark Mode</div>
                                </th>
                                <td class="py-3 px-4">8 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4 is-plus">7,000 images</td>
                                <td class="py-3 px-4">20,000 images</td>
                            </tr>
                            <tr class="align-top border-b border-[#FFFFFF]/10 dark:border-[#E2E8F0]">
                                <th class="py-3 px-4 cmp-sticky-col">
                                    <div class="pb-2">Advanced Search Filters</div>
                                </th>
                                <td class="py-3 px-4">8 images</td>
                                <td class="py-3 px-4">600 images</td>
                                <td class="py-3 px-4">3,000 images</td>
                                <td class="py-3 px-4 is-plus">7,000 images</td>
                                <td class="py-3 px-4">20,000 images</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>




        </div>
    </section>
@endsection

@section('js')
    <script>
        // ------- Elements -------
        const monthlyBtn = document.getElementById('billMonthly');
        const yearlyBtn = document.getElementById('billYearly');
        const priceEls = document.querySelectorAll('[data-price]');
        const periodEls = document.querySelectorAll('span.text-white\\/60, span.dark\\:text-gray-600');

        // ------- Helpers -------
        function setActive(btn, active) {
            btn.classList.toggle('bg-[#1a2640]', active);
            btn.classList.toggle('dark:bg-gray-800', active);
            btn.classList.toggle('border', active);
            btn.classList.toggle('border-white/10', active);
            btn.classList.toggle('dark:border-gray-400', active);
            btn.classList.toggle('text-white', active);
            btn.classList.toggle('dark:text-gray-100', active);
        }

        function asCurrency(v) {
            return '£' + v.toString();
        }

        function applyBilling(mode) {
            priceEls.forEach(el => {
                const month = Number(el.dataset.month || 0);
                let display = month;
                let periodText = '/month';
                if (mode === 'yearly') {
                    display = Math.round(month * 12 * 0.8); // 20% off
                    periodText = '/yearly';
                }
                el.textContent = asCurrency(display);
                // Find the sibling span showing "/month" and update it
                const sibling = el.nextElementSibling;
                if (sibling && sibling.tagName === 'SPAN') {
                    sibling.textContent = periodText;
                    sibling.classList.add('text-white/60', 'dark:text-gray-600');
                }
            });

            // Visual toggle
            if (mode === 'yearly') {
                setActive(yearlyBtn, true);
                setActive(monthlyBtn, false);
            } else {
                setActive(monthlyBtn, true);
                setActive(yearlyBtn, false);
            }
        }

        // ------- Events -------
        monthlyBtn.addEventListener('click', () => applyBilling('monthly'));
        yearlyBtn.addEventListener('click', () => applyBilling('yearly'));
        applyBilling('monthly');
    </script>
@endsection
