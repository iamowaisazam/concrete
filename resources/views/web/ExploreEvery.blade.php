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

        .over {
            width: 100%;
            height: 100%;
            border-radius: 12px;
        }
        .img-wrapper {
            background-color: var(--items-background) !important;
            border: 1px solid rgba(255, 255, 255, 0.301);
            border-radius: 12px;
            padding: 15px !important;
            height: 35vw !important;
            transform: translate(20%) !important;
            width: 45vw !important;
            object-fit: cover !important;

            box-shadow: -100px -82px 180px -145px var(--text-color);
            -webkit-box-shadow: -100px -93px 180px -122px var(--text-color);
            -moz-box-shadow: -100px -93px 180px -145px var(--text-color);
        }
        
        .explore-page-img-container {
            width: 100%;
            max-width: 600px;
            /* increase this value to make it bigger */
            aspect-ratio: 16 / 9;
            overflow: hidden;
            margin: 0 auto;
            /* center it */
            box-shadow: -100px -82px 180px -145px var(--text-color);
            -webkit-box-shadow: -100px -93px 180px -122px var(--text-color);
            -moz-box-shadow: -100px -93px 180px -145px var(--text-color);
            padding: 5px;
            background: linear-gradient(135deg, #0080ff, #004080);
            border-radius: 14px;
        }

        .explore-page-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 10px;
        }

        .explore-gredint-btn {
            background: linear-gradient(135deg, #007AFF 0%, #0051D5 100%) !important;
            text-decoration: none !important;
            color: white !important;

            padding: 15px 20px !important;
            border-radius: 5px !important;
        }

        .explore-nav {
            position: sticky;
            top: 50px;
            z-index: 1000;
            background-color: var(--background-color);
        }

        .explore-link {
            color: #333;
            padding: 8px 14px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .explore-link.active {
            color: white !important;
        }






        

        .feature-list {
            z-index: 2 !important;
            position: relative;
            z-index: 2 !important;
            color: white !important;
            padding: 4rem;
        }

        .feature-list i {
            color: var(--text-color);
            height: 24px;
            width: 24px;
            display: flex;
            justify-content: center;
            border-radius: 50%;
            font-weight: 900 !important;
            align-items: center;
            border: 2px solid var(--text-color);
            margin-right: 10px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin-bottom: 2rem;
        }

        .btn-started {
            background-color: var(--text-color) !important;
            color: white !important;
            border: none !important;
            padding: 10px 25px !important;
            border-radius: 5px !important;
            font-weight: 500 !important;
        }


        @media (max-width: 785px) {




            .hero-bg {
                display: flex;
                align-items: center;
                justify-content: flex-start;
            }

            .feature-list p {
                text-align: center;

            }

            .feature-list h1 {
                font-size: 2.3rem !important;
                line-height: 1.2;
                text-align: center;
            }



        }



        .content-wrapper {
            padding-right: 2rem;
        }

        .feature-badge {
            border: 2px solid var(--text-color);
            color: var(--text-color);
            padding: 8px 16px;
            border-radius: 16px;
            font-size: 14px;
        }

        .feature-title {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: white;
        }

        .feature-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 1rem;
        }



        @media (max-width: 994px) {
            .feature-title {
                font-size: 2rem;
            }

            .feature-description {
                font-size: .5rem;
                text-align: center !important;
            }

            li {
                text-align: center !important;
            }


        }
    </style>
@endsection

@section('content')
    <section style="height: 100vh;" class="hero-bg adient">
        <div class="container d-flex  h-100 text-white">
            <div class="row align-items-center d-flex flex-wrap-reverse">

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

    <div id="exploreNav" class="explore-nav  pt-3 shadow-sm">
        <div class=" top-explore-bar d-flex justify-content-center gap-3 py-3 "
            style="background-color: var(--background-color); flex-wrap: wrap; ">
            <a class="nav-link explore-link" href="#section1"> Dashboard</a>
            <a class="nav-link explore-link" href="#section2"> Finder</a>
            <a class="nav-link explore-link" href="#section3">Vehicle Valuation</a>
            <a class="nav-link explore-link" href="#section4">Vehicle Details</a>
            <a class="nav-link explore-link" href="#section5">Auction Schedule</a>
            <a class="nav-link explore-link" href="#section6">Find Valuation </a>
            <a class="nav-link explore-link" href="#section7">Reauction</a>
            <a class="nav-link explore-link" href="#section8">Compare</a>
            <a class="nav-link explore-link" href="#section9">VIN Search</a>
            <a class="nav-link explore-link" href="#section10">Master</a>
        </div>
    </div>
    <!-- Section 1: Auction Dashboard -->
    <section id="section1" class="py-5 text-white d-flex justify-content-center align-items-center"
        style="background-color: var(--items-background); padding-bottom: 200px !important;">
        <div class="container px-4">
            <div class="row align-items-center g-5 flex-column flex-lg-row">
                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3">Auction Overview & Interest-Based Auctions</h2>
                        <p class="feature-description">
                            Stay on top of live and historical auction trends. Get a real-time overview or let our system
                            tailor auctions to your specific interests.
                        </p>
                        <ul class="feature-list">
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Live auction activity and summaries
                            </li>
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Smart filters based on your watchlist and interests
                            </li>
                            <!-- <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Instantly see which auction has the best deals
                          </li> -->
                        </ul>
                        <a href="#" class="explore-gredint-btn">View Dashboard Insights</a>
                    </div>
                </div>


                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Section 2: Auction Finder  -->
    <section id="section2" style="background-color: var(--items-background); padding-bottom: 200px;">
        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">

                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3">Find the Best Auction for<br>Your Next Buy</h2>
                        <p class="feature-description">
                            Access past 3 months’ auction data and upcoming listings with advanced filters. Click on any
                            auction row to dive into full vehicle insights.
                        </p>
                        <ul class="feature-list">
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Historical + upcoming auction listings
                            </li>
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Row-level click-through to full details
                            </li>
                            <li class="feature-item">
                                <i class="fas  fa-chevron-right"></i>
                                Save your filters for next time
                            </li>
                        </ul>
                        <a href="#" class="explore-gredint-btn"> Find Your Next Auction</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section 3: Vehicle Valuation -->
    <section id="section3" class="py-5 text-white d-flex justify-content-center align-items-center"
        style="background-color: var( --items-background); padding-bottom: 200px !important;">
        <div class="container px-4">
            <div class="row align-items-center g-5 flex-column flex-lg-row">
                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3"> Know Every Vehicle’s Real Worth</h2>
                        <p class="feature-description">
                            See real-time and historical price charts powered by our Autoboli predictions. Understand market
                            trends before you bid.
                        </p>
                        <ul class="feature-list">
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Predicted and real-time value charts
                            </li>
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Historical price comparison
                            </li>
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Confidence indicators per listing
                            </li>
                        </ul>
                        <a href="#" class="explore-gredint-btn">View Dashboard Insights</a>
                    </div>
                </div>


                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Section 4: Vehicle Details Page -->
    <section id="section4" style="background-color: var( --items-background); padding-bottom: 200px;">
        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">

                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3">Dive Into Full Vehicle Intelligence</h2>
                        <p class="feature-description">
                            Everything you need to know about a vehicle in one place — specs, <br>
                            images, condition, historical prices, predicted trends, and auction insights.
                        </p>
                        <ul class="feature-list">
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Complete auction history
                            </li>
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Vehicle specifications and photos
                            </li>
                            <li class="feature-item">
                                <i class="fas  fa-chevron-right"></i>
                                Valuation data at a glance
                            </li>
                        </ul>
                        <a href="#" class="explore-gredint-btn"> View Vehicle Details </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section 5: Auction Schedule -->
    <section id="section5" class="py-5 text-white d-flex justify-content-center align-items-center"
        style="background-color: var(--items-background); padding-bottom: 200px !important;">
        <div class="container px-4">
            <div class="row align-items-center g-5 flex-column flex-lg-row">
                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3">Plan Ahead with Live Auction Schedules</h2>
                        <p class="feature-description">
                            Get a calendar view of upcoming auctions with detailed lot status. <br> Filter by auction house,
                            date, or region to streamline your planning.
                        </p>
                        <ul class="feature-list">
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Live status tracking
                            </li>
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Region & type-based filtering
                            </li>
                            <li class="feature-item">
                                <i class="fa-solid fa-check feature-icon"></i>
                                Bookmark important events
                            </li>
                        </ul>
                        <a href="#" class="explore-gredint-btn">Check Auction Schedule</a>
                    </div>
                </div>


                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Section 6: Find Valuation -->
    <section id="section6" style="background-color: var(--items-background); padding-bottom: 200px;">
        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">

                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3"> Search Any Lot’s Value in Seconds</h2>
                        <p class="feature-description">
                            Have a lot ID or vehicle in mind? Instantly retrieve current value data,<br>
                            historical pricing, and Autoboli predictions — all in one view.
                        </p>
                        <!-- <ul class="feature-list">
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Historical + upcoming auction listings
                          </li>
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                           Row-level click-through to full details
                          </li>
                          <li class="feature-item">
                          <i class="fas  fa-chevron-right"></i>
                            Save your filters for next time
                          </li>
                        </ul> -->
                        <a href="#" class="explore-gredint-btn"> Find Vehicle Value Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section 7: Reauction Tracker -->
    <section id="section7" class="py-5 text-white d-flex justify-content-center align-items-center"
        style="background-color: var(--items-background); padding-bottom: 200px !important;">
        <div class="container px-4">
            <div class="row align-items-center g-5 flex-column flex-lg-row">
                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3"> Track Vehicles That Came Back</h2>
                        <p class="feature-description">
                            Spot the vehicles that reappear in auctions. <br> Find why they didn’t sell earlier — and if
                            they’re now worth bidding on.
                        </p>
                        <!-- <ul class="feature-list">
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Live auction activity and summaries
                          </li>
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Smart filters based on your watchlist and interests
                          </li>
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Instantly see which auction has the best deals
                          </li>
                        </ul> -->
                        <a href="#" class="explore-gredint-btn">Explore Reauction Lots</a>
                    </div>
                </div>


                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Section 8: Compare Auctions -->
    <section id="section8" style="background-color: var(--items-background); padding-bottom: 200px;">
        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">

                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3">Compare Auctions Like a Pro</h2>
                        <p class="feature-description">
                            Side-by-side comparison of auction results, <br> pricing trends, and valuation data so you can
                            make the smartest investment.
                        </p>
                        <!-- <ul class="feature-list">
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Historical + upcoming auction listings
                          </li>
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                           Row-level click-through to full details
                          </li>
                          <li class="feature-item">
                          <i class="fas  fa-chevron-right"></i>
                            Save your filters for next time
                          </li>
                        </ul> -->
                        <a href="#" class="explore-gredint-btn"> Compare Auction Listings</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section 9: VIN / Reg Search -->
    <section id="section9" class="py-5 text-white d-flex justify-content-center align-items-center"
        style="background-color: var(--items-background); padding-bottom: 200px !important;">
        <div class="container px-4">
            <div class="row align-items-center g-5 flex-column flex-lg-row">
                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3"> Get Complete Inspection Data</h2>
                        <p class="feature-description">
                            Search via VIN or Registration Number to reveal deep inspection reports, <br> accident history,
                            and ownership records — instantly.
                        </p>
                        <!-- <ul class="feature-list">
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Live auction activity and summaries
                          </li>
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Smart filters based on your watchlist and interests
                          </li>
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Instantly see which auction has the best deals
                          </li>
                        </ul> -->
                        <a href="#" class="explore-gredint-btn">Search by VIN / Reg No</a>
                    </div>
                </div>


                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Section 10 (Bottom of Explore Page) -->
    <section id="section10" style="background-color: var(--items-background); padding-bottom: 200px;">
        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">

                <div class="col-6 d-flex justify-content-center">
                    <div class="explore-page-img-container">
                        <img src="{{ asset('/public/theme/assets/Screenshot.png') }}" alt="Car 24"
                            class="explore-page-img">
                    </div>
                </div>

                <div class="col-6">
                    <div class="content-wrapper">
                        <h2 class="feature-title mt-3"> Ready to Master Every Auction?</h2>
                        <p class="feature-description">
                            Jump into any dashboard feature and take control of your auction journey. <br> Whether you're
                            buying or analyzing — Autoboli helps you win smarter.
                        </p>
                        <!-- <ul class="feature-list">
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                            Historical + upcoming auction listings
                          </li>
                          <li class="feature-item">
                            <i class="fa-solid fa-check feature-icon"></i>
                           Row-level click-through to full details
                          </li>
                          <li class="feature-item">
                          <i class="fas  fa-chevron-right"></i>
                            Save your filters for next time
                          </li>
                        </ul> -->
                        <a href="#" class="explore-gredint-btn"> Launch Dashboard Features</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        const links = document.querySelectorAll(".explore-link");
        const sections = [
            "#section1", "#section2", "#section3", "#section4",
            "#section5", "#section6", "#section7", "#section8",
            "#section9", "#section10"
        ];

        window.addEventListener("scroll", () => {
            let current = "";
            sections.forEach((id) => {
                const section = document.querySelector(id);
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 150) {
                    current = id;
                }
            });
            links.forEach((link) => {
                link.classList.remove("active");
                if (link.getAttribute("href") === current) {
                    link.classList.add("active");
                }
            });
        });
    </script>
@endsection
