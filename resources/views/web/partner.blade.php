@extends('web.layouts.app')

@section('title', 'Careers - FleetShyp')

@section('content')

<main class="main">
    <!-- logo Section Start  -->
   {{-- Partners / Integrations Section --}}
<section class="partners-section">
    <div class="partners-wrapper">
        <svg class="partners-svg" viewBox="0 0 900 600" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">

            {{-- Curved paths from center to each partner --}}
            <path id="path1" d="M450,300 C420,260 370,220 310,190" fill="none" stroke="#3a3a6e" stroke-width="1.5" opacity="0.5"/>
            <path id="path2" d="M450,300 C400,300 340,310 270,340" fill="none" stroke="#3a3a6e" stroke-width="1.5" opacity="0.5"/>
            <path id="path3" d="M450,300 C400,340 340,380 230,430" fill="none" stroke="#3a3a6e" stroke-width="1.5" opacity="0.5"/>
            <path id="path4" d="M450,300 C440,360 420,410 390,480" fill="none" stroke="#3a3a6e" stroke-width="1.5" opacity="0.5"/>
            <path id="path5" d="M450,300 C460,250 500,200 600,150" fill="none" stroke="#3a3a6e" stroke-width="1.5" opacity="0.5"/>
            <path id="path6" d="M450,300 C520,260 620,210 730,180" fill="none" stroke="#3a3a6e" stroke-width="1.5" opacity="0.5"/>
            <path id="path7" d="M450,300 C530,290 620,290 710,310" fill="none" stroke="#3a3a6e" stroke-width="1.5" opacity="0.5"/>
            <path id="path8" d="M450,300 C510,340 580,390 660,450" fill="none" stroke="#3a3a6e" stroke-width="1.5" opacity="0.5"/>
            <path id="path9" d="M450,300 C560,330 660,380 770,430" fill="none" stroke="#3a3a6e" stroke-width="1.5" opacity="0.5"/>

            <defs>
                <marker id="arrowhead" markerWidth="6" markerHeight="6" refX="3" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L6,3 z" fill="#3a3a6e"/>
                </marker>
            </defs>

            <circle r="5" fill="#3a3a6e">
                <animateMotion dur="2.5s" repeatCount="indefinite" keyTimes="0;0.5;1" keyPoints="0;1;0">
                    <mpath href="#path1"/>
                </animateMotion>
            </circle>
            <circle r="5" fill="#3a3a6e">
                <animateMotion dur="3s" repeatCount="indefinite" keyTimes="0;0.5;1" keyPoints="0;1;0" begin="0.3s">
                    <mpath href="#path2"/>
                </animateMotion>
            </circle>
            <circle r="5" fill="#3a3a6e">
                <animateMotion dur="2.8s" repeatCount="indefinite" keyTimes="0;0.5;1" keyPoints="0;1;0" begin="0.6s">
                    <mpath href="#path3"/>
                </animateMotion>
            </circle>
            <circle r="5" fill="#3a3a6e">
                <animateMotion dur="3.2s" repeatCount="indefinite" keyTimes="0;0.5;1" keyPoints="0;1;0" begin="0.9s">
                    <mpath href="#path4"/>
                </animateMotion>
            </circle>
            <circle r="5" fill="#3a3a6e">
                <animateMotion dur="2.6s" repeatCount="indefinite" keyTimes="0;0.5;1" keyPoints="0;1;0" begin="1.2s">
                    <mpath href="#path5"/>
                </animateMotion>
            </circle>
            <circle r="5" fill="#3a3a6e">
                <animateMotion dur="3.1s" repeatCount="indefinite" keyTimes="0;0.5;1" keyPoints="0;1;0" begin="0.4s">
                    <mpath href="#path6"/>
                </animateMotion>
            </circle>
            <circle r="5" fill="#3a3a6e">
                <animateMotion dur="2.9s" repeatCount="indefinite" keyTimes="0;0.5;1" keyPoints="0;1;0" begin="0.7s">
                    <mpath href="#path7"/>
                </animateMotion>
            </circle>
            <circle r="5" fill="#3a3a6e">
                <animateMotion dur="2.7s" repeatCount="indefinite" keyTimes="0;0.5;1" keyPoints="0;1;0" begin="1.0s">
                    <mpath href="#path8"/>
                </animateMotion>
            </circle>
            <circle r="5" fill="#3a3a6e">
                <animateMotion dur="3.3s" repeatCount="indefinite" keyTimes="0;0.5;1" keyPoints="0;1;0" begin="1.5s">
                    <mpath href="#path9"/>
                </animateMotion>
            </circle>
        </svg>

       <div class="center-logo" style="display:flex; justify-content:center; align-items:center;">
            <div class="center-inner" style="width:140px; height:140px; display:flex; justify-content:center; align-items:center;">
                <div class="center-ring" style="width:120px; height:120px; border-radius:50%; overflow:hidden; border:3px solid #eee; display:flex; justify-content:center; align-items:center;">
                    <img src="{{ asset('assets/img/logo/fleetsheep1.png') }}" alt="logo" style="width:100%; height:100%; object-fit:contain;">
                </div>
            </div>
        </div>

        {{-- Partner Logo Nodes --}}
        <div class="partner-node" style="top:22%;left:28%"><img src="{{ asset('assets/img/partnerbrand1.jpeg') }}" alt="Ununi"></div>
        <div class="partner-node" style="top:12%;left:18%"><img src="{{ asset('assets/img/partnerbrand2.jpeg') }}" alt="logo"></div>
        <div class="partner-node" style="top:47%;left:22%"><img src="{{ asset('assets/img/partnerbrand3.jpeg') }}" alt="logo"></div>
        <div class="partner-node" style="top:72%;left:12%"><img src="{{ asset('assets/img/partnerbrand4.jpeg') }}" alt="logo"></div>
        <div class="partner-node" style="top:80%;left:36%"><img src="{{ asset('assets/img/partnerbrand5.jpeg') }}" alt="logo"></div>
        <div class="partner-node" style="top:10%;left:58%"><img src="{{ asset('assets/img/partnerbrand6.jpeg') }}" alt="logo"></div>
        <div class="partner-node" style="top:14%;left:76%"><img src="{{ asset('assets/img/partnerbrand7.jpeg') }}" alt="logo"></div>
        <div class="partner-node" style="top:40%;left:78%"><img src="{{ asset('assets/img/partnerbrand8.jpeg') }}" alt="logo"></div>
        <div class="partner-node" style="top:70%;left:64%"><img src="{{ asset('assets/img/partnerbrand9.jpeg') }}" alt="logo"></div>
        <div class="partner-node" style="top:68%;left:80%"><img src="{{ asset('assets/img/partnerbrand10.jpeg') }}" alt="logo"></div>
    </div>
</section>

<style>
    /* Center Logo Responsive Fix */
    .center-logo {
        position: relative;
        z-index: 10;
    }
    
    .center-inner,
    .center-ring {
        flex-shrink: 0;
    }
    
    /* Mobile Responsive - Keep logo circular */
    @media (max-width: 768px) {
        .center-inner {
            width: 100px !important;
            height: 100px !important;
        }
        
        .center-ring {
            width: 90px !important;
            height: 90px !important;
            border-width: 2px !important;
        }
        
        .partners-wrapper {
            transform: scale(0.85);
            transform-origin: center center;
        }
    }
    
    @media (max-width: 480px) {
        .center-inner {
            width: 80px !important;
            height: 80px !important;
        }
        
        .center-ring {
            width: 70px !important;
            height: 70px !important;
            border-width: 2px !important;
        }
        
        .partners-wrapper {
            transform: scale(0.7);
            transform-origin: center center;
        }
    }
    
    @media (max-width: 360px) {
        .center-inner {
            width: 70px !important;
            height: 70px !important;
        }
        
        .center-ring {
            width: 60px !important;
            height: 60px !important;
            border-width: 2px !important;
        }
        
        .partners-wrapper {
            transform: scale(0.65);
            transform-origin: center center;
        }
    }
</style>

    <!-- Integration section start -->
<section style="background:#fff; padding:50px 30px; font-family: Georgia, sans-serif;">

    <h3 style="text-align:center; font-size:32px; font-weight:700; color:#1a1a2e; margin-bottom:24px;">Integrations</h3>

    {{-- Tabs --}}
    <div style="display:flex; justify-content:center; border-bottom:1.5px solid #e0e0e0; margin-bottom:40px;">
        <button class="ig-tab active" onclick="showTab('courier', this)"
            style="padding:14px 0; font-size:15px; font-weight:700; color:#1a1a2e; cursor:pointer; border:none; border-bottom:3px solid #1a1a2e; margin-bottom:-1.5px; background:none; width:220px; text-align:center;">Courier Partners</button>
        <div style="width:300px;"></div>
        <button class="ig-tab" onclick="showTab('ecommerce', this)"
            style="padding:14px 0; font-size:15px; font-weight:500; color:#888; cursor:pointer; border:none; border-bottom:3px solid transparent; margin-bottom:-1.5px; background:none; width:220px; text-align:center;">E-Commerce Partners</button>
    </div>

    {{-- ===================== COURIER PARTNERS PANEL ===================== --}}
    <div class="ig-panel active" id="tab-courier" style="display: block;">
        <div class="cards-grid">
            {{-- Amazon Shipping --}}
            <div class="ig-card">
                <div class="ig-header"><span><b style="color:#f90;">amazon</b> shipping</span></div>
                <div class="ig-body">
                    <div class="ig-left"><p>Amazon Shipping is a reliable courier partner known for efficient service, with 98% pick-up performance and 92%+ TAT adherence, ensuring timely and dependable deliveries.</p></div>
                    <div class="ig-right">
                        <p class="pin-title">PIN Codes Available</p><h3>13000+</h3>
                        <div class="features-grid">
                            <div><span>COD</span><span class="yes">✔</span></div>
                            <div><span>Tracking</span><span class="yes">✔</span></div>
                            <div><span>Reverse Pick-up</span><span class="no">✖</span></div>
                            <div><span>Remote Presence</span><span class="no">✖</span></div>
                            <div><span>OTP Delivery</span><span class="yes">✔</span></div>
                        </div>
                    </div>
                </div>
                <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
            </div>

            {{-- Blue Dart --}}
            <div class="ig-card">
                <div class="ig-header"><span><b style="color:#003087;">BLUE</b> <b style="color:#e8192c;">DART</b></span></div>
                <div class="ig-body">
                    <div class="ig-left"><p>Blue Dart Air is renowned for its high standards in logistics, achieving up to 92% pick-up performance and 90%+ TAT adherence, ensuring consistent and reliable deliveries.</p></div>
                    <div class="ig-right">
                        <p class="pin-title">PIN Codes Available</p><h3>12000+</h3>
                        <div class="features-grid">
                            <div><span>COD</span><span class="yes">✔</span></div>
                            <div><span>Tracking</span><span class="yes">✔</span></div>
                            <div><span>Reverse Pick-up</span><span class="no">✖</span></div>
                            <div><span>Remote Presence</span><span class="no">✖</span></div>
                            <div><span>OTP Delivery</span><span class="yes">✔</span></div>
                        </div>
                    </div>
                </div>
                <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
            </div>
{{---Ekart-----}}
            <div class="ig-card">
    <div class="ig-header"><span><b style="color:#00B14F;">Ekart</b></span></div>
    <div class="ig-body">
        <div class="ig-left"><p>Ekart is Flipkart's in-house logistics arm, providing end-to-end supply chain solutions with 97% pick-up performance, 93%+ TAT adherence, and specialized expertise in e-commerce deliveries across India.</p></div>
        <div class="ig-right">
            <p class="pin-title">PIN Codes Available</p><h3>35000+</h3>
            <div class="features-grid">
                <div><span>COD</span><span class="yes">✔</span></div>
                <div><span>Tracking</span><span class="yes">✔</span></div>
                <div><span>Reverse Pick-up</span><span class="yes">✔</span></div>
                <div><span>Remote Presence</span><span class="yes">✔</span></div>
                <div><span>OTP Delivery</span><span class="yes">✔</span></div>
            </div>
        </div>
    </div>
    <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
</div>

            {{-- DTDC --}}
            <div class="ig-card">
                <div class="ig-header"><span><b style="color:#003087;">DTDC</b><b style="color:#e8192c;">-</b></span></div>
                <div class="ig-body">
                    <div class="ig-left"><p>DTDC, a leading logistics provider with 35+ years of expertise, delivers reliable solutions backed by advanced technology, covering 7,000+ specialized pin codes across India.</p></div>
                    <div class="ig-right">
                        <p class="pin-title">PIN Codes Available</p><h3>11000+</h3>
                        <div class="features-grid">
                            <div><span>COD</span><span class="yes">✔</span></div>
                            <div><span>Tracking</span><span class="yes">✔</span></div>
                            <div><span>Reverse Pick-up</span><span class="no">✖</span></div>
                            <div><span>Remote Presence</span><span class="no">✖</span></div>
                            <div><span>OTP Delivery</span><span class="no">✖</span></div>
                        </div>
                    </div>
                </div>
                <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
            </div>

           {{-- Shadowfax --}}
            <div class="ig-card">
    <div class="ig-header"><span><b style="color:#E53935;">Shadowfax</b></span></div>
    <div class="ig-body">
        <div class="ig-left"><p>Shadowfax delivers exceptional logistics services with 96% pick-up performance, 92%+ TAT adherence, and coverage across 8000+ specialized pin codes, ensuring reliable and timely deliveries for a wide range of shipments.</p></div>
        <div class="ig-right">
            <p class="pin-title">PIN Codes Available</p><h3>23000+</h3>
            <div class="features-grid">
                <div><span>COD</span><span class="yes">✔</span></div>
                <div><span>Tracking</span><span class="yes">✔</span></div>
                <div><span>Reverse Pick-up</span><span class="yes">✔</span></div>
                <div><span>Remote Presence</span><span class="no">✖</span></div>
                <div><span>OTP Delivery</span><span class="no">✖</span></div>
            </div>
        </div>
    </div>
    <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
</div>
 {{-- Xpressbees--}}
 <div class="ig-card">
    <div class="ig-header"><span><b style="color:#FF6B00;">Xpress</b><b style="color:#FF8C00;">Bees</b></span></div>
    <div class="ig-body">
        <div class="ig-left"><p>Xpressbees is a technology-driven logistics company offering comprehensive delivery solutions with 95% pick-up performance, 91%+ TAT adherence, and extensive pan-India coverage for e-commerce businesses.</p></div>
        <div class="ig-right">
            <p class="pin-title">PIN Codes Available</p><h3>27000+</h3>
            <div class="features-grid">
                <div><span>COD</span><span class="yes">✔</span></div>
                <div><span>Tracking</span><span class="yes">✔</span></div>
                <div><span>Reverse Pick-up</span><span class="yes">✔</span></div>
                <div><span>Remote Presence</span><span class="yes">✔</span></div>
                <div><span>OTP Delivery</span><span class="yes">✔</span></div>
            </div>
        </div>
    </div>
    <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
</div>


{{----Delhivery-------}}

<div class="ig-card">
    <div class="ig-header"><span><b style="color:#00AEEF;">Delhivery</b></span></div>
    <div class="ig-body">
        <div class="ig-left"><p>Delhivery is India's largest fully integrated logistics provider, offering comprehensive supply chain solutions with 96% pick-up performance, 92%+ TAT adherence, and unmatched reliability for businesses of all sizes.</p></div>
        <div class="ig-right">
            <p class="pin-title">PIN Codes Available</p><h3>19000+</h3>
            <div class="features-grid">
                <div><span>COD</span><span class="yes">✔</span></div>
                <div><span>Tracking</span><span class="yes">✔</span></div>
                <div><span>Reverse Pick-up</span><span class="yes">✔</span></div>
                <div><span>Remote Presence</span><span class="yes">✔</span></div>
                <div><span>OTP Delivery</span><span class="yes">✔</span></div>
            </div>
        </div>
    </div>
    <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
</div>

{{---Ecom Xpress---}}
<div class="ig-card">
    <div class="ig-header"><span><b style="color:#FF3E3E;">Ecom</b><b style="color:#FF6B6B;">Express</b></span></div>
    <div class="ig-body">
        <div class="ig-left"><p>Ecom Express is a leading technology-driven logistics company specializing in e-commerce deliveries, with 94% pick-up performance, 90%+ TAT adherence, and comprehensive last-mile connectivity across India.</p></div>
        <div class="ig-right">
            <p class="pin-title">PIN Codes Available</p><h3>18000+</h3>
            <div class="features-grid">
                <div><span>COD</span><span class="yes">✔</span></div>
                <div><span>Tracking</span><span class="yes">✔</span></div>
                <div><span>Reverse Pick-up</span><span class="yes">✔</span></div>
                <div><span>Remote Presence</span><span class="yes">✔</span></div>
                <div><span>OTP Delivery</span><span class="no">✖</span></div>
            </div>
        </div>
    </div>
    <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
</div>
        </div>
    </div>
    
    {{-- ===================== E-COMMERCE PARTNERS PANEL ===================== --}}
    <div class="ig-panel" id="tab-ecommerce" style="display: none;">
        <div class="cards-grid">
            {{-- Shopify --}}
            <div class="ig-card">
                <div class="ig-header"><span><b style="color:#96bf48;">Shopify</b></span></div>
                <div class="ig-body">
                    <div class="ig-left"><p>Seamlessly connect your Shopify store with FleetShyp for automated order syncing, real-time tracking, and streamlined shipping management across multiple couriers.</p></div>
                    <div class="ig-right">
                        <p class="pin-title">Stores Integrated</p><h3>50,000+</h3>
                        <div class="features-grid">
                            <div><span>Auto Order Sync</span><span class="yes">✔</span></div>
                            <div><span>Real-time Tracking</span><span class="yes">✔</span></div>
                            <div><span>Multi-Courier</span><span class="yes">✔</span></div>
                            <div><span>Return Management</span><span class="yes">✔</span></div>
                            <div><span>Analytics Dashboard</span><span class="yes">✔</span></div>
                        </div>
                    </div>
                </div>
                <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
            </div>

            {{-- WooCommerce --}}
            <div class="ig-card">
                <div class="ig-header"><span><b style="color:#96588a;">Woo</b><b style="color:#7f54b3;">Commerce</b></span></div>
                <div class="ig-body">
                    <div class="ig-left"><p>Powerful WooCommerce plugin that enables one-click shipping label generation, automated fulfillment workflows, and NDR management for your WordPress store.</p></div>
                    <div class="ig-right">
                        <p class="pin-title">Stores Integrated</p><h3>35,000+</h3>
                        <div class="features-grid">
                            <div><span>Auto Order Sync</span><span class="yes">✔</span></div>
                            <div><span>Real-time Tracking</span><span class="yes">✔</span></div>
                            <div><span>Multi-Courier</span><span class="yes">✔</span></div>
                            <div><span>Return Management</span><span class="yes">✔</span></div>
                            <div><span>Analytics Dashboard</span><span class="no">✖</span></div>
                        </div>
                    </div>
                </div>
                <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
            </div>

            {{-- Magento --}}
            <div class="ig-card">
                <div class="ig-header"><span><b style="color:#ee672f;">Magento</b></span></div>
                <div class="ig-body">
                    <div class="ig-left"><p>Enterprise-grade Magento integration offering bulk order processing, custom shipping rules, and advanced reporting for scaling e-commerce businesses.</p></div>
                    <div class="ig-right">
                        <p class="pin-title">Stores Integrated</p><h3>12,000+</h3>
                        <div class="features-grid">
                            <div><span>Auto Order Sync</span><span class="yes">✔</span></div>
                            <div><span>Real-time Tracking</span><span class="yes">✔</span></div>
                            <div><span>Multi-Courier</span><span class="yes">✔</span></div>
                            <div><span>Return Management</span><span class="yes">✔</span></div>
                            <div><span>Analytics Dashboard</span><span class="yes">✔</span></div>
                        </div>
                    </div>
                </div>
                <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
            </div>

            {{-- Unicommerce --}}
            <div class="ig-card">
    <div class="ig-header"><span><b style="color:#00a8e1;">uni</b><b style="color:#8bc53f;">commerce</b></span></div>
    <div class="ig-body">
        <div class="ig-left"><p>Unicommerce is a leading e-commerce platform that provides seamless integration, secure payments, mobile responsiveness, and scalability for growing businesses.</p></div>
        <div class="ig-right">
            <p class="pin-title">Stores Integrated</p><h3>25,000+</h3>
            <div class="features-grid">
                <div><span>Inventory Sync</span><span class="yes">✔</span></div>
                <div><span>Order Sync</span><span class="yes">✔</span></div>
            </div>
        </div>
    </div>
    <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
</div>

{{-- Clickpost --}}
<div class="ig-card">
    <div class="ig-header"><span><b style="color:#1e3a8a;">Click</b><b style="color:#3b82f6;">Post</b></span></div>
    <div class="ig-body">
        <div class="ig-left"><p>ClickPost is an AI-powered logistics platform that optimizes courier selection, reduces NDR rates, and delivers end-to-end shipment visibility for scaling e-commerce brands.</p></div>
        <div class="ig-right">
            <p class="pin-title">Stores Integrated</p><h3>40,000+</h3>
            <div class="features-grid">
                <div><span>AI Courier Selection</span><span class="yes">✔</span></div>
                <div><span>NDR Management</span><span class="yes">✔</span></div>
                <div><span>Real-time Tracking</span><span class="yes">✔</span></div>
                <div><span>Automated Returns</span><span class="yes">✔</span></div>
            </div>
        </div>
    </div>
    <div class="ig-footer"><button class="ig-btn">Integrate Now</button></div>
</div>
        </div>
    </div>
    
</section>

<style>
    /* Global box-sizing to prevent padding/border overflow */
    .ig-panel * { box-sizing: border-box; }

    /* Tab Panel Visibility */
    .ig-panel { display: none; }
    .ig-panel.active { display: block; }
    
    /* ===== GRID LAYOUT - 3 Cards Per Row ===== */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 10px;
    }
    
    /* Card Styles */
    .ig-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .ig-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    
    .ig-header {
        padding: 16px 20px;
        background: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
        font-size: 16px;
        font-weight: 700;
        color: #1a1a2e;
        text-align: center;
    }
    
    .ig-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: row;
        gap: 20px;
        align-items: flex-start;
    }
    
    .ig-left {
        flex: 1;
        min-width: 0; /* ✅ Critical: Allows text to wrap instead of overflowing */
    }
    
    .ig-left p {
        color: #555;
        line-height: 1.6;
        margin: 0;
        font-size: 14px; /* ✅ Reduced from 18px for better fit */
    }
    
    .ig-right {
        flex: 1;
        min-width: 0; /* ✅ Prevents right side from being crushed */
        border-left: 1px dashed #e0e0e0;
        padding-left: 20px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .pin-title {
        font-size: 12px; /* ✅ Reduced from 18px */
        color: #888;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1.3;
    }
    
    .ig-right h3 {
        font-size: 26px; /* ✅ Slightly reduced */
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 4px 0;
        line-height: 1.1;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px 10px;
        font-size: 12px;
        width: 100%;
    }
    
    .features-grid div {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #444;
        min-width: 0;
        gap: 6px; /* ✅ Space between label & icon */
    }
    
    .features-grid span:first-child {
        flex: 1;
        white-space: normal; /* ✅ Allows wrapping if label is long */
        line-height: 1.3;
    }
    
    .features-grid span:last-child {
        flex-shrink: 0;
        width: 14px;
        text-align: center;
        font-weight: 600;
    }
    
    .features-grid .yes { color: #28a745; }
    .features-grid .no { color: #dc3545; }
    
    .ig-footer {
        padding: 12px 20px 16px;
        text-align: right;
        border-top: 1px solid #f0f0f0;
    }
    
    .ig-btn {
        background: #1a1a2e;
        color: #fff;
        border: none;
        padding: 8px 20px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .ig-btn:hover { background: #2a2a4e; }
    
    /* ===== RESPONSIVE BREAKPOINTS ===== */
    @media (max-width: 1024px) {
        .cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .ig-body {
            flex-direction: column; /* ✅ Stack left/right on tablets */
            gap: 16px;
        }
        .ig-right {
            border-left: none;
            border-top: 1px dashed #e0e0e0;
            padding-left: 0;
            padding-top: 16px;
        }
    }
    
    @media (max-width: 480px) {
        .cards-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .features-grid {
            grid-template-columns: 1fr; /* ✅ Single column on mobile */
        }
    }
</style>

<script>
    function showTab(tab, el) {
        // Hide all panels
        document.querySelectorAll('.ig-panel').forEach(function(p) {
            p.classList.remove('active');
            p.style.display = 'none';
        });
        // Reset all tabs
        document.querySelectorAll('.ig-tab').forEach(function(t) {
            t.style.color = '#888';
            t.style.borderBottom = '3px solid transparent';
            t.style.fontWeight = '500';
        });
        // Show selected panel & highlight tab
        const selectedPanel = document.getElementById('tab-' + tab);
        selectedPanel.classList.add('active');
        selectedPanel.style.display = 'block';
        
        el.style.color = '#1a1a2e';
        el.style.borderBottom = '3px solid #1a1a2e';
        el.style.fontWeight = '700';
    }
</script>
<!-- Integration section end -->
  <!-- trusted section -->
      <!--Brand Section-->
  <section id="brands-scroll" class="brands-scroll section">
    <div class="container">
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
                            <div class="logo-item"><img src="{{ asset('assets/img/partnerbrand4.jpeg') }}" alt="Brand 6"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/partnerbrand5.jpeg') }}" alt="Balaji"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/partnerbrand6.jpeg') }}" alt="Logo"></div>
                            <div class="logo-item"><img src="{{ asset('assets/img/partnerbrand7.jpeg') }}" alt="Red Tape"></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
    <!--/Brand Section-->
     <!-- trusted section -->

</main>

@endsection

<style>
    /* ===== TRUSTED BRANDS SECTION - MOBILE RESPONSIVE ===== */
    #brands-scroll {
        padding: 60px 20px;
        overflow-x: hidden;
    }
    
    #brands-scroll .brands-content {
        padding: 0 15px;
    }
    
    #brands-scroll .brands-content h2 {
        font-size: 2.5rem;
        line-height: 1.2;
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    
    #brands-scroll .brands-content p {
        font-size: 1rem;
        line-height: 1.6;
        padding-right: 0;
    }
    
    /* Tablet Responsive */
    @media (max-width: 991px) {
        #brands-scroll .brands-content h2 {
            font-size: 2rem;
        }
        
        #brands-scroll .brands-content p {
            font-size: 0.95rem;
        }
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        #brands-scroll {
            padding: 40px 15px;
        }
        
        #brands-scroll .brands-content {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 10px;
        }
        
        #brands-scroll .brands-content h2 {
            font-size: 1.75rem;
            margin-bottom: 15px;
        }
        
        #brands-scroll .brands-content p {
            font-size: 0.9rem;
            margin-top: 10px !important;
        }
        
        /* Fix row alignment for mobile */
        #brands-scroll .row {
            flex-direction: column;
        }
        
        #brands-scroll .col-lg-5,
        #brands-scroll .col-lg-7 {
            width: 100%;
            max-width: 100%;
        }
    }
    
    /* Small Mobile */
    @media (max-width: 480px) {
        #brands-scroll {
            padding: 30px 10px;
        }
        
        #brands-scroll .brands-content h2 {
            font-size: 1.5rem;
        }
        
        #brands-scroll .brands-content p {
            font-size: 0.85rem;
        }
        
        /* Adjust logo scroll for small screens */
        #brands-scroll .logo-scroll-wrapper-horizontal {
            padding: 0 5px;
        }
    }
    
    /* Extra Small Mobile */
    @media (max-width: 360px) {
        #brands-scroll .brands-content h2 {
            font-size: 1.3rem;
        }
        
        #brands-scroll .brands-content p {
            font-size: 0.8rem;
        }
    }
</style>