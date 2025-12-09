@extends('web.partial.layout')



@section('css')
@endsection

@section('content')
    <section class="relative overflow-hidden flex flex-col justify-center bg-[#000f21]">

        <div class="container mx-auto px-6 py-20 lg:py-28">
            <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-10 lg:gap-14 min-h-[70vh]">
                <!-- Left: Text -->
                <div class="flex-1 max-w-3xl text-center lg:text-left animate-in-left">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10  border border-[#353F4C] mb-5">
                        <div class="flex -space-x-2">
                            <img alt="dealer" class="w-6 h-6 rounded-full ring-2 ring-black/5 "
                                src="https://i.pravatar.cc/24?img=11" />
                            <img alt="dealer" class="w-6 h-6 rounded-full ring-2 ring-black/5 "
                                src="https://i.pravatar.cc/24?img=22" />
                            <img alt="dealer" class="w-6 h-6 rounded-full ring-2 ring-black/5 "
                                src="https://i.pravatar.cc/24?img=33" />
                        </div>
                        <span class="text-xs md:text-sm text-white">3,000+
                            dealers trust AutoBoli</span>
                    </div>

                    <h1 class="text-4xl md:text-6xl font-extrabold leading-[1.05] tracking-tight mb-5 text-white ">
                        Smarter Vehicle Auction Insights - All in One Place
                    </h1>

                    <p class="text-[#B2C0CE] text-lg xl max-w-xl mx-auto lg:mx-0">
                        Stay ahead of the market with real-time UK vehicle auction data,
                        transparent valuations, and powerful tools designed for dealers,
                        traders, and smart buyers.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start mt-8">
                        <a href="#"
                            class="bttn px-6 py-3 rounded font-semibold text-white transition shadow-lg shadow-orange-500/25 texc">
                            Explore Auctions
                        </a>
                        <a href="#"
                            class="px-6 py-3 rounded font-semibold border border-gray-500 bg-white/10 text-white hover:bg-white/20 backdrop-blur-md transition">
                            Start Free Trial
                        </a>
                    </div>

                    <div class="mt-6 text-lg text-[#B2C0CE] ">
                        No card required • Cancel anytime • UK & JP auction coverage
                    </div>
                </div>
                <img src="{{ asset('public/theme/assets/web/images/Reauction.png') }}" alt
                    class="absolute -right-60 bottom-12 w-auto hidden xl:block xl:h-[550px] 2xl:h-[800px]  object-cover pointer-events-none -rotate-6 rounded-md" />
            </div>
        </div>
    </section>

    <div class="bg-[#f5f6f7] dark:bg-[#0f1c2c]">
        <section class="w-full  mx-auto space-y-8 py-20">
            <!-- Big Companies -->
            <div class="mx-auto max-w-md  lg:max-w-7xl flex gap-x-5 lg:gap-x-24 items-center justify-between">
                <img src="https://imgs.search.brave.com/xrplqjvdppbclNQwn6dchA3Lv3ysy0nZ6AcJRMW9nYo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/cG5nYWxsLmNvbS93/cC1jb250ZW50L3Vw/bG9hZHMvMTMvWm9v/bS1Mb2dvLnBuZw"
                    width="8%" alt />
                <img src="https://imgs.search.brave.com/0SrVHhsedWleOhtFNh7fto6Pi7OxgRZYqGYnL7_r83Y/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9sb2dv/cy13b3JsZC5uZXQv/d3AtY29udGVudC91/cGxvYWRzLzIwMjAv/MDkvTWljcm9zb2Z0/LUxvZ28tNzAweDM5/NC5wbmc"
                    width="8%" alt />
                <img src="https://imgs.search.brave.com/iHP_N0Ge4jJwhzj8ePuxt-LpPolPpM6TdyrPfXGO480/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/d29ybGR2ZWN0b3Js/b2dvLmNvbS9sb2dv/cy90ZWFtdmlld2Vy/LTEuc3Zn"
                    width="8%" alt />
                <img src="https://imgs.search.brave.com/iZc28wQP3v6Pdr3RXfwYzVyRZNNmMe2lU39zHxPu0Yw/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/bG9nb2pveS5jb20v/d3AtY29udGVudC91/cGxvYWRzLzIwMjMw/ODAxMTQ1NjA4L0N1/cnJlbnQtR29vZ2xl/LWxvZ28tMjAxNS0y/MDIzLTYwMHgyMDMu/cG5n"
                    width="8%" alt />
                <img src="https://imgs.search.brave.com/6k4RKxb1RaLm-C44SumcKeV0hAxylJP4gk4QnQ-Lvl8/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly8xMDAw/bG9nb3MubmV0L3dw/LWNvbnRlbnQvdXBs/b2Fkcy8yMDIxLzA2/L1NsYWNrLWxvZ28t/NTAweDI4MS5wbmc"
                    width="8%" alt />
            </div>
        </section>

        <section class="relative py-20 md:py-28">
            <div class="max-w-7xl mx-auto px-6 grid gap-12 lg:grid-cols-2 lg:items-center">

                <!-- Left: copy -->
                <div>
                    <div class="inline-flex items-center gap-2 px-5 py-1 rounded bg-[#0080ff]/20   mb-5">
                        <p class="text-xs md:text-lg text-[#0080ff] text-center">Vision</p>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-extrabold leading-tight dark:text-white">
                        Our Vision.
                    </h2>

                    <!-- underline -->
                    <div class="mt-6 h-1 w-16 rounded bg-[#0080ff]"></div>

                    <div class="mt-8 space-y-6 text-slate-600 leading-8 text-lg ">
                        <p>
                            At Autoboli, our vision is simple:
                            To empower dealers and traders with transparent, real-time auction data and insights that help
                            them make smarter, faster, and more profitable decisions
                        </p>
                        <p>
                            We believe in transforming the automotive trade industry with clarity, innovation, and
                            intelligence
                        </p>
                    </div>
                </div>

                <!-- Right: dotted bg + statement card -->
                <div class="relative">
                    <!-- dotted field -->
                    <div
                        class="absolute inset-y-0 right-0 w-[85%] rounded-3xl pointer-events-none
               bg-[radial-gradient(#e5e7eb_1px,transparent_1px)]
               [background-size:14px_14px]">
                    </div>

                    <!-- statement card -->
                    <div
                        class="relative ml-auto max-w-2xl bg-white dark:bg-[#000f21] rounded-2xl md:rounded-3xl p-6 md:p-10
               shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] ring-1 ring-black/5">
                        <p class="text-3xl md:text-5xl font-extrabold leading-[1.15] text-slate-800">
                            <span class="text-[#0080ff]">Save people<br class="hidden md:block"> time</span>
                            by making<br class="hidden md:block"> the world more<br class="hidden md:block"> productive.
                        </p>
                    </div>
                </div>

            </div>
        </section>



    </div>
    <!-- FEATURES -->
    <section id="features" class="relative py-16 md:py-24 bg-white dark:bg-[#000f21]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-20">
                <div class="space-y-10">
                    <div class="space-y-9">
                        <h1 class="text-4xl lg:text-5xl font-extrabold capitalize dark:text-white">Key Features</h1>
                    </div>
                    <div class="bg-[#f5f6f7] dark:bg-[#0f1c2c] rounded-3xl">
                        <div class="flex flex-col justify-around items-start gap-5 gap-y-8">
                            <img src="https://templates.studioniskala.com/finovia/wp-content/uploads/sites/3/2025/01/Image-U69J8Y7.jpg"
                                alt class="rounded-3xl h-64 w-full object-cover">
                            <div class="rounded-3xl p-8 flex flex-col gap-y-5 justify-between w-full">
                                <h2 class="text-2xl font-semibold text-black dark:text-white capitalize">Live Auction
                                    Insights</h2>
                                <p class="max-w-lg font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                    Track upcoming, live, and historical auctions with
                                    complete transparency. See what’s selling, at what price,
                                    and where.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#f5f6f7] dark:bg-[#0f1c2c] rounded-3xl">
                        <div class="flex flex-col justify-around items-start gap-5 gap-y-8">
                            <img src="https://templates.studioniskala.com/finovia/wp-content/uploads/sites/3/2025/01/Image-U69J8Y7.jpg"
                                alt class="rounded-3xl h-64 w-full object-cover">
                            <div class="rounded-3xl p-8 flex flex-col gap-y-5 justify-between w-full">
                                <h2 class="text-2xl font-semibold text-black dark:text-white capitalize">Advance Auction
                                    Finder</h2>
                                <p class="max-w-lg font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                    Filter through thousands of auction lots with smart search
                                    tools to find exactly what you’re looking for.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#f5f6f7] dark:bg-[#0f1c2c] rounded-3xl">
                        <div class="flex flex-col justify-around items-start gap-5 gap-y-8">
                            <img src="https://templates.studioniskala.com/finovia/wp-content/uploads/sites/3/2025/01/Image-U69J8Y7.jpg"
                                alt class="rounded-3xl h-64 w-full object-cover">
                            <div class="rounded-3xl p-8 flex flex-col gap-y-5 justify-between w-full">
                                <h2 class="text-2xl font-semibold text-black dark:text-white capitalize">Auction Schedules
                                </h2>
                                <p class="max-w-lg font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                    Plan ahead with a calendar view of upcoming auctions.
                                    Bookmark events, filter by region or type, and set up
                                    alerts.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="relative overflow-hidden rounded-3xl p-10 
            bg-[#f5f6f7] dark:bg-[#0f1c2c] 
            border border-gray-200/70 dark:border-white/10 
            shadow-[0_12px_30px_-12px_rgba(0,0,0,0.25)] 
            transition-all duration-500 
            transform hover:-translate-y-1 hover:shadow-xl 
            opacity-0 translate-y-6 animate-fadeUp">

                        <h2 class="text-xl md:text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                            Uncover New Horizons
                        </h2>

                        <button
                            class="bttn inline-flex items-center gap-x-2 px-6 py-3 mt-6 rounded
                 text-white text-lg font-semibold 
                 shadow-md hover:shadow-lg active:scale-95 
                 transition-all duration-300">
                            <span>Explore</span>
                            <img src="{{ asset('public/theme/assets/web/images/next.png') }}" width="20" alt
                                class="transition-transform duration-300 group-hover:translate-x-1" />
                        </button>
                    </div>
                </div>
                <div class="space-y-10">
                    <div class="bg-[#f5f6f7] dark:bg-[#0f1c2c] rounded-3xl">
                        <div class="flex flex-col justify-around items-start gap-5 gap-y-8">
                            <img src="https://templates.studioniskala.com/finovia/wp-content/uploads/sites/3/2025/01/Image-U69J8Y7.jpg"
                                alt class="rounded-3xl h-64 w-full object-cover">
                            <div class="rounded-3xl p-8 flex flex-col gap-y-5 justify-between w-full">
                                <h2 class="text-2xl font-semibold text-black dark:text-white capitalize">Vehicle Valuation
                                    Made Simple</h2>
                                <p class="max-w-lg font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                    Get instant valuations with CAP Clean, CAP Average, Below
                                    Market, Auction Prices, and Autoboli’s Predicted Value
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#f5f6f7] dark:bg-[#0f1c2c] rounded-3xl">
                        <div class="flex flex-col justify-around items-start gap-5 gap-y-8">
                            <img src="https://templates.studioniskala.com/finovia/wp-content/uploads/sites/3/2025/01/Image-U69J8Y7.jpg"
                                alt class="rounded-3xl h-64 w-full object-cover">
                            <div class="rounded-3xl p-8 flex flex-col gap-y-5 justify-between w-full">
                                <h2 class="text-2xl font-semibold text-black dark:text-white capitalize">Reauction Tracker
                                </h2>
                                <p class="max-w-lg font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                    Spot vehicles that didn’t sell earlier but are back again.
                                    Learn why they returned and decide if they’re worth
                                    bidding on now.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#f5f6f7] dark:bg-[#0f1c2c] rounded-3xl">
                        <div class="flex flex-col justify-around items-start gap-5 gap-y-8">
                            <img src="https://templates.studioniskala.com/finovia/wp-content/uploads/sites/3/2025/01/Image-U69J8Y7.jpg"
                                alt class="rounded-3xl h-64 w-full object-cover">
                            <div class="rounded-3xl p-8 flex flex-col gap-y-5 justify-between w-full">
                                <h2 class="text-2xl font-semibold text-black dark:text-white capitalize">Compare Auctions
                                </h2>
                                <p class="max-w-lg font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                    Side-by-side comparisons of prices, results, and trends
                                    across auction houses to find the best opportunities.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[#f5f6f7] dark:bg-[#0f1c2c] rounded-3xl">
                        <div class="flex flex-col justify-around items-start gap-5 gap-y-8">
                            <img src="https://templates.studioniskala.com/finovia/wp-content/uploads/sites/3/2025/01/Image-U69J8Y7.jpg"
                                alt class="rounded-3xl h-64 w-full object-cover">
                            <div class="rounded-3xl p-8 flex flex-col gap-y-5 justify-between w-full">
                                <h2 class="text-2xl font-semibold text-black dark:text-white capitalize">Personalized
                                    Dashboard
                                </h2>
                                <p class="max-w-lg font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                    Stay in control with your own dashboard featuring:
                                    <li class="text-[#353F4C] dark:text-[#B2C0CE]">Overview of auction trends</li>
                                    <li class="text-[#353F4C] dark:text-[#B2C0CE]">Interest-based summaries</li>
                                    <li class="text-[#353F4C] dark:text-[#B2C0CE]">Watchlist with alerts & notifications
                                    </li>

                                    </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-36 bg-[#f5f6f7] dark:bg-[#0f1c2c]">
        <div class="mx-auto max-w-7xl px-4">
            <!-- Purple container -->
            <div class="relative rounded-3xl bttn p-4 sm:p-6 md:p-8 lg:p-10">
                <h2 class="text-4xl lg:text-5xl font-extrabold capitalize mb-6 md:mb-8 text-center text-white">
                    Why Choose Autoboli?
                </h2>

                <!-- Carousel -->
                <div class="relative">

                    <!-- track -->
                    <div id="resTrack"
                        class="scroll-px-4 -mx-4 px-4 flex gap-6 overflow-x-auto snap-x snap-mandatory h-[500px]
                              [scrollbar-width:none] [&::-webkit-scrollbar]:hidden items-stretch">

                        <!-- CARD 1 -->
                        <article class="min-w-[80%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[32%] snap-start flex">
                            <div
                                class="flex flex-col justify-between rounded-3xl overflow-hidden bg-white dark:bg-[#000f21] 
                                      shadow-[0_10px_25px_-10px_rgba(0,0,0,.25)] w-full h-full">
                                <div
                                    class="h-44 md:h-52 bg-[url('https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=1200&auto=format&fit=crop')] bg-cover bg-center">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <span class="text-2xl font-semibold text-black dark:text-white capitalize">Live Auction
                                        Data</span>
                                    <h3 class="mt-2 font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                        Track ongoing auctions with real-time updates.
                                    </h3>
                                </div>
                            </div>
                        </article>


                        <!-- CARD 2 -->
                        <article class="min-w-[80%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[32%] snap-start">
                            <div
                                class="flex flex-col justify-between rounded-3xl overflow-hidden bg-white dark:bg-[#000f21] 
                                        shadow-[0_10px_25px_-10px_rgba(0,0,0,.25)] w-full h-full">
                                <div
                                    class="h-44 md:h-52 bg-[url('https://images.unsplash.com/photo-1545239351-1141bd82e8a6?q=80&w=1200&auto=format&fit=crop')] bg-cover bg-center">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <span class="text-2xl font-semibold text-black dark:text-white capitalize">Valuation
                                        Tools</span>
                                    <h3 class="mt-2 font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                        Compare CAP clean, average, below, and Autoboli’s own smart predicted values
                                    </h3>
                                </div>
                            </div>
                        </article>

                        <!-- CARD 3 -->
                        <article class="min-w-[80%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[32%] snap-start">
                            <div
                                class="flex flex-col justify-between rounded-3xl overflow-hidden bg-white dark:bg-[#000f21] 
                                        shadow-[0_10px_25px_-10px_rgba(0,0,0,.25)] w-full h-full">
                                <div
                                    class="h-44 md:h-52 bg-[url('https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?q=80&w=1200&auto=format&fit=crop')] bg-cover bg-center">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <span class="text-2xl font-semibold text-black dark:text-white capitalize">Full Vehicle
                                        Intelligence</span>
                                    <h3 class="mt-2 font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                        From inspection reports to pricing history and future trends, all in one place.
                                    </h3>
                                </div>
                            </div>
                        </article>
                        <!-- CARD 4 -->
                        <article class="min-w-[80%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[32%] snap-start">
                            <div
                                class="flex flex-col justify-between rounded-3xl overflow-hidden bg-white dark:bg-[#000f21] 
                                        shadow-[0_10px_25px_-10px_rgba(0,0,0,.25)] w-full h-full">
                                <div
                                    class="h-44 md:h-52 bg-[url('https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?q=80&w=1200&auto=format&fit=crop')] bg-cover bg-center">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <span class="text-2xl font-semibold text-black dark:text-white capitalize">Smart
                                        Filters & Search</span>
                                    <h3 class="mt-2 font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                        Save time by quickly finding vehicles that match your business needs
                                    </h3>
                                </div>
                            </div>
                        </article>
                        <!-- CARD 5 -->
                        <article class="min-w-[80%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[32%] snap-start">
                            <div
                                class="flex flex-col justify-between rounded-3xl overflow-hidden bg-white dark:bg-[#000f21] 
                                        shadow-[0_10px_25px_-10px_rgba(0,0,0,.25)] w-full h-full">
                                <div
                                    class="h-44 md:h-52 bg-[url('https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?q=80&w=1200&auto=format&fit=crop')] bg-cover bg-center">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <span class="text-2xl font-semibold text-black dark:text-white capitalize">Reauction
                                        Tracker</span>
                                    <h3 class="mt-2 font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                        Know when a vehicle reappears and why.
                                    </h3>
                                </div>
                            </div>
                        </article>
                        <!-- CARD 6 -->
                        <article class="min-w-[80%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[32%] snap-start">
                            <div
                                class="flex flex-col justify-between rounded-3xl overflow-hidden bg-white dark:bg-[#000f21] 
                                        shadow-[0_10px_25px_-10px_rgba(0,0,0,.25)] w-full h-full">
                                <div
                                    class="h-44 md:h-52 bg-[url('https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?q=80&w=1200&auto=format&fit=crop')] bg-cover bg-center">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <span class="text-2xl font-semibold text-black dark:text-white capitalize">VIN & Reg
                                        Lookup</span>
                                    <h3 class="mt-2 font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                        Access deep inspection reports, ownership history, and accident records instantly
                                    </h3>
                                </div>
                            </div>
                        </article>
                        <!-- CARD 7 -->
                        <article class="min-w-[80%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[32%] snap-start">
                            <div
                                class="flex flex-col justify-between rounded-3xl overflow-hidden bg-white dark:bg-[#000f21] 
                                        shadow-[0_10px_25px_-10px_rgba(0,0,0,.25)] w-full h-full">
                                <div
                                    class="h-44 md:h-52 bg-[url('https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?q=80&w=1200&auto=format&fit=crop')] bg-cover bg-center">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <span class="text-2xl font-semibold text-black dark:text-white capitalize">Compare
                                        Auctions</span>
                                    <h3 class="mt-2 font-medium text-lg text-[#353F4C] dark:text-[#B2C0CE]">
                                        Side-by-side comparison across auction houses for the best deals.Autoboli is your
                                        one-stop hub for smarter decisions and stronger profits.
                                    </h3>
                                </div>
                            </div>
                        </article>


                    </div>
                    <!-- prev -->
                    <button id="resPrev"
                        class="absolute right-12 -top-14 md:-left-10 md:top-40 h-10 w-10 rounded-full bg-white shadow-md ring-1 ring-black/5 grid place-items-center hover:scale-105 transition "
                        aria-label="Previous">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <!-- next -->
                    <button id="resNext"
                        class="absolute right-0 -top-14 md:-right-10 md:top-40 h-10 w-10 rounded-full bg-white shadow-md ring-1 ring-black/5 grid place-items-center hover:scale-105 transition"
                        aria-label="Next">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Traders and Dealers -->
    <section class="bg-white dark:bg-[#000f21] py-28">
        <div class="max-w-7xl mx-auto text-center">
            <div class="space-y-8">
                <h2 class="text-4xl lg:text-5xl font-extrabold capitalize dark:text-white">Trusted by Dealers & Traders
                </h2>
                <p class="text-lg text-gray-800 dark:text-white max-w-screen-lg mx-auto">
                    Autoboli is built for professionals who value time and data accuracy.
                    Our platform handles thousands of listings daily, ensuring you never miss a deal.
                </p>
            </div>
            <section class="py-16">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:gap-4">

                        <!-- Card 1 – blue fill -->
                        <article
                            class="mt-8 rounded-xl bttn dark:bg-[#0f1c2c] text-[#0a1a2b] p-8 flex flex-col justify-between h-96">
                            <h3 class="text-5xl md:text-6xl font-normal leading-none text-left">
                                <span class="text-4xl lg:text-5xl font-extrabold capitalize counter text-white"
                                    data-target="123">0</span><span class="text-white">+</span>
                            </h3>
                            <div class="mt-8 text-left">
                                <h4 class="text-lg font-medium text-white">Projects Completed</h4>
                                <p class="mt-3 text-white text-lg">Lorem ipsum dolor sit amet, cons ectetur , luctus nec
                                </p>
                            </div>
                        </article>

                        <!-- Card 2 – outlined -->
                        <article
                            class="rounded-xl border border-black dark:border-white text-[#0a1a2b] p-8 flex flex-col justify-between h-96">
                            <h3 class="text-5xl md:text-6xl font-normal leading-none text-left dark:text-white">
                                <span class="text-4xl lg:text-5xl font-extrabold capitalize counter"
                                    data-target="75">0</span><span class="dark:text-white">+</span>
                            </h3>
                            <div class="mt-8 text-left">
                                <h4 class="text-lg font-medium text-[#06203A] dark:text-white">Strong
                                    Client<br />Relationships</h4>
                                <p class="mt-3 text-[#0a1a2b]/70 dark:text-white text-lg">Lorem ipsum dolor sit amet, cons
                                    ectetur , luctus nec</p>
                            </div>
                        </article>

                        <!-- Card 3 – blue fill -->
                        <article
                            class="mt-8 rounded-xl bttn dark:bg-[#0f1c2c] text-[#0a1a2b] dark:text-white p-8 flex flex-col justify-between h-96">
                            <h3 class="text-5xl md:text-6xl font-normal leading-none text-left dark:text-white">
                                <span class="text-4xl lg:text-5xl font-extrabold capitalize counter text-white"
                                    data-target="155">0</span><span class="text-white">+</span>
                            </h3>
                            <div class="mt-8 text-left">
                                <h4 class="text-lg font-medium text-white">
                                    Expertise Across<br />Multiple Channels
                                </h4>
                                <p class="mt-3 text-white text-lg">Lorem ipsum dolor sit amet, cons ectetur , luctus nec
                                </p>
                            </div>
                        </article>

                        <!-- Card 4 – outlined -->
                        <article
                            class="rounded-xl border border-black dark:border-white p-8 flex flex-col justify-between h-96">
                            <h3 class="text-5xl md:text-6xl font-normal leading-none text-left dark:text-white">
                                <span class="text-4xl lg:text-5xl font-extrabold capitalize counter"
                                    data-target="120">0</span><span>+</span>
                            </h3>
                            <div class="mt-8 text-left">
                                <h4 class="text-lg font-medium text-[#06203A] dark:text-white">
                                    Outstanding<br />Customer Service
                                </h4>
                                <p class="mt-3 text-lg dark:text-white">Lorem ipsum dolor sit amet, cons ectetur , luctus
                                    nec</p>
                            </div>
                        </article>

                    </div>
                </div>
            </section>

        </div>
    </section>



    <!-- CALL TO ACTION -->
    <!-- ClickUp-style Promo Banner -->
    <section class="py-28 bg-[#f5f6f7] dark:bg-[#0f1c2c]">
        <div class="mx-auto max-w-7xl px-4">
            <div
                class="relative flex flex-col lg:flex-row items-center justify-between overflow-hidden rounded-[24px] bttn  text-white ">

                <!-- Left Content -->
                <div class="relative z-10  space-y-6 p-8 lg:p-12">
                    <!-- Logo -->
                    <div class="flex items-center gap-2">
                        <img src="/assets/images/nave-icon.png" alt="">
                    </div>

                    <!-- Headline -->
                    <h2 class="text-4xl sm:text-5xl font-bold leading-[1.05] tracking-tight text-white">
                        Start Winning Smarter, <br> Not Harder.
                    </h2>

                    <!-- Subtext -->
                    <p class="text-lg text-white">
                        Join Autoboli today and experience the power of intelligent auction insights.

                    </p>

                    <!-- CTA Button -->
                    <a href="#"
                        class="inline-flex items-center gap-2 rounded bg-white px-6 py-3 font-semibold text-black shadow-lg hover:shadow-xl hover:bg-white/90 transition">
                        Get started. It’s FREE
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Right Image (Fixed to Bottom-Right) -->
                <div class="relative w-full lg:w-1/2 mt-10 lg:mt-0 flex items-end justify-end">
                    <img src="https://images.ctfassets.net/w8fc6tgspyjz/48U3fEhpi2LVBEmCuC4hF/bf29abf01c4e8633048df708c51c8b97/supercharge-your-productivity.png"
                        alt="App preview"
                        class="absolute -bottom-60 right-0 w-full max-w-[600px] lg:max-w-none object-cover rounded-br-[24px]" />
                </div>

                <!-- Subtle Gradient Glow -->
                <div
                    class="pointer-events-none absolute bottom-0 right-0 w-[80%] h-[100%] bg-[radial-gradient(ellipse_at_bottom_right,rgba(168,85,247,.35),rgba(59,130,246,.25),transparent_70%)]">
                </div>

            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
