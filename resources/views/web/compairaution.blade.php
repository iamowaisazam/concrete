@extends('web.partial.layout')
@section('css')
    <style>
        body {
            background-color: var(--background-color) !important;
            font-family: var(--font-family) !important;
            overflow-x: hidden !important;
        }

        .hero-bg {
            position: relative;
            height: 100vh;
            width: 100%;
            background-image: url({{ asset('/public/theme/assets/Dots.png') }});
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .btn-started {
            background-color: var(--text-color) !important;
            color: white !important;
            border: none !important;
            padding: 10px 25px !important;
            border-radius: 5px !important;
            font-weight: 500 !important;
        }

        .text-pink {
            color: #f06292;
        }

        .text-purple {
            color: #7e57c2;
        }

        .text-info {
            color: #00acc1;
        }






        @keyframes wobble-vertical {
            0% {
                transform: translateY(0);
            }

            25% {
                transform: translateY(-4px);
            }

            50% {
                transform: translateY(4px);
            }

            75% {
                transform: translateY(-2px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .hover-wobble:hover {
            animation: wobble-vertical 0.6s ease-in-out;
            cursor: pointer;
        }

        .glow-container {
            position: relative;
            z-index: 1;
            margin: 10px 20px;
        }

        .glow-container::before {
            content: "";
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(135deg, #0080ff, #704ee9ec);
            /* pink to purple gradient */
            z-index: -1;
            filter: blur(25px);
            border-radius: 30px;
            opacity: 0.6;
        }


        @media (max-width: 991.98px) {
            .responsive-stikycards {
                position: static !important;
                margin-top: 1rem;
                margin-bottom: 1rem;
                display: flex;
                justify-content: center;
            }

            .responsive-stikycards>div {
                width: 100% !important;
                max-width: 300px;
            }
        }
    </style>
@endsection

@section('content')
    <section style="height: 100vh;" class="hero-bg adient">
        <div class="container d-flex  h-100 text-white">
            <div class="row align-items-center d-flex flex-wrap-reverse ">

                <div class="col-12 col-md-6 feature-list order-2  text-start">

                    <h1 class="display-4 fw-bold" style="font-size: 3rem; color: var(--text-color);"> Explore Every Tool</h1>
                    <h2 class="display-4 fw-bold text-white" style="font-size: 2rem;">Make Smarter Auction Decisions.
                        Subheading:
                    </h2>
                    <p style="font-size: 12px;">Your central hub to access all powerful features of Autoboli's Dealer
                        Dashboard. Whether you’re tracking auctions, finding vehicle values, or comparing bids — start here.
                    </p>

                    <div class="d-flex align-items-center mt-5">
                        <button class="btn-started  ">Get Started</button>
                        <p class="ms-3 mt-2" style="font-size: 12px;">Start Exploring <br> Dashboard Features</p>
                    </div>
                </div>

                <div class="col-12 col-md-6 order-1 order-md-2 text-center">
                    <div class="img-wrapper mx-auto">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Dashboard Preview"
                            class="over">
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div class="container py-5" style="color: white;">
        <div class="row align-items-center position-relative justify-content-center">
            <!-- {{-- Left Side: Graph + Stat Cards --}} -->
            <div class="col-lg-4 position-relative mb-5 mb-lg-0 glow-container ">
                <!-- {{-- Main Chart Card --}} -->
                <div class="shadow-sm p-2 bg"
                    style="height: 320px; border-radius: 20px; background-color: var(--text-color);">
                    <img src="./assets/bg-cars.png" alt=""
                        style="height: 100%; width: 100%; background-color: var(--items-background); border-radius: 10px;" />
                </div>

                <!-- {{-- Return Product (Top Left) --}} -->
                <!-- Return Product (Top Left) -->
                <div class="position-absolute responsive-stikycards" style="top: 5px; left: -35px;">
                    <div class=" shadow-sm rounded px-4 py-3 text-center hover-wobble"
                        style="width: 160px; border-radius: 10px; border: 2px solid var(--text-color); background-color : var(--items-background)!important;">
                        <div class="small mb-1">Return Product</div>
                        <h5 class="fw-bold mb-0 text-pink">5.105</h5>
                        <div class="text-pink fw-semibold">58%</div>
                    </div>
                </div>

                <!-- Stock Product (Top Right) -->
                <div class="position-absolute responsive-stikycards" style="top: -51px;  right: -38px;">
                    <div class="text-white shadow-sm rounded px-4 py-3 text-center hover-wobble "
                        style="width: 160px; border-radius: 15px; border: 2px solid var(--text-color);background-color : var(--items-background)!important;">
                        <div class=" small mb-1">Stock Product</div>
                        <h5 class="fw-bold mb-0 text-purple">9.700</h5>
                        <div class="text-purple fw-semibold">53%</div>
                    </div>
                </div>

                <!-- Sales Product (Bottom Left) -->
                <div class="position-absolute responsive-stikycards" style="bottom: -35px;left: -8px;">
                    <div class=" shadow-sm rounded px-4 py-3 text-center hover-wobble"
                        style="width: 160px; border-radius: 10px; border: 2px solid var(--text-color); background-color : var(--items-background)!important;">
                        <div class=" small mb-1">Sales Product</div>
                        <h5 class="fw-bold mb-0 text-info">14.200</h5>
                        <div class="text-info fw-semibold">60%</div>
                    </div>
                </div>
            </div>
            <!--  -->
            <!-- {{-- Right Side: Text + Services --}} -->
            <div class="col-lg-6 ps-lg-5">
                <div class="text-danger fw-semibold mb-2" style="letter-spacing: 1px">
                    OUR SERVICES
                </div>
                <h2 class="fw-bold mb-3" style="font-size: 2.2rem">
                    We Bring High Value<br />For Our Clients
                </h2>
                <p class="mb-4" style="max-width: 500px">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit
                    tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                </p>

                <div class="d-flex align-items-center mb-4">
                    <div class=" shadow-sm rounded p-2 me-3" style="width: 60px; height: 60px">
                        <img src="https://img.icons8.com/external-flat-icons-inmotus-design/64/000000/external-target-seo-flat-icons-inmotus-design.png"
                            width="100%" />
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Search Engine Optimization</h6>
                        <div class="small">
                            Lorem ipsum dolor sit amet, consectetur
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class=" shadow-sm rounded p-2 me-3" style="width: 60px; height: 60px">
                        <img src="https://img.icons8.com/color/48/000000/wallet.png" width="100%" />
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Financial Planner</h6>
                        <div class="small">
                            Curabitur non est sed urna facilisis aliquam
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class=" shadow-sm rounded p-2 me-3" style="width: 60px; height: 60px">
                        <img src="https://img.icons8.com/color/48/000000/megaphone.png" width="100%" />
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Email Marketing</h6>
                        <div class="small">
                            Nulla nec ante nec enim maximus cursus
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
