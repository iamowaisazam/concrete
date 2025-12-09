@extends('web.partial.layout')

@section('css')
@endsection

@section('content')
    <!-- 🌟 Hero Section -->
    <section class="relative overflow-hidden bg-[#000F21]">
        <div class="container mx-auto px-6 py-20 lg:py-28">
            <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-10 lg:gap-14 min-h-[70vh]">

                <!-- Left: Text -->
                <div class="flex-1 max-w-3xl text-center lg:text-left animate-fade-in text-white ">

                    <!-- Heading -->
                    <h1 class="text-4xl md:text-6xl font-extrabold leading-[1.05] tracking-tight mb-5">
                        Agency <br class="hidden md:block" /><span class="text-[#0080ff]">Management</span>
                    </h1>

                    <!-- UL -->
                    <ul class="space-y-3 mt-6">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Compare listings
                            side-by-side</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Filter by make,
                            model, year, mileage</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Instantly see
                            which auction has the best deals</li>
                    </ul>
                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start mt-8">
                        <a href="#"
                            class="px-6 py-3 rounded font-semibold text-white bg-[#0080ff] hover:bg-[#006fe0] transition shadow-lg shadow-[#0080ff]/30">
                            Get Started
                        </a>
                    </div>
                </div>

                <!-- Right: Image -->
                <div class="relative flex justify-center">
                    <img src="{{ asset('public/theme/assets/web/images/Reauction.png') }}" alt="Reauction Illustration"
                        class="w-full max-w-4xl  object-cover rounded-xl transform" />
                </div>

            </div>
        </div>
    </section>


    <!-- ⚡ With vs Without Section -->
    <section class="min-h-screen flex items-center bg-[#0b1624] dark:bg-gray-50 text-white dark:text-gray-900 py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">The secret to your team's success</h2>
            <p class="text-gray-400 dark:text-gray-600 max-w-2xl mx-auto mb-12">
                Gain insights into thousands of vehicle auctions and make smarter bidding decisions.<br>
                Subscribe to access full auction data across the nation.
            </p>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Without Autoboli -->
                <div
                    class="rounded-2xl border border-white/10 dark:border-gray-200 p-8 bg-[#0f1c2c] dark:bg-white/80 text-left">
                    <h3 class="text-2xl font-bold mb-6">Without <span class="text-[#0080ff]">AutoBoli</span></h3>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-xmark text-red-500"></i>Compare listings
                            side-by-side</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-xmark text-red-500"></i>Filter by make,
                            model, year, mileage</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-xmark text-red-500"></i>Instantly see
                            which auction has the best deals</li>
                    </ul>
                </div>

                <!-- With Autoboli -->
                <div
                    class="rounded-2xl border border-white/10 dark:border-gray-200 p-8 bg-[#0b172a] dark:bg-gray-100 text-left">
                    <h3 class="text-2xl font-bold mb-6">With <span class="text-[#0080ff]">AutoBoli</span></h3>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Compare listings
                            side-by-side</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Filter by make,
                            model, year, mileage</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Instantly see
                            which auction has the best deals</li>
                    </ul>
                </div>
            </div>

            <button
                class="mt-10 bg-[#0080ff] hover:bg-[#006fe0] text-white font-semibold px-8 py-3 rounded-lg shadow-lg shadow-[#0080ff]/30 transition">
                Get Started
            </button>
        </div>
    </section>

    <!-- 🚗 Feature Highlights -->
    <section class="py-20 bg-[#0f1c2c] dark:bg-gray-100 text-white dark:text-gray-900">
        <div class="max-w-7xl mx-auto px-6 space-y-24">
            <!-- Feature 1 -->
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <span class="bg-[#0080ff]/20 text-[#0080ff] px-3 py-1 rounded-full text-sm font-semibold">Feature</span>
                    <h2 class="text-3xl md:text-4xl font-bold leading-tight">Find the Best Auction for Your Next Buy</h2>
                    <p class="text-gray-400 dark:text-gray-600">Stop bouncing between dozens of websites. <br>AutoBoli
                        brings together UK auctions into a single, streamlined platform.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Compare listings
                            side-by-side</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Filter by make,
                            model, year, mileage</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Instantly see
                            which auction has the best deals</li>
                    </ul>
                    <a href="#"
                        class="inline-block mt-4 bg-[#0080ff] hover:bg-[#006fe0] text-white font-semibold px-6 py-3 rounded shadow-lg shadow-[#0080ff]/30 transition">
                        Use this Feature
                    </a>
                </div>
                <div>
                    <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" class="rounded-2xl shadow-2xl"
                        alt="Feature preview">
                </div>
            </div>

            <!-- Feature 2 (reverse layout) -->
            <div class="grid md:grid-cols-2 gap-12 items-center md:flex-row-reverse">
                <div>
                    <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" class="rounded-2xl shadow-2xl"
                        alt="Feature preview">
                </div>
                <div class="space-y-6">
                    <span class="bg-[#0080ff]/20 text-[#0080ff] px-3 py-1 rounded-full text-sm font-semibold">Feature</span>
                    <h2 class="text-3xl md:text-4xl font-bold leading-tight">Analyze Market Trends Instantly</h2>
                    <p class="text-gray-400 dark:text-gray-600">Get detailed insights into current vehicle prices, upcoming
                        auctions, and the best opportunities for your next investment.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Real-time
                            auction data</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Visual analytics
                            dashboard</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-check text-[#0080ff]"></i>Personalized
                            recommendations</li>
                    </ul>
                    <a href="#"
                        class="inline-block mt-4 bg-[#0080ff] hover:bg-[#006fe0] text-white font-semibold px-6 py-3 rounded shadow-lg shadow-[#0080ff]/30 transition">
                        Use this Feature
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 🌟 Explore Section -->
    <section class="py-20 bg-[#0b1624] dark:bg-white/80 text-white dark:text-gray-900">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-10">Explore More</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @for ($i = 0; $i < 5; $i++)
                    <div
                        class="bg-[#0f1c2c] dark:bg-gray-100 rounded-xl p-6 border border-white/10 dark:border-gray-300 hover:border-[#0080ff] hover:shadow-lg hover:shadow-[#0080ff]/20 transition">
                        <div class="flex flex-col items-center text-center space-y-4">
                            <i class="fas fa-asterisk text-[#0080ff] text-3xl"></i>
                            <p class="font-semibold">Use this Feature</p>
                        </div>
                    </div>
                @endfor

                <!-- View All -->
                <div
                    class="bg-[#0b172a] dark:bg-gray-50 rounded-xl p-6 border border-white/10 dark:border-gray-300 hover:border-[#0080ff] transition flex items-center justify-center">
                    <button class="flex items-center gap-3 text-[#0080ff] font-semibold">
                        View All <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
