@extends('web.layouts.app')

@section('title', 'Home Page')

@section('content')


<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero-static section" style="background-color: #ffff;">
    <div class="container-fluid container-xl">
        <div class="row align-items-center">
            
            <div class="col-lg-7" data-aos="fade-right">
                <div class="hero-img-wrapper position-relative text-center">
                    
                    <img src="{{ asset('assets/img/home-high-quality.jpg') }}" class="main-hero-img img-fluid" alt="Shipping">

                    <div class="stat-card card-1 shadow-sm">
                        <span class="num text-orange">40K+</span>
                        <span class="txt">DAILY SHIPMENT</span>
                    </div>
                    
                    <div class="stat-card card-2 shadow-sm">
                        <span class="num text-orange">95%</span>
                        <span class="txt">SLA ADHERENCE</span>
                    </div>

                    <div class="stat-card card-3 shadow-sm">
                        <span class="num text-orange">5K+</span>
                        <span class="txt">LEADING BRANDS</span>
                    </div>
                    
                    <div class="stat-card card-4 shadow-sm">
                        <span class="num text-orange">1M+</span>
                        <span class="txt">SATISFIED USERS</span>
                    </div>

                    <div class="update-card shadow-sm">
                        <i class="bi bi-telephone-fill text-success"></i>
                        <span>Your order is arriving today</span>
                    </div>
                    
                    <div class="track-bubble shadow-sm">
                        <p>Hi, Your order from Nike containing Nike Shoes will be delivered...</p>
                        <a href="#"><i class="bi bi-box-arrow-up-right"></i> Track Now</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 content-block text-center" data-aos="fade-left">
                <div class="badge-container mb-4">
                    <img src="{{ asset('assets/img/fleetsheep1.png') }}" class="img-fluid rounded-circle" width="150" height="150" alt="Badge" style="object-fit: cover;">
                </div>
                
                <h1>Your Shipment<br>Our Commitment</h1>
                <p class="lead mb-3">
                    Experience AI-enabled logistics solutions tailored to revolutionize your e-commerce business.
                </p>
                <a href="/seller/register" class="btn-register-main">Register</a>
            </div>
            
        </div>
    </div>
</section><!-- /Hero Section -->
    <!----ecommers----->
    <section class="integration-section">
  <div class="box" style="box-shadow:0 2px 8px rgba(0,0,0,0.08)">
    <!-- LEFT SIDE -->
    <div class="left">
      <img src="{{ asset('assets/img/home2.jpg') }}" alt="integration" height="550" />
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
      <h1>
        Integrate eCommerce <br />
        stores and marketplaces for <br />
        a stress-free experience
      </h1>

      <p class="subtitle">
        Seamlessly sync, manage orders, and track shipments at a single-stop
      </p>

      <ul class="features">
        <li>Expand reach & simplify growth</li>
        <li>Auto-sync order in one place</li>
        <li>View a compiled buyer data</li>
      </ul>

      <a href="#" class="cta">Get Started →</a>
    </div>
  </div>
</section>
    <!----/ecommers----->
    <!--Brand Section-->
 <section id="brands-scroll" class="brands-scroll section">
    <div class="container p-4 rounded-5" style="box-shadow:0 2px 8px rgba(0,0,0,0.08)">
        <div class="row align-items-center gy-4">
            
            <!-- Text Column -->
            <div class="col-12 col-lg-5 text-center text-lg-start" data-aos="fade-up">
                <div class="brands-content">
                    <h2 class="display-5 fw-bold">Leading <span class="text-orange">Brands</span></h2>
                    <p class="text-secondary mt-3">Leading brands choose FleetSheep for their e-commerce needs. Join our growing list of satisfied clients.</p>
                </div>
            </div>

            <!-- Scroll Column -->
            <div class="col-12 col-lg-7">
                <div class="logo-scroll-wrapper-horizontal">
                    <div class="logo-scroll-track-h">
                        
                        <!-- Original Rows -->
                        <div class="logo-list-h">
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand.jpeg') }}" alt="Brand 2"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand1.jpeg') }}" alt="Brand 3"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand2.jpeg') }}" alt="Brand 4"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand3.jpeg') }}" alt="Brand 5"></div>
                        </div>
                        <div class="logo-list-h">
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand4.jpeg') }}" alt="Brand 6"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand5.jpeg') }}" alt="Balaji"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand6.jpeg') }}" alt="Logo"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand7.jpeg') }}" alt="Red Tape"></div>
                        </div>

                        <!-- ⚠️ DUPLICATE ROWS FOR SEAMLESS LOOP -->
                        <div class="logo-list-h">
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand.jpeg') }}" alt="Brand 2"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand1.jpeg') }}" alt="Brand 3"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand2.jpeg') }}" alt="Brand 4"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand3.jpeg') }}" alt="Brand 5"></div>
                        </div>
                        <div class="logo-list-h">
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand4.jpeg') }}" alt="Brand 6"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand5.jpeg') }}" alt="Balaji"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand6.jpeg') }}" alt="Logo"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/leadingbrand7.jpeg') }}" alt="Red Tape"></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
    <!--/Brand Section-->
<!--Video section-->
<section id="how-it-works" class="how-it-works py-5" style="box-shadow:0 2px 8px rgba(0,0,0,0.08)">

    <div class="container text-center mb-5">
        <h2 class="fw-bold display-5">How <span class="text-orange">Fleetshyp</span> Works</h2>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">

                <div class="video-wrapper shadow-lg">

                    <!-- ✅ VIDEO -->
                    <video id="myVideo" poster="assets/img/thumbnail3.jpeg">
                        <source src="assets/img/fleetshyp.mp4" type="video/mp4" height="60%">
                        Your browser does not support the video tag.
                    </video>

                    <!-- ✅ PLAY BUTTON -->
                    <div class="play-btn-overlay d-flex align-items-center justify-content-center">
                        <div class="play-btn" onclick="toggleVideo()">
                            <i id="playIcon" class="bi bi-play-fill"></i>
                        </div>
                    </div>

                    <!-- Top Label -->
                    <div class="video-label top-label">
                        Unlock Effortless E-commerce Shipping...
                    </div>

                    <!-- Bottom Label -->
                    <div class="video-label bottom-label d-flex justify-content-between align-items-center">
                        <span>Watch Video</span>
                        <div class="video-icons">
                            <i class="bi bi-share"></i>
                            <i class="bi bi-clock"></i>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</section>
<!--/Video section-->
<!-- text Section -->
<section id="hero-layout" class="hero-layout py-5" style="background-color: #fff;">
    <div class="container">
        
        <div class="row mb-5 text-center" data-aos="fade-down">
            <div class="col-12">
                <h5 class="display-5 fw-bold" style="color: #000839;">
                    We Are <span id="typed-text" class="text-orange"></span>
                </h5>
            </div>
        </div>

        <div class="row align-items-center">
            
            <div class="col-lg-6" data-aos="fade-right">
                <div class="pe-lg-5">
                    <p class="lead text-dark ps-4" style="font-size: 1.0rem; line-height: 1.5;">
                        Transforming your Ecommerce shipping with our automated shipping aggregator 
                        designed for B2B, B2C and D2C sellers. Ecommerce logistics, enhance your 
                        customer experience and help your business grow with our expert 
                        shipping solutions.
                    </p>
                    <p class="text-secondary ps-4">
                        Our platform ensures seamless integration with multiple courier partners, 
                        giving you the power to track and manage everything from one place.
                    </p>
                </div>
            </div>

            <div class="col-lg-6 text-center" data-aos="fade-left">
                <div class="hero-image-box">
                    <img src="{{ asset('assets/img/girlworking.png') }}" class="img-fluid" alt="Delivery Boy" style="max-height: 250px;">
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- text Section -->

    <!-- About Section -->
 <section id="about" class="about section">

    <div class="container">
        
        <!-- ✅ Shadow Yahan Apply Hoga -->
        <div class="about-card" style="background: #ffffff; border-radius: 12px; box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12); padding: 2rem 1.5rem;">

            <!-- Section Title -->
            <div class="section-title mb-4" data-aos="fade-up">
                <h2>About</h2>
                <p>About Us<br></p>
            </div>

            <div class="row gy-4">

                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                    <p>
                        FleetSheep is a powerful shipping platform designed to simplify your logistics operations.
                        Manage multiple courier partners, automate delivery processes, and track shipments in
                        real-time—all from a single dashboard.
                    </p>
                    <ul>
                        <li><i class="bi bi-check2-circle"></i> <span>Multi-courier integration with top partners like Delhivery, Ekart & Amazon.</span></li>
                        <li><i class="bi bi-check2-circle"></i> <span>Real-time shipment tracking for complete visibility and control.</span></li>
                        <li><i class="bi bi-check2-circle"></i> <span>Automated NDR management to reduce failed deliveries and RTO.</span></li>
                    </ul>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <p>
                        Boost your business growth with smart logistics solutions. FleetSheep helps you reduce
                        operational costs, improve delivery success rates, and enhance customer satisfaction with faster and more reliable shipping services.
                    </p>
                    <a href="{{ url('/about') }}" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                </div>

            </div>

        </div> <!-- /.about-card -->

    </div>

</section><!-- /About Section -->

    <!-- Clients Section -->
    <!-----Clients Section   -->

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

    <!-- why Choose Us -->
     <section class="why-choose-section">
    <div class="container">

        <h2 class="text-center mb-5 fs-2" style="color:#361f44">
            Why Choose <span>Us</span> ?
        </h2>

        <div class="row">

            <!-- Card 1 -->
            <div class="col-md-3">
                <div class="feature-card">
                    <i class="fa fa-indian-rupee-sign icon"></i>
                    <h4>Cost Effective</h4>
                    <p>
                        Get the best courier services at competitive pricing without compromising on delivery quality and speed.
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-3">
                <div class="feature-card">
                    <i class="fa fa-sliders icon"></i>
                    <h4>Smart Controls</h4>
                    <p>
                        Manage and customize your shipping preferences with flexible filters tailored to your business needs.
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-3">
                <div class="feature-card">
                    <i class="fa fa-brain icon"></i>
                    <h4>AI Optimization</h4>
                    <p>
                        Automatically assign the best courier partner using intelligent algorithms for faster and reliable delivery.
                    </p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-md-3">
                <div class="feature-card">
                    <i class="fa fa-globe icon"></i>
                    <h4>Custom Branding</h4>
                    <p>
                        Provide a fully branded tracking experience that builds trust and keeps your customers informed.
                    </p>
                </div>
            </div>
            

        </div>

    </div>
</section>
    <!-- why Choose Us -->

    <!-- Client Says -->
<section class="testimonial-section">
    <div class="container">

        <h2 class="text-center fs-2 mb-5" style="color:#361f44">
            Let’s see what our <span class="text-orang">Client</span> says
        </h2>

        <div class="testimonial-slider">
            <div class="testimonial-track">

                <!-- Repeat this card -->
                <div class="slide">
                    <div class="testimonial-card-pro">
                        <div class="card-header">
                            <img src="{{ asset('assets/img/clientb-3.jpg') }}" class="profile">
                            <div>
                                <h4 style="color:#361f44">Vikram Shah</h4>
                                <span>Founder</span>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                        
                        <p>"Excellent service! Deliveries are always on time and tracking is very smooth. Highly recommended for e-commerce businesses."</p>
                        
                        <div class="company">Fleetshyp</div>
                    </div>
                </div>

                <div class="slide">
                    <div class="testimonial-card-pro">
                        <div class="card-header">
                            <img src="{{ asset('assets/img/clientf-5.jpg') }}" class="profile">
                            <div>
                                <h4 style="color:#361f44">Neha Sharma</h4>
                                <span>Founder</span>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                        
                        <p>"This platform has made our shipping process super easy. We’ve seen a huge improvement in delivery efficiency."</p>
                       
                        <div class="company">Fleetshyp</div>
                    </div>
                </div>

                <div class="slide">
                    <div class="testimonial-card-pro">
                        <div class="card-header">
                            <img src="{{ asset('assets/img/cleentb-5.jpg') }}" class="profile">
                            <div>
                                <h4 style="color:#361f44">Rahul Verma</h4>
                                <span>Founder</span>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                        
                        <p>"Our logistics operations have become much more organized after using this service. Great experience so far!"</p>
                         
                        <div class="company">Fleetshyp</div>
                    </div>
                </div>

               <div class="slide">
                    <div class="testimonial-card-pro">
                        <div class="card-header">
                            <img src="{{ asset('assets/img/clientb-7.jpg') }}" class="profile">
                            <div>
                                <h4 style="color:#361f44">Shiv Nadar</h4>
                                <span>Founder</span>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                        
                        <p>"Very user-friendly dashboard and seamless tracking experience. Perfect for growing startups."</p>
                       
                        <div class="company">Fleetshyp</div>
                    </div>
                </div>

                 <div class="slide">
                    <div class="testimonial-card-pro">
                        <div class="card-header">
                            <img src="{{ asset('assets/img/clientg-1.png') }}" class="profile">
                            <div>
                                <h4 style="color:#361f44">Priya Vohra</h4>
                                <span>Founder</span>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                        
                        <p>"Very user-friendly dashboard and seamless tracking experience. Perfect for growing startups."</p>
                       
                        <div class="company">Fleetshyp</div>
                    </div>
                </div>

                 <div class="slide">
                    <div class="testimonial-card-pro">
                        <div class="card-header">
                            <img src="{{ asset('assets/img/clientb-2.jpg') }}" class="profile">
                            <div>
                                <h4 style="color:#361f44">Bhavin Turakhia</h4>
                                <span>Founder</span>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                       
                        <p>"Affordable pricing with top-quality service. Best choice for small and medium businesses."</p>
                       
                        <div class="company">Fleetshyp</div>
                    </div>
                </div>

                 <div class="slide">
                    <div class="testimonial-card-pro">
                        <div class="card-header">
                            <img src="{{ asset('assets/img/clientb-4.jpg') }}" class="profile">
                            <div>
                                <h4 style="color:#361f44">Sanjeev Bikhchandani</h4>
                                <span>Founder</span>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                        
                        <p>"Fast delivery, smooth integration, and excellent performance. Definitely a game changer!"</p>
                      
                        <div class="company">Fleetshyp</div>
                    </div>
                </div>

                 <div class="slide">
                    <div class="testimonial-card-pro">
                        <div class="card-header">
                            <img src="{{ asset('assets/img/clientf-6.jpg') }}" class="profile">
                            <div>
                                <h4 style="color:#361f44">Deepika Goyal</h4>
                                <span>Founder</span>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                       
                        <p>"Highly dependable logistics partner. We trust them completely for our daily shipments."</p>
                        
                        <div class="company">Fleetshyp</div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
    <!-- Client Says -->
    <!-- Portfolio Section -->
     <section class="faq-section">
  <div class="faq-container">

    <!-- LEFT -->
    <div class="faq-left mt-5">
      <span class="badge">FAQs</span>
      <h2>Frequently Asked Questions</h2>
      <p>
        Stay current with all the latest information, trends and industry
        expectation and more.
      </p>
    </div>

    <!-- RIGHT -->
    <div class="faq-right">

  <div class="faq-item">
    <button class="faq-question">What is FleetShyp?</button>
    <div class="faq-answer">
      FleetShyp is an all-in-one logistics and shipping platform that helps businesses manage orders, automate shipping, and connect with multiple courier partners from a single dashboard.
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">How does FleetShyp work?</button>
    <div class="faq-answer">
      FleetShyp integrates with your eCommerce store, automatically imports orders, and allows you to choose the best courier based on cost, delivery time, and serviceability.
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">
      How can I integrate my eCommerce store with FleetShyp?
    </button>
    <div class="faq-answer">
      You can easily integrate your store using plugins, APIs, or direct platform integrations like Shopify, WooCommerce, and Magento in just a few steps.
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">
      Which courier partners are integrated with FleetShyp?
    </button>
    <div class="faq-answer">
      FleetShyp partners with leading courier services such as Delhivery, DTDC, Ecom Express, and other regional carriers to ensure wide coverage and reliable delivery.
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">
      How does FleetShyp help reduce shipping costs?
    </button>
    <div class="faq-answer">
      FleetShyp compares multiple courier rates in real-time and suggests the most cost-effective option, helping you save money on every shipment.
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">
      How are shipping charges calculated on FleetShyp?
    </button>
    <div class="faq-answer">
      Shipping charges are calculated based on factors like package weight, dimensions, delivery location, and the selected courier partner.
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">
      Does FleetShyp provide insurance for lost shipments?
    </button>
    <div class="faq-answer">
      Yes, FleetShyp offers optional shipment insurance to protect your orders against loss or damage during transit.
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">
      Can FleetShyp deliver to remote or rural areas?
    </button>
    <div class="faq-answer">
      Yes, FleetShyp covers a wide range of pincodes across urban and rural areas through its extensive courier network.
    </div>
  </div>

  <div class="faq-item">
    <button class="faq-question">
      What is the pricing of FleetShyp?
    </button>
    <div class="faq-answer">
      FleetShyp offers flexible pricing plans based on your shipping volume, with no hidden charges. You can choose a plan that fits your business needs.
    </div>
  </div>

</div>
  </div>
</section>
    <!-- /Portfolio Section -->

</main>
<script>
function toggleVideo() {
    let video = document.getElementById("myVideo");
    let icon = document.getElementById("playIcon");

    if (video.paused) {
        video.play();
        icon.classList.remove("bi-play-fill");
        icon.classList.add("bi-pause-fill");
    } else {
        video.pause();
        icon.classList.remove("bi-pause-fill");
        icon.classList.add("bi-play-fill");
    }
}
</script>

<!-- client Says -->
<script>
let index = 0;
const track = document.querySelector('.testimonial-track');
const slides = document.querySelectorAll('.slide');

function moveSlide() {
    let visibleCards = 4;

    if (window.innerWidth < 992) visibleCards = 2;
    if (window.innerWidth < 576) visibleCards = 1;

    const totalSlides = slides.length;
    const maxIndex = totalSlides - visibleCards;

    index++;
    if (index > maxIndex) index = 0;

    const slideWidth = slides[0].offsetWidth;
    track.style.transform = `translateX(-${index * slideWidth}px)`;
}

/* Auto Slide */
setInterval(moveSlide, 3000);
</script>
<!-- client Says -->
<!-- FAQs -->
 <script>
  const items = document.querySelectorAll(".faq-item");

  items.forEach(item => {
    const question = item.querySelector(".faq-question");

    question.addEventListener("click", () => {
      item.classList.toggle("active");
    });
  });
</script>
<!-- /FAQs -->

<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>

<script>
  var typed = new Typed('#typed-text', {
    strings: ['Smart', 'Transparent', 'Reliable', 'Seamless'], 
    typeSpeed: 60,
    backSpeed: 40,
    backDelay: 2000,
    loop: true,
    showCursor: true,
    cursorChar: '|'
  });
</script>
@endsection
