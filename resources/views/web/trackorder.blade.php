@extends('web.layouts.app')

@section('title', 'Home Page')

@section('content')
<main class="main">
<section class="tracking-section">
    <div class="container tracking-container">

        <!-- LEFT -->
        <div class="tracking-left">
            <h1 style="color:#361f44">Your Brand,<br><span>Smart Tracking</span></h1>
            <p>Provide fast, secure & transparent shipment tracking to your customers.</p>
            <button class="btn-track">Start Free Trial</button>
        </div>

        <!-- RIGHT -->
        <div class="tracking-card">
            <h2 class="fs-3">Track Your Order</h2>

            <form action="#" method="GET">
                <div class="input-box">
                    <i class="fa-solid fa-truck"></i>
                    <input type="text" name="awb" placeholder="Enter AWB Number" required>
                </div>

                <button type="submit" class="track-btn">Track Now</button>
            </form>

            <p>Can't find AWB? Check SMS or Email.</p>
        </div>

    </div>
</section>

<style>
        /* Base Reset & Fonts */
       

        /* Section Layout */
        .tracking-section {
            padding: 60px 20px;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .tracking-container {
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 80px;
            flex-wrap: wrap;
        }

        /* Left Side Styling */
        .tracking-left {
            flex: 1;
            min-width: 300px;
        }

        .tracking-left h1 {
            font-size: 2.8rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
            color: #3A4A5F;
        }

        .tracking-left h1 span {
            color: #D4A853; /* Image wala gold accent */
        }

        .tracking-left p {
            font-size: 1.05rem;
            color: #6B7280;
            margin-bottom: 32px;
            max-width: 450px;
        }

        .btn-track {
            background-color: #D4A853;
            color: #fff;
            border: none;
            padding: 14px 32px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-track:hover {
            background-color: #C09545;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 168, 83, 0.3);
        }

        /* Right Side Styling */
        .tracking-card {
            flex: 1;
            min-width: 300px;
            max-width: 420px;
        }

        .tracking-card h2 {
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #4A5568;
        }

        .input-box {
            display: flex;
            align-items: center;
            background-color: #F2EAE0; /* Slightly darker cream for input */
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 16px;
            transition: box-shadow 0.3s ease;
        }

        .input-box:focus-within {
            box-shadow: 0 0 0 2px rgba(212, 168, 83, 0.4);
        }

        .input-box i {
            color: #4A5568;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .input-box input {
            border: none;
            background: transparent;
            width: 100%;
            font-size: 1rem;
            color: #3A4A5F;
            outline: none;
        }

        .input-box input::placeholder {
            color: #9CA3AF;
        }

        .track-btn {
            width: 100%;
            background-color: #D4A853;
            color: #fff;
            border: none;
            padding: 15px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .track-btn:hover {
            background-color: #C09545;
        }

        .tracking-card > p {
            margin-top: 12px;
            font-size: 0.85rem;
            color: #4A5568;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tracking-container {
                flex-direction: column;
                text-align: center;
                gap: 40px;
            }
            .tracking-left p { margin: 0 auto 28px auto; }
            .tracking-card { max-width: 100%; }
        }
    </style>

<!-- Order Status -->
<section class="tracking-status">
    <div class="container">

        <h2 class="text-center mb-5">
            Know your order <span>Status</span>
        </h2>

@php
    $totalSteps = 5; $status=0;
    $progress = (($status - 1) / ($totalSteps - 1)) * 100;
@endphp

<div class="timeline">

    <div class="progress-bg"></div>
    <div class="progress-fill" style="--progress: {{ $progress }}%;"></div>

    <!-- Step 1 -->
    <div class="step {{ $status >= 1 ? 'completed' : '' }}">
        <div class="circle">
            <i class="fa fa-file-alt"></i>
        </div>
        <h4>Order Received</h4>
    </div>

    <!-- Step 2 -->
    <div class="step {{ $status >= 2 ? 'completed' : '' }}">
        <div class="circle">
            <i class="fa fa-truck-loading"></i>
        </div>
        <h4>Pickup Completed</h4>
    </div>

    <!-- Step 3 -->
    <div class="step {{ $status == 3 ? 'active' : ($status > 3 ? 'completed' : '') }}">
        <div class="circle">
            <i class="fa fa-route"></i>
        </div>
        <h4>In Transit</h4>
    </div>

    <!-- Step 4 -->
    <div class="step {{ $status == 4 ? 'active' : ($status > 4 ? 'completed' : '') }}">
        <div class="circle">
            <i class="fa fa-shipping-fast"></i>
        </div>
        <h4>Out for Delivery</h4>
    </div>

    <!-- Step 5 -->
    <div class="step {{ $status == 5 ? 'active' : '' }}">
        <div class="circle">
            <i class="fa fa-check"></i>
        </div>
        <h4>Delivered</h4>
    </div>

</div>
    </div>
</section>

 <!-- /Order Status -->
</main>
@endsection