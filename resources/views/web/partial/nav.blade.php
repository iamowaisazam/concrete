    <header id="siteNav" class="sticky top-0 z-40 transition-all duration-300 bg-[#000f21] border-b border-[#353F4C]">
        <nav class="container h-14  mx-auto flex items-center justify-between px-5 lg:px-0">

            <!-- Logo -->
            <div>
                <a href="{{ url('/') }}"> <img src="{{ asset('public/theme/assets/web/images/nave-icon.png') }}"
                        width="140" alt="Logo" /></a>
            </div>

            <!-- Nav Links -->
            <div class="space-x-5 hidden lg:flex items-center justify-center font-medium h-full">
                <a class="flex items-center justify-center h-full  border-0 hover:border-b hover:border-b-[#0080ff] text-gray-500  hover:text-white    {{ Request::is('autionshadule') ? 'active' : '' }}"
                    href="{{ url('/autionshadule') }}">Auction Solutions</a>
                <a class="flex items-center justify-center h-full  border-0 hover:border-b hover:border-b-[#0080ff] text-gray-500  hover:text-white {{ Request::is('features') ? 'active' : '' }}"
                    href="{{ url('/features') }}">Features</a>
                <a href="{{ url('/pricing') }}"
                    class="flex items-center justify-center h-full  border-0 hover:border-b hover:border-b-[#0080ff] text-gray-500  hover:text-white {{ Request::is('/pricing') ? 'active' : '' }}">Pricing</a>
                <!-- Explore (mega dropdown) -->
                <div x-data="{ open: false }" @click.away="open = false" class="relative group h-full">
                    <a href="#" @click.prevent="open = !open"
                        class="flex items-center justify-center h-full  border-0 hover:border-b hover:border-b-[#0080ff] text-gray-500  hover:text-white">
                        Explore
                        <span class="ml-1 material-symbols-outlined text-xs transition-transform duration-200"
                            :class="{ 'rotate-180': open }">expand_more</span>
                    </a>

                    <!-- Panel -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute left-1/2 -translate-x-1/2 top-full mt-3 w-[min(800px,92vw)] rounded-xl border border-white/10 bg-[#0f1c2c] text-white shadow-2xl z-50">
                        <div class="p-5 md:p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- card -->
                                <a href="#"
                                    class="block rounded-lg border border-white/10 hover:border-[#0080ff] bg-[#0b1624] p-4 transition">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-[#0080ff]">emoji_objects</span>
                                        <div>
                                            <div class="font-semibold">Resorose</div>
                                            <p class="text-sm text-white/60">Lorem ipsum dolor sit, amet consectetur
                                                adipisicing elit.</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#"
                                    class="block rounded-lg border border-white/10 hover:border-[#0080ff] bg-[#0b1624] p-4 transition">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-[#0080ff]">emoji_objects</span>
                                        <div>
                                            <div class="font-semibold">Resorose</div>
                                            <p class="text-sm text-white/60">Molestiae, autem. Debitis, libero?</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#"
                                    class="block rounded-lg border border-white/10 hover:border-[#0080ff] bg-[#0b1624] p-4 transition">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-[#0080ff]">emoji_objects</span>
                                        <div>
                                            <div class="font-semibold">Resorose</div>
                                            <p class="text-sm text-white/60">Adipisicing elit. Debitis aliquid.</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#"
                                    class="block rounded-lg border border-white/10 hover:border-[#0080ff] bg-[#0b1624] p-4 transition">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-[#0080ff]">emoji_objects</span>
                                        <div>
                                            <div class="font-semibold">Resorose</div>
                                            <p class="text-sm text-white/60">Lorem ipsum dolor sit amet.</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#"
                                    class="block rounded-lg border border-white/10 hover:border-[#0080ff] bg-[#0b1624] p-4 transition">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-[#0080ff]">emoji_objects</span>
                                        <div>
                                            <div class="font-semibold">Resorose</div>
                                            <p class="text-sm text-white/60">Molestiae, autem. Debitis, libero?</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#"
                                    class="block rounded-lg border border-white/10 hover:border-[#0080ff] bg-[#0b1624] p-4 transition">
                                    <div class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-[#0080ff]">emoji_objects</span>
                                        <div>
                                            <div class="font-semibold">Resorose</div>
                                            <p class="text-sm text-white/60">Adipisicing elit. Debitis aliquid.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- footer bar -->
                        <div class="px-5 pb-5">
                            <a href="#"
                                class="block w-full text-center rounded-md bg-[#0b1624] border border-white/10 text-white py-3 hover:border-[#0080ff] transition">
                                Explore More
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Resources (mega dropdown) -->
                <div x-data="{ open: false }" @click.away="open = false" class="relative group h-full">
                    <a href="#" @click.prevent="open = !open"
                        class="flex items-center justify-center h-full border-0 hover:border-b hover:border-b-[#0080ff] text-gray-500 hover:text-white">
                        Resources
                        <span class="ml-1 material-symbols-outlined text-xs transition-transform duration-200"
                            :class="{ 'rotate-180': open }">expand_more</span>
                    </a>

                    <!-- Panel -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute left-1/2 -translate-x-1/2 top-full mt-3 w-[min(800px,92vw)] rounded-xl border border-white/10 bg-[#0f1c2c] text-white shadow-2xl z-50"
                        @click.stop>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                                <!-- Learn -->
                                <div>
                                    <div class="text-sm uppercase tracking-wide text-white/70 mb-3">Learn</div>
                                    <ul class="space-y-2">
                                        <li><a href="#" class="flex items-center gap-2 hover:text-white"><span
                                                    class="w-2 h-2 rounded-sm bg-[#0080ff]"></span> Guidance</a></li>
                                        <li><a href="#" class="flex items-center gap-2 hover:text-white"><span
                                                    class="w-2 h-2 rounded-sm bg-[#0080ff]"></span> How to use</a></li>
                                        <li><a href="#" class="flex items-center gap-2 hover:text-white"><span
                                                    class="w-2 h-2 rounded-sm bg-[#0080ff]"></span> Best auction</a>
                                        </li>
                                        <li><a href="#" class="flex items-center gap-2 hover:text-white"><span
                                                    class="w-2 h-2 rounded-sm bg-[#0080ff]"></span> Find valuation</a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Discover -->
                                <div>
                                    <div class="text-sm uppercase tracking-wide text-white/70 mb-3">Discover</div>
                                    <ul class="space-y-2">
                                        <li><a href="#" class="flex items-center gap-2 hover:text-white"><span
                                                    class="w-2 h-2 rounded-sm bg-[#0080ff]"></span> Blog</a></li>
                                        <li><a href="#" class="flex items-center gap-2 hover:text-white"><span
                                                    class="w-2 h-2 rounded-sm bg-[#0080ff]"></span> News</a></li>
                                        <li><a href="#" class="flex items-center gap-2 hover:text-white"><span
                                                    class="w-2 h-2 rounded-sm bg-[#0080ff]"></span> Trader
                                                Experience</a></li>
                                    </ul>
                                </div>

                                <!-- Brand/visual -->
                                <div class="flex items-center justify-center">
                                    <img src="https://beta.autoboli.co.uk/public/theme/fav.png" alt="AB"
                                        class="max-h-28 object-contain">
                                </div>
                            </div>
                        </div>

                        <!-- footer bar w/ links -->
                        <div class="px-6 pb-6">
                            <div class="flex flex-wrap items-center gap-4 border-t border-white/10 pt-4">
                                <a href="#"
                                    class="inline-flex items-center gap-2 text-white/80 hover:text-white">
                                    <span class="w-3 h-3 rounded-sm bg-[#0080ff]"></span> Download
                                </a>
                                <a href="#"
                                    class="inline-flex items-center gap-2 text-white/80 hover:text-white">
                                    <span class="w-3 h-3 rounded-sm bg-[#0080ff]"></span> About us
                                </a>
                                <a href="#"
                                    class="inline-flex items-center gap-2 text-white/80 hover:text-white">
                                    <span class="w-3 h-3 rounded-sm bg-[#0080ff]"></span> Contact us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="Find.html"
                    class="flex items-center justify-center h-full  border-0  hover:border-b hover:border-b-[#0080ff] text-gray-500  hover:text-white ">Find
                    Here</a>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-x-2 md:gap-x-4">
                <!-- Theme Toggle Button -->
                <button data-theme-toggle
                    class="cursor-pointer p-1 flex items-center justify-center active:scale-95 transition-all duration-300 shadow-sm text-gray-100 hover:text-[#0080ff] hover:bg-[#0f1c2c] hover:border-gray-600 rounded-full"
                    aria-label="Toggle theme">
                    <span class="material-symbols-outlined text-xl" data-theme-icon>flare</span>
                </button>


                <!-- <a
                            href=""
                            style="font-size: var(--font-p2); color: var(--nave-text-color)">My
                            Account</a> -->


                @auth
                    <!-- Agar user login hai -->
                    <div class="flex items-center gap-2">
                        <a href="{{ url('/dashboard') }}"
                            class="text-white rounded-md px-2 lg:px-4 py-2 font-medium cursor-pointer transform text-sm hidden lg:block">
                            Account
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-white bg-red-600 hover:bg-red-700 rounded-md px-2 lg:px-4 py-2 font-medium cursor-pointer transform text-sm hidden lg:block">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Agar user login nahi hai -->
                    <a href="{{ url('/login') }}"
                        class="text-white rounded-md px-2 lg:px-4 py-2 font-medium cursor-pointer transform text-sm hidden lg:block">
                        Sign In
                    </a>
                @endauth

                <a class=" hover:bg-[#0080ff] bg-[#0f1c2c] border border-[#353F4C] text-white dark:text-white rounded-md px-2 lg:px-4 py-2 font-medium cursor-pointer transform text-sm hidden lg:block"
                    href="{{ url('/register') }}">Get Started</a>

                <!-- Hamburger Menu for Mobile -->
                <div class="lg:hidden">
                    <img src="{{ asset('public/theme/assets/web/images/hamburger.png') }}" alt="Menu"
                        width="25" class="block dark:hidden transition-all duration-300" />
                </div>
            </div>
        </nav>
    </header>
