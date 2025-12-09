@extends('web.partial.layout')
@section('css')
    <style>
        .sidebar {
            background-color: var(--background-color);
            margin: 20px;
            border-radius: 2px;
            border: 1px solid var(--items-border-colur);
            min-width: 350px;
            /* padding-top: 1rem; */
            height: fit-content;
            position: sticky;
            top: 70px;
            /* jitna distance chahiye upar se */
            align-self: flex-start;
            padding-bottom: 10rem;
            margin-top: 6rem;
        }

        .sidnav-link {
            color: var(--dimtext);
            padding: 10px 15px;
            /* padding-top: 20px !important; */
            border-bottom: 1px dashed var(--dimtext);
            margin: 10px;
            border-radius: 2px;
            cursor: pointer;

            background: linear-gradient(to right, var(--tra-primary-colr) 0%, transparent 100%);
            background-size: 0% 100%;
            background-repeat: no-repeat;
            transition: background-size 0.4s ease, color 0.5s ease;
        }

        /* Hover = fill from left to right */
        .sidnav-link:hover {
            background-size: 100% 100%;
            color: var(--white-text);
        }

        /* Active = already full */
        .sidnav-link.active {
            background: linear-gradient(to right, var(--tra-primary-colr) 0%, var(--tra-primary-colr) 100%);
            background-size: 100% 100%;
            color: var(--white-text);
            /* border: none; */

        }


        @media (min-width: 768px) {
            .sidebar {
                margin-left: 0;
                margin-right: 0;
            }
        }

        .tab-content {
            background-color: var(--white-text);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }




        .content-text {
            font-size: 1.1rem;
            margin-bottom: 40px;
            line-height: 1.7;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--white-text);
        }

        .highlight-box {
            background: rgba(74, 144, 226, 0.1);
            border-left: 4px solid #4a90e2;
            padding: 20px;
            margin: 30px 0;
            border-radius: 5px;
        }

        .highlight-box p {
            margin: 0;
            color: var(--white-text);
        }

        .interface-screenshot {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-top: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .interface-screenshot img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .dashboard-card {
            width: 400px;
            flex-shrink: 0;
            padding: .5rem !important;
            transition: transform 0.3s ease;
            border: 1px solid var(--items-border-colur) !important;
            border-radius: 15px;
            background: var(--items-background);
        }

        .dashboard-mockup {
            height: 200px;
        }

        .dashboard-mockup img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }
    </style>
@endsection

@section('content')
    <section style="
        background-color: var(--items-background);
        font-family: var(--font-family);
      ">
        <div class="d-flex align-items-start container-fluid">
            <div class="d-flex flex-column flex-md-row justify-content-between"
                style="background-color: var(--items-background);gap: 70px;">
                <!-- Sidebar -->
                <div class="sidebar">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <h5 class="px-3 pt-3 text-white">Catageri</h5>
                        <div class="sidnav-link active d-flex align-items-center gap-2" id="v-pills-dashboard-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-dashboard" role="tab">
                            Privacy Policy
                        </div>
                        <div class="sidnav-link d-flex align-items-center gap-2" id="v-pills-analytics-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-analytics" role="tab">

                            Security Policy
                        </div>
                        <div class="sidnav-link d-flex align-items-center gap-2" id="v-pills-projects-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-projects" role="tab">
                            Cookie Policy
                        </div>
                        <div class="sidnav-link d-flex align-items-center gap-2" id="v-pills-messages-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-messages" role="tab">
                            Developer teame
                        </div>
                        <div class="sidnav-link d-flex align-items-center gap-2" id="v-pills-team-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-team" role="tab">
                            Subscile
                        </div>
                        <div class="sidnav-link d-flex align-items-center gap-2" id="v-pills-settings-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-settings" role="tab">
                            Terms
                        </div>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="flex-grow-1 p-4 justify-content-center  container-fluid">
                    <div class="tab-content text-white" id="v-pills-tabContent"
                        style="background-color: var(--items-background)">
                        <h4 class="text-center mb-5">The Auto boli blogs</h4>

                        <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel">







                                <div class="d-flex gap-4">

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <p style="line-height: 1.7; color: #d1d5db;margin-top: 30px;">Lorem ipsum dolor
                                                sit amet
                                                consectetur adipisicing elit. Placeat dignissimos aliquam asperiores ipsa
                                                alias
                                                aspernatur et, porro, maiores vitae sit obcaecati reiciendis facere.</p>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                </div>









                        </div>







                    <!-- Analytics -->
                    <div class="tab-pane fade" id="v-pills-analytics" role="tabpanel">
                       
                                <div class="d-flex gap-4">

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <p style="line-height: 1.7; color: #d1d5db;margin-top: 30px;">Lorem ipsum dolor
                                                sit amet
                                                consectetur adipisicing elit. Placeat dignissimos aliquam asperiores ipsa
                                                alias
                                                aspernatur et, porro, maiores vitae sit obcaecati reiciendis facere.</p>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                    </div>
                    <!-- Projects -->
                    <div class="tab-pane fade" id="v-pills-projects" role="tabpanel">
                        
                                <div class="d-flex gap-4">

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <p style="line-height: 1.7; color: #d1d5db;margin-top: 30px;">Lorem ipsum dolor
                                                sit amet
                                                consectetur adipisicing elit. Placeat dignissimos aliquam asperiores ipsa
                                                alias
                                                aspernatur et, porro, maiores vitae sit obcaecati reiciendis facere.</p>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                    </div>

                    <!-- Messages -->
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel">
                        
                                <div class="d-flex gap-4">

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <p style="line-height: 1.7; color: #d1d5db;margin-top: 30px;">Lorem ipsum dolor
                                                sit amet
                                                consectetur adipisicing elit. Placeat dignissimos aliquam asperiores ipsa
                                                alias
                                                aspernatur et, porro, maiores vitae sit obcaecati reiciendis facere.</p>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                    </div>

                    <!-- Team -->
                    <div class="tab-pane fade" id="v-pills-team" role="tabpanel">
                        
                                <div class="d-flex gap-4">

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <p style="line-height: 1.7; color: #d1d5db;margin-top: 30px;">Lorem ipsum dolor
                                                sit amet
                                                consectetur adipisicing elit. Placeat dignissimos aliquam asperiores ipsa
                                                alias
                                                aspernatur et, porro, maiores vitae sit obcaecati reiciendis facere.</p>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="d-flex gap-4">

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <p style="line-height: 1.7; color: #d1d5db;margin-top: 30px;">Lorem ipsum dolor
                                                sit amet
                                                consectetur adipisicing elit. Placeat dignissimos aliquam asperiores ipsa
                                                alias
                                                aspernatur et, porro, maiores vitae sit obcaecati reiciendis facere.</p>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="dashboard-card">
                                        <div class="dashboard-mockup ">
                                            <img src="{{ asset('/public/theme/assets/bg-cars.png') }}" alt="Cars" />
                                        </div>
                                        <div class=" pt-4">
                                            <h5 class=" fs-5 text-white">Explore more pages</h5>
                                            <h6 style=" ">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. !
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                    </div>

                    <!-- Settings -->
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel">
                        <div class="container py-5">
                            <h5 class="text-center mb-5">
                                Developer teame
                            </h5>
                            <h6>Guide to Writing Text to Image Prompts</h6>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                diam nonummy nibh euismod tincidunt ut laoreet dolore magna
                                aliquam erat volutpat.
                            </p>

                            <div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit...
                                </p>
                                <p>
                                    Duis autem vel eum iriure dolor in hendrerit in vulputate
                                    velit...
                                </p>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit...
                                </p>
                            </div>


                            <div class="interface-screenshot">
                                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-aNaFVUDpNGIX9t3ztAUCnTcipXuXzz.png"
                                    alt="Interface Screenshot" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
