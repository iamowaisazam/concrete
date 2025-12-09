@extends('web.partial.layout')

@section('css')
@endsection

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <main>
        {{-- hero --}}
        <section class="h-[60vh] bg-[#0080ff] flex justify-center items-center">
            <div class="mx-auto max-w-3xl">
                <span class="font-medium text-black">About Us</span>
                <h1 class="text-7xl font-bold text-white">Empowering Dealers & Traders with Data Backed Confidence</h1>
            </div>
        </section>
        {{-- afterHero --}}
        <section class="bg-[#001020]">
            <div class="mx-auto max-w-3xl py-20">
                <div class="border-l-4 border-[#0080ff] p-5 text-[#AAB8C5] space-y-4 shadow">
                    <p>Empowering Dealers & Traders with Data-Backed Confidence</p>
                    <p>The Vehicle Auction Industry is fast, competitive, and unforgiving-one wrong bid can cost thousands
                        and missing the right opportunity can cost even more. For years, dealers and traders have relied on
                        guesswork, scattered data and outdated pricing tools, making every auction feel like a gamble
                        instead of a calculated investment.</p>
                    <p>That's where Autoboli Ltd steps in.</p>
                </div>
                <img src="{{ asset('public/theme/assets/aboutImage.png') }}" alt="About Image" width="100%"
                    class="bg-cover bg-center">
            </div>
        </section>
        {{-- Why Autoboli Exists --}}
        <section class="bg-gradient-to-b from-[#0f1c2d] to-[#0e2a52]">
            <div class="mx-auto max-w-5xl py-20">
                <div class="text-center text-white space-y-4 pb-14">
                    <h1 class="text-white font-bold text-5xl">Why Autoboli Exists</h1>
                    <p class="text-sm font-medium">Most auction buyers face the same frustrating challenges:</p>
                </div>

                <div class="grid grid-cols-3 w-full gap-8 pb-20">
                    @for ($i = 1; $i <= 6; $i++)
                        <div
                            class="group bg-[#001020] px-8 py-12 mb-4 transition-all duration-300 hover:bg-[#d10101] cursor-pointer">
                            <div
                                class="border-l-4 border-[#d10101] px-5 transition-all duration-300 group-hover:border-white">
                                <p class="text-[#AAB8C5] transition-all duration-300 group-hover:text-black">
                                    No Single Platform to Compare auction house prices, history and valuations.
                                </p>
                            </div>
                        </div>
                    @endfor


                </div>

                <div class="max-w-3xl border border-[#032650] px-32 py-16 w-full bg-[#001020] mx-auto rounded-2xl ">
                    <h1 class="text-[#0080ff] font-semibold text-3xl">Autoboli was built to change that.</h1>
                </div>
            </div>
        </section>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <main>


    </main>
@endsection

@section('js')
@endsection
