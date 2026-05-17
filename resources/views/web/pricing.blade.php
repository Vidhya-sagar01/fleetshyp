@extends('web.layouts.app')

@section('title', 'Pricing - FleetShyp')

@section('content')

<section class="hero-section d-flex align-items-center text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="hero-title">Pricing Fleet<span style="color:#dfc369">Shyp</span></h1>
                <div class="hero-buttons">
                    <a href="{{ route('seller.login') }}" class="btn-get-started">Get Started</a>
                    <a href="{{ url('/about') }}" class="btn btn-outline">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- slider section -->
 <section id="pricing-slider" class="pricing-slider section py-5">
    <div class="container">
        
        <div class="pricing-header text-center mb-5">
            <h2 class=" fs-4 display-5">Right Prices, smooth Deliveries -</h2>
            <h2 class="fs-4 display-5">Powered by <span class="text-purple">Fleet</span><span class="text-orange">shyp</span></h2>
        </div>

        <div class="swiper pricing-swiper">
            <div class="swiper-wrapper">
                
                <div class="swiper-slide">
                    <div class="pricing-card shadow-sm">
                        <h3 class="fw-bold" style="color:#361f44">Lite</h3>
                        <p class="text-muted small mb-1">Shipping starts @</p>
                        <h2 class="price">₹29.5/0.5Kg</h2>
                        <p class="best-suited">Best suited for new & small businesses</p>
                        <button class="btn  w-100 my-3" style="background:#dfc369; color:white">Get Started</button>
                        <ul class="feature-list list-unstyled">
                            <li><i class="bi bi-check-lg text-danger"></i> Courier selection engine</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Email & SMS Tracking</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Standard Dashboard</li>
                        </ul>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="pricing-card shadow-sm">
                        <h3 class="fw-bold" style="color:#361f44">Advanced</h3>
                        <p class="text-muted small mb-1">Shipping starts @</p>
                        <h2 class="price">₹28.5/0.5Kg</h2>
                        <p class="best-suited">Best suited for < 1000 shipments</p>
                        <button class="btn w-100 my-3" style="background:#dfc369; color:white">Get Started</button>
                        <ul class="feature-list list-unstyled">
                            <li><i class="bi bi-check-lg text-danger"></i> Branded tracking page</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Custom shipping label</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Bulk order shipping</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Key Account Manager</li>
                        </ul>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="pricing-card shadow-sm">
                        <h3 class="fw-bold" style="color:#361f44">Professional</h3>
                        <p class="text-muted small mb-1">Shipping starts @</p>
                        <h2 class="price">₹27.5/0.5Kg</h2>
                        <p class="best-suited">Best suited for < 3000 shipments</p>
                        <button class="btn w-100 my-3" style="background:#dfc369; color:white">Get Started</button>
                        <ul class="feature-list list-unstyled">
                            <li><i class="bi bi-check-lg text-danger"></i> Custom Order VALIDATION</li>
                            <li><i class="bi bi-check-lg text-danger"></i> API Integration</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Post-ship communication</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Key Account Manager</li>
                        </ul>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="pricing-card shadow-sm">
                        <h3 class="fw-bold" style="color:#361f44">Enterprise</h3>
                        <p class="text-muted small mb-1">Shipping starts @</p>
                        <h2 class="price">₹27.5/0.5Kg</h2>
                        <p class="best-suited">Best suited for < 10k shipments</p>
                        <button class="btn  w-100 my-3" style="background:#dfc369; color:white">Get Started</button>
                        <ul class="feature-list list-unstyled">
                            <li><i class="bi bi-check-lg text-danger"></i> Whatsapp Communication</li>
                            <li><i class="bi bi-check-lg text-danger"></i> NDR Automated Workflow</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Client Excellence Manager</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Early COD D+3</li>
                        </ul>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="pricing-card shadow-sm">
                        <h3 class="fw-bold" style="color:#361f44">Enterprise+</h3>
                        <p class="text-muted small mb-1">Shipping starts @</p>
                        <h2 class="price">₹26.5/0.5Kg</h2>
                        <p class="best-suited">Best suited for > 10k shipments</p>
                        <button class="btn  w-100 my-3" style="background:#dfc369; color:white">Get Started</button>
                        <ul class="feature-list list-unstyled">
                            <li><i class="bi bi-check-lg text-danger"></i> Manual NDR Calling</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Dedicated Account Team</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Custom Rate API</li>
                            <li><i class="bi bi-check-lg text-danger"></i> Priority Support</li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="swiper-button-next custom-nav"></div>
            <div class="swiper-button-prev custom-nav"></div>
            <!-- <div class="swiper-pagination mt-4"></div> -->
        </div>
    </div>
</section>
<!-- slider section -->



<section id="refund-policy" class="refund-policy section py-5">
    <div class="container">
        <div class="section-title text-center mb-5" data-aos="fade-up">
            <h2>Refund & Cancellation Policy</h2>
            <p style="color:#361f44">Understand our commitment to transparency and service termination</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm p-4" data-aos="fade-up">
                    <div class="row gy-4">
                        
                        <div class="col-md-6">
                            <h5><i class="bi bi-person-x-fill me-2" style="color:#DABB55"></i>1. Account Closure</h5>
                            <p class="text-muted">You may request to close your account at any time by emailing us at <strong>Support@fleetshyp.com</strong>. Upon closure, all content and data will be permanently deleted. This action is irreversible.</p>
                        </div>

                        <div class="col-md-6">
                            <h5><i class="bi bi-cash-stack me-2" style="color:#DABB55"></i>2. Refund Process</h5>
                            <p class="text-muted">Request a refund via email or our support system. <strong>Note:</strong> Full refunds are only processed if there are no open shipments and no probability of weight discrepancies.</p>
                        </div>

                        <div class="col-md-6">
                            <h5><i class="bi bi-gear-wide-connected me-2" style="color:#DABB55"></i>3. Service Modification</h5>
                            <p class="text-muted">We reserve the right to modify or terminate the service at any time without notice to ensure the best possible platform experience.</p>
                        </div>

                        <div class="col-md-6">
                            <h5><i class="bi bi-shield-lock-fill me-2" style="color:#DABB55"></i>4. Fraud Prevention</h5>
                            <p class="text-muted">If we suspect fraudulent activity, we reserve the right to suspend or terminate your account immediately without notice or refund.</p>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="alert border-0 shadow-sm">
                                <strong><i class="bi bi-info-circle-fill me-2"></i>Important Terms:</strong>
                                <ul class="mb-0 mt-2 small">
                                    <li>Refunds are approved within 7 days and credited to your linked bank account.</li>
                                    <li>In-transit forward shipments may attract RTO charges, affecting the final refund amount.</li>
                                    <li>No refunds are offered if a plan is closed mid-month.</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.pricing-swiper', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    grabCursor: true,
    
    // Navigation Arrows enable karein
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    
    // Pagination dots
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true, // Dots ko chota-bada dikhayega slider ke saath
    },
    
    // Responsive breakpoints
    breakpoints: {
      768: { slidesPerView: 2 },
      1024: { slidesPerView: 3 },
      1400: { slidesPerView: 4 }
    }
});
  
</script>

@endsection