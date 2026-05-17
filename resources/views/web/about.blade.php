@extends('web.layouts.app')

@section('title', 'Home Page')

@section('content')

<main class="main">

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center text-center">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-8">
                    <h1 class="hero-title" style="color:#361f44">About Fleet<span style="color:#dfc369">Shyp</span></h1>

                    <div class="hero-buttons">
                        <a href="{{ route('seller.login') }}" class="btn-get-started">Get Started</a>
                        <a href="{{ url('/about') }}" class="btn btn-outline">Learn More</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- About 2 Section -->
<section id="about-2" class="about-2 section">

    <div class="container" data-aos="fade-up">

        <!-- Row 1: Image & Main Content -->
        <div class="row g-4 g-lg-5 align-items-start" data-aos="fade-up" data-aos-delay="200">

            <!-- Image -->
            <div class="col-lg-5">
                <div class="about-img">
                    <img src="{{ asset('assets/img/about-1.jpg') }}" class="img-fluid" alt="FleetSheep">
                </div>
            </div>
          
            <!-- Content -->
            <div class="col-lg-7">
                <h2 class="mb-3" style="color:#361f44">About Fleetshyp </h2>
                <p class="mb-4">
                    Fleetshyp, a product of Fleet Shyp, is one of India’s latest and reliable tech-enabled logistics.
                    Fleetshyp is a revolutionary logistics and fulfilment platform designed to simplify e-commerce operations for Indian merchants. The company was founded with the aim of democratizing the e-commerce landscape in the country by providing innovative and reliable tech-enabled solutions. With a wide network of partnerships with multiple courier companies, Fleetshyp provides businesses with a single platform to manage their shipping operations, track their orders, and make informed decisions.
                    The current shipping solutions in the market have a significant shortcoming in terms of providing transparent information to businesses. This can often lead to businesses making uninformed decisions that can be costly in terms of both time and money. Fleetshyp bridges this gap by providing businesses with all the information they need to make informed decisions.
                    Fleetshyp is designed with the user in mind and offers an easy integration with online stores and marketplaces. This allows for automated sync and order tracking facilities, making the platform user-friendly and efficient. The platform is designed to simplify the e-commerce process, allowing businesses to focus on their core operations rather than worrying about managing orders and searching for reliable courier services.
                    With Fleetshyp, hundreds of e-commerce merchants have been able to build their brands and provide a delightful customer experience to their users. The platform has received widespread recognition for its innovative approach to logistics and fulfilment, and its ability to save merchants time and money.
                    Fleetshyp currently serves over 29,000 pin codes across India, providing businesses with a wide network of courier services. The company is committed to continuing to expand its services, providing merchants with reliable and cost-effective shipping solutions.
                    In conclusion, Fleetshyp is a game-changer in the e-commerce industry, providing businesses with a transparent and reliable platform to manage their shipping operations. With its innovative approach, Fleetshyp has taken a step forward in simplifying the e-commerce process for Indian merchants, saving them precious time and money and allowing them to focus on their core business operations.
                </p>
            </div>

        </div>

        <!-- Row 2: Full Width Tabs -->
        <div class="row mt-5" style="box-shadow:0 2px 8px rgba(0,0,0,0.08)">
            <div class="col-12">
                <div class="about-tabs-section">
                    
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-pills nav-fill w-100 mb-4">
                        <li><a class="nav-link active text-center"   data-bs-toggle="pill" href="#about-2-tab1">Our Vision</a></li>
                        <li><a class="nav-link text-center" data-bs-toggle="pill" href="#about-2-tab2">What We Offer</a></li>
                        <li><a class="nav-link  text-center"  data-bs-toggle="pill" href="#about-2-tab3">Our Advantages</a></li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">

                        <!-- Tab 1 -->
                        <div class="tab-pane fade show active" id="about-2-tab1">
                            <p class="fst-italic">
                                Our vision is to revolutionize the logistics industry by making shipping faster, smarter, and more reliable for businesses of all sizes.
                            </p>
                            <div class="d-flex align-items-start mt-4">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>
                                    <h5>Empowering Businesses</h5>
                                    <p>"We provide powerful, user-friendly tools that help businesses automate logistics and focus on sustainable growth, saving time and boosting operational efficiency."</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>
                                    <h5>Innovation Driven</h5>
                                    <p>"We continuously improve our platform with advanced features and automation to deliver seamless, scalable, and cost-effective shipping solutions."</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>
                                    <h5>Customer First Approach</h5>
                                    <p>"We focus on delivering better shipping experiences for both businesses and their customers, through seamless tracking, fast deliveries, and transparent communication."</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2 -->
                        <div class="tab-pane fade" id="about-2-tab2">
                            <p class="fst-italic">
                                FleetSheep offers a complete suite of logistics tools designed to simplify your shipping workflow.
                            </p>
                            <div class="d-flex align-items-start mt-4">
                                <i class="bi bi-truck me-2"></i>
                                <div>
                                    <h5>Multi-Courier Integration</h5>
                                    <p>Choose the best courier partner for each shipment with ease and flexibility.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3">
                                <i class="bi bi-geo-alt me-2"></i>
                                <div>
                                    <h5>Real-Time Tracking</h5>
                                    <p>Get live updates and complete visibility on all your shipments.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3">
                                <i class="bi bi-arrow-repeat me-2"></i>
                                <div>
                                    <h5>Automated NDR & RTO Control</h5>
                                    <p>Reduce failed deliveries and return orders with smart automation tools.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3">
                                <i class="bi bi-bar-chart-line me-2"></i>
                                <div>
                                    <h5>Advanced Analytics</h5>
                                    <p>Make data-driven decisions with detailed reports and insights.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3 -->
                        <div class="tab-pane fade" id="about-2-tab3">
                            <p class="fst-italic">
                                FleetSheep stands out by delivering reliable, scalable, and cost-effective logistics solutions.
                            </p>
                            <div class="d-flex align-items-start mt-4">
                                <i class="bi bi-lightning-charge me-2"></i>
                                <div>
                                    <h5>Faster Deliveries</h5>
                                    <p>Optimize shipping routes and partners to ensure quicker deliveries.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3">
                                <i class="bi bi-shield-check me-2"></i>
                                <div>
                                    <h5>Secure & Reliable</h5>
                                    <p>Your shipments and data are secure with advanced security systems.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3">
                                <i class="bi bi-graph-up-arrow me-2"></i>
                                <div>
                                    <h5>Scalable Growth</h5>
                                    <p>Whether small or large, our platform grows with your business needs.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mt-3">
                                <i class="bi bi-currency-rupee me-2"></i>
                                <div>
                                    <h5>Cost Efficiency</h5>
                                    <p>Reduce logistics costs with intelligent automation and planning.</p>
                                </div>
                            </div>
                        </div>

                    </div> <!-- /.tab-content -->
                </div> <!-- /.about-tabs-section -->
            </div>
        </div>

    </div>

</section>

    <!-- Stats Section -->
    <section id="stats" class="stats section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">

      <div class="col-lg-3 col-md-6">
        <div class="stats-item text-center w-100 h-100">
          <h4>
            <span data-purecounter-start="0" data-purecounter-end="2" data-purecounter-duration="1" class="purecounter"></span>
            <span>L+</span>
          </h4>
          <p>Happy Clients</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stats-item text-center w-100 h-100">
          <h4>
            <span data-purecounter-start="0" data-purecounter-end="6" data-purecounter-duration="1" class="purecounter"></span>
            <span>M+</span>
          </h4>
          <p>Total Shipments Delivered</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stats-item text-center w-100 h-100">
          <h4>
            <span data-purecounter-start="0" data-purecounter-end="2" data-purecounter-duration="1" class="purecounter"></span>
            <span>M+</span>
          </h4>
          <p>Orders Processed</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="stats-item text-center w-100 h-100">
          <h4>
            <span data-purecounter-start="0" data-purecounter-end="3.5" data-purecounter-duration="1" class="purecounter"></span>
            <span>M+</span>
          </h4>
          <p>Delivery Partners</p>
        </div>
      </div>

    </div>
  </div>

</section><!-- /Stats Section -->

    {{-- <!-- Team Section -->
    <section id="team" class="team section">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member d-flex align-items-start">
                        <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Walter White</h4>
                            <span>Chief Executive Officer</span>
                            <p>Explicabo voluptatem mollitia et repellat qui dolorum quasi</p>
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""> <i class="bi bi-linkedin"></i> </a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member d-flex align-items-start">
                        <div class="pic"><img src="assets/img/team/team-2.jpg" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Sarah Jhonson</h4>
                            <span>Product Manager</span>
                            <p>Aut maiores voluptates amet et quis praesentium qui senda para</p>
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""> <i class="bi bi-linkedin"></i> </a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-member d-flex align-items-start">
                        <div class="pic"><img src="assets/img/team/team-3.jpg" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>William Anderson</h4>
                            <span>CTO</span>
                            <p>Quisquam facilis cum velit laborum corrupti fuga rerum quia</p>
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""> <i class="bi bi-linkedin"></i> </a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="team-member d-flex align-items-start">
                        <div class="pic"><img src="assets/img/team/team-4.jpg" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4>Amanda Jepson</h4>
                            <span>Accountant</span>
                            <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                            <div class="social">
                                <a href=""><i class="bi bi-twitter-x"></i></a>
                                <a href=""><i class="bi bi-facebook"></i></a>
                                <a href=""><i class="bi bi-instagram"></i></a>
                                <a href=""> <i class="bi bi-linkedin"></i> </a>
                            </div>
                        </div>
                    </div>
                </div><!-- End Team Member -->

            </div>

        </div>

    </section><!-- /Team Section --> --}}

    {{-- <!-- Skills Section -->
    <section id="skills" class="skills section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Skills</h2>
            <p>Check Our Skills<br></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row skills-content skills-animation">

                <div class="col-lg-6">

                    <div class="progress">
                        <span class="skill"><span>HTML</span> <i class="val">100%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div><!-- End Skills Item -->

                    <div class="progress">
                        <span class="skill"><span>CSS</span> <i class="val">90%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div><!-- End Skills Item -->

                    <div class="progress">
                        <span class="skill"><span>JavaScript</span> <i class="val">75%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div><!-- End Skills Item -->

                </div>

                <div class="col-lg-6">

                    <div class="progress">
                        <span class="skill"><span>PHP</span> <i class="val">80%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div><!-- End Skills Item -->

                    <div class="progress">
                        <span class="skill"><span>WordPress/CMS</span> <i class="val">90%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div><!-- End Skills Item -->

                    <div class="progress">
                        <span class="skill"><span>Photoshop</span> <i class="val">55%</i></span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div><!-- End Skills Item -->

                </div>

            </div>

        </div>

    </section><!-- /Skills Section -->
    --}}

    <!-- About Us Section -->
    <section id="about-us" class="about-us section">

        <!-- Section Title -->
        <div class="container section-title text-center" data-aos="fade-up">
            <h2>About Us</h2>
            <p>Delivering Smart & Reliable Logistics Solutions</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">

                <!-- Left Image -->
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="zoom-in" data-aos-delay="150">
                    <div class="about-img">
                        <img src="{{ asset('assets/img/services-1.jpg') }}" class="img-fluid rounded"
                            alt="About FleetShyp">
                    </div>
                </div>

                <!-- Right Content -->
                <div class="col-lg-6">


                    <div class="row gy-4 mt-3">

                        <div class="col-md-6">
                            <div class="icon-box">
                                <i class="bi bi-truck"></i>
                                <h5>Fast Delivery</h5>
                                <p>Quick and reliable shipping across India.</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="icon-box">
                                <i class="bi bi-geo-alt"></i>
                                <h5>Live Tracking</h5>
                                <p>Track shipments in real-time updates.</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="icon-box">
                                <i class="bi bi-gear"></i>
                                <h5>Automation</h5>
                                <p>Reduce manual work with smart systems.</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="icon-box">
                                <i class="bi bi-people"></i>
                                <h5>24/7 Support</h5>
                                <p>Always available to help your business.</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


</main>

@endsection