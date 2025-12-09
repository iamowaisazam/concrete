@extends('web.partial.layout')@extends('web.partial.layout')

@section('css')

<style>
  
    

</style>
@endsection

@section('content')

   <section style="height: 100vh;" class="hero-bg adient">
  <div class="container d-flex  h-100 text-white">
    <div class="row align-items-center d-flex flex-wrap-reverse">

      <div class="col-12 col-md-6 feature-list order-2  text-start">
        <p class="mb-1" style="opacity: 0.6;">Guide &gt; ABCD</p>
        <h1 class="display-4 fw-bold" style="font-size: 5rem;">Agency<br>Management</h1>
        <ul class="list-unstyled mt-4 ">
          <li class="mb-3 d-flex justify-content-center justify-content-md-start">
            <i class="fa-solid fa-check"></i>Compare listings side-by-side
          </li>
          <li class="mb-3 d-flex justify-content-center justify-content-md-start">
            <i class="fa-solid fa-check"></i>Filter by make, model, year, mileage
          </li>
          <li class="d-flex justify-content-center justify-content-md-start">
            <i class="fa-solid fa-check"></i>Instantly see which auction has the best deals
          </li>
        </ul>
        <button class="btn-started mt-4">Get Started</button>
      </div>

      <div class="col-12 col-md-6 order-1 order-md-2 text-center">
        <div class="img-wrapper mx-auto">
          <img src="./assets/Screenshot.png" alt="Dashboard Preview" class="over">
        </div>
      </div>

    </div>
  </div>
</section> 
<section class="text-white"
  style="height: 100vh; background-color: var(--items-background); display: flex; align-items: center;">
  <div class="container text-center w-100">

    <div class="mb-5">
      <h1 class="fw-bold mb-3">The secret to your team's success</h1>
      <p class="text-secondary">
        Gain insights into thousands of vehicle auctions and make smarter bidding decisions.<br>
        Subscribe to access full auction data across the nation.
      </p>
    </div>

    <div class="row justify-content-center mb-4 g-4">

      <div class="col-12 col-md-12 col-lg-6 d-flex">
        <div class="d-flex flex-column justify-content-between boli-box w-100"
          style="background-color: var(--items-background);">
          <div>
            <h5 class="pb-5" style="font-size:2rem;"><strong>Without <span
                  style="color: var(--text-color)">AutoBoli</span></strong></h5>
            <ul class="list-unstyled mt-3 text-start boli-list">
              <li class="mb-3 d-flex">
                <i class="fa-solid fa-check text-danger me-2" style="border: 2px solid var(--red-colur);"></i>
                Compare listings side-by-side
              </li>
              <li class="mb-3 d-flex">
                <i class="fa-solid fa-check text-danger me-2" style="border: 2px solid var(--red-colur);"></i>
                Filter by make, model, year, mileage
              </li>
              <li class="d-flex">
                <i class="fa-solid fa-check text-danger me-2" style="border: 2px solid var(--red-colur);"></i>
                Instantly see which auction has the best deals
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-12 col-lg-6 d-flex">
        <div class="d-flex flex-column justify-content-between boli-box w-100"
          style="background-color: var(--background-color);">
          <div>
            <h5 class="pb-5" style="font-size:2rem;"><strong>With <span
                  style="color: var(--text-color);">AutoBoli</span></strong></h5>
            <ul class="list-unstyled mt-3 text-start boli-list">
              <li class="mb-3 d-flex">
                <i class="fa-solid fa-check text-primary me-2" style="border: 2px solid var(--text-color);"></i>
                Compare listings side-by-side
              </li>
              <li class="mb-3 d-flex">
                <i class="fa-solid fa-check text-primary me-2" style="border: 2px solid var(--text-color);"></i>
                Filter by make, model, year, mileage
              </li>
              <li class="d-flex">
                <i class="fa-solid fa-check text-primary me-2" style="border: 2px solid var(--text-color);"></i>
                Instantly see which auction has the best deals
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    <button class="gradient-button">Get Started</button>

  </div>
</section>








  <section class="feature-section text-white d-flex justify-content-center align-items-center" style="background-color: var(--items-background)">
    <div class="container px-4">
<div class="row align-items-center g-5 flex-column flex-lg-row">
        <div class="col-lg-6 col-md-12">
          <div class="content-wrapper">
            <span class="feature-badge">Feature Name</span>
            <h2 class="feature-title mt-3">Find the Best Auction for<br>Your Next Buy</h2>
            <p class="feature-description">
              Stop bouncing between dozens of websites.<br>
              AUTOBOLU brings together UK auctions into a single, streamlined platform.
            </p>
            <ul class="feature-list">
              <li class="feature-item">
                <i class="fa-solid fa-check feature-icon"></i>
                Compare listings side-by-side
              </li>
              <li class="feature-item">
                <i class="fa-solid fa-check feature-icon"></i>
                Filter by make, model, year, mileage
              </li>
              <li class="feature-item">
                <i class="fa-solid fa-check feature-icon"></i>
                Instantly see which auction has the best deals
              </li>
            </ul>
            <a href="#" class="btn btn-light feature-btn">Use this feature</a>
          </div>
        </div>

       
        <div class="col-lg-6 col-md-12">
          <div class="image-container ">
            <div
              class="car-grid rounded-4">
              <img src="./assets//Screenshot.png" alt="Car 24" class=" object-fit-cover ">
            </div>
          </div>
        </div>

      </div>
  </section> 

    <section class="feature-section text-white d-flex justify-content-center align-items-center" style="background-color: var(--items-background)">
    <div class="container">
<div class="row align-items-center g-5 flex-column-reverse flex-lg-row">

<div class="col-lg-7 col-md-12">
          <div class="image-container ">
            <div
              class="car-grid rounded-4">
              <img src="./assets//Screenshot.png" alt="Car 24" class=" object-fit-cover ">
            </div>
          </div>
        </div>

        <div class="col-lg-5 col-md-12">
          <div class="content-wrapper">
            <span class="feature-badge">Feature Name</span>
            <h2 class="feature-title mt-3">Find the Best Auction for<br>Your Next Buy</h2>
            <p class="feature-description">
              Stop bouncing between dozens of websites.<br>
              AUTOBOLU brings together UK auctions into a single, streamlined platform.
            </p>
            <ul class="feature-list">
              <li class="feature-item">
                <i class="fa-solid fa-check feature-icon"></i>
                Compare listings side-by-side
              </li>
              <li class="feature-item">
                <i class="fa-solid fa-check feature-icon"></i>
                Filter by make, model, year, mileage
              </li>
              <li class="feature-item">
              <i class="fas  fa-chevron-right"></i>
                Instantly see which auction has the best deals
              </li>
            </ul>
            <a href="#" class="btn btn-light feature-btn">Use this feature</a>
          </div>
        </div>
      </div>
    </div>
  </section>  
       

<section class="py-5">
    <div class="container">
      <div class="col-auto">
        <h2 class="text-white fw-bold mb-3">Explore more</h2>
      </div>
      <div class="row align-items-center">

        <div class="col">
          <div class="row g-3">

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
              <button type="button" class="card-btn">
                <div class="card  border border-secondary h-100"  style="background-color: var(--background-color);">
                  <div class="card-body py-4">
                    <i class="fas fa-asterisk text-primary fs-2 mb-3"></i>
                    <p class="card-text text-white fw-semibold mb-0">Use this feature</p>
                  </div>
                </div>
              </button>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
              <button type="button" class="card-btn">
                <div class="card  border border-secondary h-100"  style="background-color: var(--background-color);">
                  <div class="card-body py-4">
                    <i class="fas fa-asterisk text-primary fs-2 mb-3"></i>
                    <p class="card-text text-white fw-semibold mb-0">Use this feature</p>
                  </div>
                </div>
              </button>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
              <button type="button" class="card-btn">
                <div class="card  border border-secondary h-100"  style="background-color: var(--background-color);">
                  <div class="card-body py-4">
                    <i class="fas fa-asterisk text-primary fs-2 mb-3"></i>
                    <p class="card-text text-white fw-semibold mb-0">Use this feature</p>
                  </div>
                </div>
              </button>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
              <button type="button" class="card-btn">
                <div class="card  border border-secondary h-100"  style="background-color: var(--background-color);">
                  <div class="card-body py-4">
                    <i class="fas fa-asterisk text-primary fs-2 mb-3"></i>
                    <p class="card-text text-white fw-semibold mb-0">Use this feature</p>
                  </div>
                </div>
              </button>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
              <button type="button" class="card-btn">
                <div class="card  border border-secondary h-100"  style="background-color: var(--background-color);">
                  <div class="card-body py-4">
                    <i class="fas fa-asterisk text-primary fs-2 mb-3"></i>
                    <p class="card-text text-white fw-semibold mb-0">Use this feature</p>
                  </div>
                </div>
              </button>
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6" >
              <button type="button" class="card-btn"  style="border: 1px solid var(--items-border-colur);  border-radius: 10px;">
                <div class="card  h-100 text-center text-white " style="background-color: var(--items-background);">
                  <div class="card-body py-5 d-flex justify-content-center align-items-center">
                    
                    <p class="card-text fw-semibold mb-0  ">View all</p>
                    <i class="fas  fa-chevron-right ps-3"></i>
                  </div>
                </div>
              </button>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section> 

   <section class="explore-section">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="fw-bold mb-0 text-white">Explore more pages</h2>
          <div class="d-flex gap-3">
            <button class="nav-arrows" onclick="previousSlide()">
              <i class="fas fa-chevron-left"></i>
            </button>
            <button class="nav-arrows" onclick="nextSlide()">
              <i class="fas  fa-chevron-right"></i>
            </button>
          </div>
        </div>

        <div id="cardCarousel" class="carousel-row">
          

          <div
            class="dashboard-card"
          >
            <div class="dashboard-mockup ">
              <img src="./assets/bg-cars.png" alt="Cars" />
            </div>
            <div class=" pt-4">
              <h5 class=" fs-5 text-white">Explore more pages</h5>
            </div>
          </div>

          <div
            class="dashboard-card"
          >
            <div class="dashboard-mockup ">
              <img src="./assets/bg-cars.png" alt="Cars" />
            </div>
            <div class=" pt-4">
              <h5 class=" fs-5 text-white">Explore more pages</h5>
            </div>
          </div>
          <div
            class="dashboard-card"
          >
            <div class="dashboard-mockup ">
              <img src="./assets/bg-cars.png" alt="Cars" />
            </div>
            <div class=" pt-4">
              <h5 class=" fs-5 text-white">Explore more pages</h5>
            </div>
          </div>
          <div
            class="dashboard-card"
          >
            <div class="dashboard-mockup ">
              <img src="./assets/bg-cars.png" alt="Cars" />
            </div>
           <div class=" pt-4">
              <h5 class=" fs-5 text-white">Explore more pages</h5>
            </div>
          </div>
          <div
            class="dashboard-card"
          >
            <div class="dashboard-mockup ">
              <img src="./assets/bg-cars.png" alt="Cars" />
            </div>
            <div class=" pt-4">
              <h5 class=" fs-5 text-white">Explore more pages</h5>
            </div>
          </div>

        </div>
      </div>
    </section> 


  @endsection



  @section('js')

<script>
  

</script>

@endsection
