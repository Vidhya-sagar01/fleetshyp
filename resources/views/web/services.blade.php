
@extends('web.layouts.app')

@section('title', 'Home Page')

@section('content')

 <!-- Hero Section -->
        <section class="hero-section d-flex align-items-center text-center">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-8">
                        <h1 class="hero-title ">Services Fleet<span style="color:#dfc369">Shyp</span></h1>

                        <div class="hero-buttons">
                          <a href="{{ route('seller.login') }}" class="btn-get-started">Get Started</a>
                            <a href="{{ url('/about') }}" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

 <!-- Services Section -->
<section id="services" class="services section">

  <div class="container">

    <div class="row gy-4">

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item d-flex position-relative h-100">
          <i class="bi bi-briefcase icon flex-shrink-0"></i>
          <div>
            <h4 class="title"><a href="#" class="stretched-link">Order Management</a></h4>
            <p class="description">Easily manage and process all your orders from a single dashboard with smart automation and seamless workflow.</p>
          </div>
        </div>
      </div><!-- End Service Item -->

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item d-flex position-relative h-100">
          <i class="bi bi-card-checklist icon flex-shrink-0"></i>
          <div>
            <h4 class="title"><a href="#" class="stretched-link">Multi-Courier Integration</a></h4>
            <p class="description">Connect with multiple courier partners and choose the best shipping option for faster and cost-effective delivery.</p>
          </div>
        </div>
      </div><!-- End Service Item -->

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item d-flex position-relative h-100">
          <i class="bi bi-bar-chart icon flex-shrink-0"></i>
          <div>
            <h4 class="title"><a href="#" class="stretched-link">Analytics & Reports</a></h4>
            <p class="description">Gain valuable insights into your shipping performance with detailed reports and real-time analytics.</p>
          </div>
        </div>
      </div><!-- End Service Item -->

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="service-item d-flex position-relative h-100">
          <i class="bi bi-binoculars icon flex-shrink-0"></i>
          <div>
            <h4 class="title"><a href="#" class="stretched-link">Real-Time Tracking</a></h4>
            <p class="description">Track every shipment live and keep your customers updated with accurate delivery status.</p>
          </div>
        </div>
      </div><!-- End Service Item -->

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="service-item d-flex position-relative h-100">
          <i class="bi bi-brightness-high icon flex-shrink-0"></i>
          <div>
            <h4 class="title"><a href="#" class="stretched-link">NDR Management</a></h4>
            <p class="description">Reduce RTO with automated NDR handling and smart reattempt strategies for failed deliveries.</p>
          </div>
        </div>
      </div><!-- End Service Item -->

      <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="service-item d-flex position-relative h-100">
          <i class="bi bi-calendar4-week icon flex-shrink-0"></i>
          <div>
            <h4 class="title"><a href="#" class="stretched-link">Scheduled Deliveries</a></h4>
            <p class="description">Plan and schedule deliveries efficiently to ensure timely dispatch and better customer satisfaction.</p>
          </div>
        </div>
      </div><!-- End Service Item -->

    </div>

  </div>

</section><!-- /Services Section -->

  <!-- Features Section -->
<section id="features" class="features section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Features</h2>
    <p>Powerful Shipping & Logistics Solutions</p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row">
      <div class="col-lg-3">
        <ul class="nav nav-tabs flex-column">
          <li class="nav-item">
            <a class="nav-link active show" data-bs-toggle="tab" href="#features-tab-1">Order Management</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#features-tab-2">Multi-Courier Integration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#features-tab-3">Real-Time Tracking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#features-tab-4">Automation & NDR</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#features-tab-5">Analytics & Reports</a>
          </li>
        </ul>
      </div>

      <div class="col-lg-9 mt-4 mt-lg-0">
        <div class="tab-content">

          <!-- Tab 1 -->
          <div class="tab-pane active show" id="features-tab-1">
            <div class="row">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3>Smart Order Management System</h3>
                <p class="fst-italic">Manage all your orders from a single dashboard with ease and efficiency.</p>
                <p>Our system allows you to process, organize, and track orders seamlessly. Reduce manual work, avoid errors, and improve delivery speed with automated workflows and centralized control.</p>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="assets/img/tabs/tab-1.png" alt="" class="img-fluid">
              </div>
            </div>
          </div>

          <!-- Tab 2 -->
          <div class="tab-pane" id="features-tab-2">
            <div class="row">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3>Multi-Courier Integration</h3>
                <p class="fst-italic">Connect with top courier partners from one platform.</p>
                <p>Choose the best courier based on price, speed, and serviceability. Easily switch between partners and ensure smooth shipping operations across all regions.</p>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="assets/img/tabs/tab-2.png" alt="" class="img-fluid">
              </div>
            </div>
          </div>

          <!-- Tab 3 -->
          <div class="tab-pane" id="features-tab-3">
            <div class="row">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3>Real-Time Shipment Tracking</h3>
                <p class="fst-italic">Track every shipment with live updates.</p>
                <p>Provide your customers with accurate tracking details and stay informed about delivery status, delays, and successful deliveries—all in real time.</p>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="assets/img/tabs/tab-3.png" alt="" class="img-fluid">
              </div>
            </div>
          </div>

          <!-- Tab 4 -->
          <div class="tab-pane" id="features-tab-4">
            <div class="row">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3>Automation & NDR Management</h3>
                <p class="fst-italic">Reduce returns with smart automation tools.</p>
                <p>Automatically handle non-delivery reports (NDR), reattempt deliveries, and improve success rates using intelligent automation and customer communication tools.</p>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="assets/img/tabs/tab-4.png" alt="" class="img-fluid">
              </div>
            </div>
          </div>

          <!-- Tab 5 -->
          <div class="tab-pane" id="features-tab-5">
            <div class="row">
              <div class="col-lg-8 details order-2 order-lg-1">
                <h3>Advanced Analytics & Reports</h3>
                <p class="fst-italic">Make data-driven decisions for your business.</p>
                <p>Access detailed reports on shipping performance, delivery timelines, and cost analysis to optimize your logistics strategy and boost efficiency.</p>
              </div>
              <div class="col-lg-4 text-center order-1 order-lg-2">
                <img src="assets/img/tabs/tab-5.png" alt="" class="img-fluid">
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>

</section><!-- /Features Section -->
<section id="terms" class="terms section py-5">
        <div class="container section-title" data-aos="fade-up">
            <h2>Terms & Conditions</h2>
            <p>Please read our usage policy carefully</p>
        </div>

        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion accordion-flush" id="termsAccordion">
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#term1">
                                    1. Acceptance of Terms
                                </button>
                            </h2>
                            <div id="term1" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    By accessing and using FleetShyp services, you agree to comply with and be bound by these Terms and Conditions. If you do not agree, please refrain from using our platform.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#term2">
                                    2. Service Usage & Eligibility
                                </button>
                            </h2>
                            <div id="term2" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    Users must provide accurate information during registration. FleetShyp reserves the right to suspend accounts that provide false data or engage in fraudulent shipping activities.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#term3">
                                    3. Shipping & Delivery Policy
                                </button>
                            </h2>
                            <div id="term3" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    While we partner with top-tier couriers, delivery timelines are estimates. FleetShyp is not liable for delays caused by weather, natural disasters, or courier-specific operational issues.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#term4">
                                    4. NDR & RTO Management
                                </button>
                            </h2>
                            <div id="term4" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    Non-Delivery Reports (NDR) must be responded to within the stipulated time frame to minimize Return to Origin (RTO) charges. Automated reattempts are subject to courier partner policies.
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="text-muted small">* Last updated: October 2023. For full detailed policy, please <a href="{{ route('termconditionpdf') }}">download the PDF version</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

  </main>

  @endsection