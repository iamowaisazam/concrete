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
                <!-- Sidebar -->
                <aside class="lg:col-span-4 xl:col-span-3">
                    <div class="sticky top-20">
                        <div
                            class="rounded-2xl border border-slate-200 bg-white/80 backdrop-blur-sm shadow-card dark:border-white/10 dark:bg-white/[0.04]">
                            <h3 class="px-5 pt-5 pb-3 text-lg font-semibold text-slate-900 dark:text-white">Terms & Condition
                            </h3>
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

                <!-- Content -->
                <main class="lg:col-span-8 xl:col-span-9">
                    <!-- Intro card -->
                    <div
                        class="rounded-2xl bg-white shadow-card border border-slate-200 p-6 md:p-8 mb-8 dark:bg-white/[0.05] dark:border-white/10">
                        <div class="flex items-start gap-4">
                            <div class="shrink-0">
                                <!-- tiny accent badge -->
                                <div
                                    class="h-12 w-12 rounded-xl bg-[#0080ff]/10 border border-[#0080ff]/20 grid place-content-center">
                                    <svg viewBox="0 0 24 24" class="h-6 w-6 text-[#0080ff]" fill="currentColor">
                                        <path
                                            d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2Zm-1 14-4-4 1.414-1.414L11 12.172l4.586-4.586L17 9l-6 7Z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3 dark:text-white">Terms
                                    and Condition</h1>
                                <p class="text-slate-600 dark:text-slate-300 max-w-3xl">
                                    Autoboli employs strong privacy practices across our platform. This policy explains what
                                    data we collect,
                                    how we use it, our legal bases, and the controls you have. We regularly review and
                                    update our practices.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Sections (with scroll-spy anchors) -->
                    <article id="doc" class="space-y-12 leading-relaxed text-slate-700 dark:text-slate-200">
                        <!-- 1 -->
                        <section id="purpose" data-spy-title="1. Purpose, Scope, and Organization" class="scroll-mt-24">
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                                1. Purpose, Scope, and Organization
                            </h2>
                            <p class="mt-3 text-slate-600 dark:text-slate-300">
                                This policy defines behavioral, process, technical, and governance controls concerning
                                privacy at Autoboli.
                                It applies to all personnel and systems that process personal data in connection with our
                                services.
                            </p>
                            <ul class="mt-4 list-disc pl-6 space-y-2">
                                <li>All Autoboli employees, contractors, and third parties handling user data.</li>
                                <li>Systems that store or transmit personal data on behalf of Autoboli.</li>
                                <li>Situations where Autoboli has a contractual or legal duty to protect data.</li>
                            </ul>
                        </section>

                        <!-- 2 -->
                        <section id="collection" data-spy-title="2. Information We Collect" class="scroll-mt-24">
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                                2. Information We Collect
                            </h2>
                            <p class="mt-3 text-slate-600 dark:text-slate-300">
                                We collect information you provide (e.g., account details), information from usage (e.g.,
                                logs, device data),
                                and information from partners where lawfully permitted.
                            </p>
                        </section>

                        <!-- 3 -->
                        <section id="use" data-spy-title="3. How We Use Information" class="scroll-mt-24">
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                                3. How We Use Information
                            </h2>
                            <p class="mt-3">
                                We use data to provide and secure our services, personalize experiences, communicate with
                                you, and meet legal obligations.
                            </p>
                        </section>

                        <!-- 4 -->
                        <section id="sharing" data-spy-title="4. Sharing & Disclosure" class="scroll-mt-24">
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                                4. Sharing &amp; Disclosure
                            </h2>
                            <p class="mt-3">
                                We may share data with processors, affiliates, and legal authorities when necessary and
                                lawful. We require
                                appropriate safeguards from all processors.
                            </p>
                        </section>

                        <!-- 5 -->
                        <section id="rights" data-spy-title="5. Your Rights" class="scroll-mt-24">
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                                5. Your Rights
                            </h2>
                            <p class="mt-3">
                                Depending on your location, you may have rights to access, correct, delete, or export your
                                data, and to object
                                or restrict certain processing. Contact us to exercise these rights.
                            </p>
                        </section>

                        <!-- 6 -->
                        <section id="security" data-spy-title="6. Security" class="scroll-mt-24">
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                                6. Security
                            </h2>
                            <p class="mt-3">
                                We maintain technical and organizational security measures including encryption, access
                                controls, and auditing.
                            </p>
                        </section>

                        <!-- 7 -->
                        <section id="changes" data-spy-title="7. Changes to this Policy" class="scroll-mt-24 pb-4">
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                                7. Changes to this Policy
                            </h2>
                            <p class="mt-3">
                                We may update this policy periodically. We’ll post changes here and update the effective
                                date.
                            </p>
                        </section>
                    </article>
                </main>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        // -------- Optional scroll-spy for in-page sections (right content) --------
        // Highlights the heading currently in view by adding a left border + accent
        const sections = document.querySelectorAll('#doc section[id]');
        const opts = {
            rootMargin: '-30% 0px -60% 0px',
            threshold: 0
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const id = entry.target.getAttribute('id');
                const heading = entry.target.querySelector('h2');
                if (entry.isIntersecting) {
                    heading?.classList.add('border-l-4', 'pl-3', 'border-[#0080ff]');
                } else {
                    heading?.classList.remove('border-l-4', 'pl-3', 'border-[#0080ff]');
                }
            });
        }, opts);
        sections.forEach(s => observer.observe(s));
    </script>
@endsection
