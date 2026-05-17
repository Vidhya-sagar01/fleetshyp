@extends('web.layouts.app')

@section('title', 'Home Page')

@section('content')


 <!-- Hero Section -->
        <section class="hero-section d-flex align-items-center text-center">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-8">
                        <h1 class="hero-title">Contact Fleet<span style="color:#dfc369">Shyp</span></h1>

                        <div class="hero-buttons">
                           <a href="{{ route('seller.login') }}" class="btn-get-started">Get Started</a>
                            <a href="#" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

 <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4"> 

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Address</h3>
                <p><b>1-Branch - </b> C-block phase - 2 , vikas nagar uttam nagar, new delhi , 110059 <br><br>
                   <b>2-Branch -</b> Near Ford Hospital , NH-30, Khemnichak, New Jaganpura, PS, Ramkrishan Nagar, Patna, Bihar 800030  <br><br>
                   <b>Registered-</b>Dagmara, Supaul,847451 
                  </p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+91 7482099650 | 10AM - 6PM [Monday - saturday ] </p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>support@fleetshyp.com </p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->



@endsection