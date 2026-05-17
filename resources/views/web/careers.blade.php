@extends('web.layouts.app')

@section('title', 'Careers - FleetShyp')

@section('content')

<main class="main">
    <section class="hero-section d-flex align-items-center text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="hero-title">Careers at Fleet<span style="color:#dfc369">Shyp</span></h1>
                    <p class="hero-text mb-4">Help us build the future of tech-driven logistics and smarter shipping.</p>
                    <div class="hero-buttons">
                        <a href="#openings" class="btn-get-started">View Openings</a>
                        <a href="{{ url('/about') }}" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="careers-intro" class="careers-intro section py-5">
        <div class="container  shadow p-4" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-4">Revolutionizing Logistics Together</h2>
                    <p>At Fleet Shyp, we are revolutionizing the logistics landscape. By bringing multiple premier courier services together onto a single, intuitive dashboard, we empower businesses to ship smarter, faster, and more efficiently.</p>
                    <p>We are a tech-driven logistics hub, and we are looking for passionate problem-solvers to help us build the future of shipping. Join us in our journey to simplify e-commerce operations across India.</p>
                </div>
                <div class="col-lg-6">
                    <div class="about-img p-4">
                        <img src="{{ asset('assets/img/team-collaboration.png') }}" class="img-fluid rounded shadow" alt="Careers at FleetShyp">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="why-join-us section py-5">
        <div class="container">
            <div class="section-title text-center mb-5" data-aos="fade-up">
                <h2>Why Build Your Career With Us?</h2>
            </div>
            <div class="row gy-4">
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <i class="bi bi-cpu fs-1 mb-3" style="color:#DABB55"></i>
                        <h5>Tech Meets Logistics</h5>
                        <p class="small text-muted">Work at the intersection of software and physical shipping, solving complex routing challenges.</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <i class="bi bi-graph-up-arrow fs-1 mb-3" style="color:#DABB55"></i>
                        <h5>Empowering Businesses</h5>
                        <p class="small text-muted">Directly help e-commerce brands streamline their operations and scale their growth.</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <i class="bi bi-lightbulb fs-1 mb-3" style="color:#DABB55"></i>
                        <h5>Continuous Innovation</h5>
                        <p class="small text-muted">Refining our dashboard and optimizing algorithms with the latest tech stack.</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="400">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <i class="bi bi-people fs-1 mb-3" style="color:#DABB55"></i>
                        <h5>Collaborative Environment</h5>
                        <p class="small text-muted">Join a fast-paced team where your ideas are valued and contributions have immediate impact.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="openings" class="openings section py-5">
        <div class="container" data-aos="fade-up">
            <div class="section-title text-center mb-5">
                <h2>Current Openings</h2>
                <p>Find a role that fits your passion</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="job-item d-flex align-items-center p-4 border rounded mb-3 shadow-sm">
                        <div class="flex-grow-1">
                            <h4>Partner Relations Manager</h4>
                            <p class="mb-0 text-muted">Onboard and manage relationships with new courier and delivery partners.</p>
                        </div>
                        <span class="badge rounded-pill" style="background:#DABB55">Management</span>
                    </div>

                    <div class="job-item d-flex align-items-center p-4 border rounded mb-3 shadow-sm">
                        <div class="flex-grow-1">
                            <h4>Full-Stack Developer</h4>
                            <p class="mb-0 text-muted">Build core architecture and ensure seamless API integrations.</p>
                        </div>
                        <span class="badge rounded-pill" style="background:#DABB55">Engineering</span>
                    </div>

                    <div class="job-item d-flex align-items-center p-4 border rounded mb-3 shadow-sm">
                        <div class="flex-grow-1">
                            <h4>Customer Success Specialist</h4>
                            <p class="mb-0 text-muted">Guide users through the dashboard and troubleshoot tech issues.</p>
                        </div>
                        <span class="badge rounded-pill" style="background:#DABB55">Support</span>
                    </div>

                    <div class="job-item d-flex align-items-center p-4 border rounded mb-3 shadow-sm">
                        <div class="flex-grow-1">
                            <h4>Sales Executive (B2B)</h4>
                            <p class="mb-0 text-muted">Demonstrate our unified dashboard to e-commerce businesses.</p>
                        </div>
                        <span class="badge rounded-pill" style="background:#DABB55">Sales</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="apply" class="apply section py-5 text-dark text-center mb-4 " style="box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        <div class="container" data-aos="zoom-in">
            <h2 class="text-white">Let’s Grow Together</h2>
            <p class="mb-4">If you are excited about simplifying the world of shipping and want to be part of an innovative team, we want to meet you.</p>
            <div class="application-box p-4 border rounded d-inline-block bg-white text-dark shadow">
                <p class="mb-0">Please send your resume and a brief note to:</p>
                <h4 class="mb-0"><a href="mailto:support@fleetshyp.com" class="fw-bold" style="color:#DABB55">support@fleetshyp.com</a></h4>
            </div>
        </div>
    </section>
</main>

@endsection