@extends('seller.layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F1E8] py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Company Card -->
            <div class="group">
                <div class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08),0_2px_10px_rgb(0,0,0,0.04)] border border-[#E8E4DA] h-full flex flex-col transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.12),0_4px_15px_rgb(0,0,0,0.06)] hover:-translate-y-1">
                    
                    <div class="flex justify-center mb-5">
                        <div class="w-[72px] h-[72px] rounded-full bg-gradient-to-br from-[#D4AF37] via-[#C4A532] to-[#B8941F] flex items-center justify-center shadow-[0_8px_20px_rgba(212,175,55,0.4),inset_0_2px_4px_rgba(255,255,255,0.3)] transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-globe text-white text-2xl drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]"></i>
                        </div>
                    </div>

                    <h3 class="text-center text-xl font-bold text-[#2C3E50] mb-6 tracking-wide">Company</h3>

                    <div class="bg-[#2C3E50] rounded-2xl p-5 flex-1 flex flex-col justify-center relative">
                        
                        <a href="{{ route('seller.settings.profile') }}" class="block relative mb-4 pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#2C3E50] border-2 border-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-regular fa-user text-[#D4AF37] text-lg"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Company Profile</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2"></i>
                            </div>
                        </a>

                        <a href="{{ route('seller.settings.kyc') }}" class="block relative mb-4 pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#2C3E50] border-2 border-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-solid fa-check-double text-[#D4AF37] text-lg"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">KYC</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                            </div>
                        </a>

                        <a href="{{ route('agreement.show') }}" class="block relative pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#2C3E50] border-2 border-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-solid fa-file-contract text-[#D4AF37] text-lg"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Agreement</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            <!-- Pickup Address Card -->
            <div class="group">
                <div class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08),0_2px_10px_rgb(0,0,0,0.04)] border border-[#E8E4DA] h-full flex flex-col transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.12),0_4px_15px_rgb(0,0,0,0.06)] hover:-translate-y-1">
                    
                    <div class="flex justify-center mb-5">
                        <div class="w-[72px] h-[72px] rounded-full bg-gradient-to-br from-[#D4AF37] via-[#C4A532] to-[#B8941F] flex items-center justify-center shadow-[0_8px_20px_rgba(212,175,55,0.4),inset_0_2px_4px_rgba(255,255,255,0.3)] transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-location-dot text-white text-2xl drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]"></i>
                        </div>
                    </div>

                    <h3 class="text-center text-xl font-bold text-[#2C3E50] mb-6 tracking-wide">Pickup Address</h3>

                    <div class="bg-[#2C3E50] rounded-2xl p-5 flex-1 flex flex-col justify-center relative">
                        <a href="{{route('add.whereHouse')}}" class="block relative pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-solid fa-map-location-dot text-[#2C3E50] text-lg drop-shadow-[0_1px_2px_rgba(255,255,255,0.3)]"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Manage Pickup Address</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                            </div>
                        </a>
                         <a href="{{route('warehouses.index')}}" class="block relative pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-solid fa-map-location-dot text-[#2C3E50] text-lg drop-shadow-[0_1px_2px_rgba(255,255,255,0.3)]"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">B2C & B2B Pickup Address</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- COD Payments Card -->
            <div class="group">
                <div class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08),0_2px_10px_rgb(0,0,0,0.04)] border border-[#E8E4DA] h-full flex flex-col transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.12),0_4px_15px_rgb(0,0,0,0.06)] hover:-translate-y-1">
                    
                    <div class="flex justify-center mb-5">
                        <div class="w-[72px] h-[72px] rounded-full bg-gradient-to-br from-[#D4AF37] via-[#C4A532] to-[#B8941F] flex items-center justify-center shadow-[0_8px_20px_rgba(212,175,55,0.4),inset_0_2px_4px_rgba(255,255,255,0.3)] transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-money-bill-transfer text-white text-2xl drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]"></i>
                        </div>
                    </div>

                    <h3 class="text-center text-xl font-bold text-[#2C3E50] mb-6 tracking-wide">COD Payments</h3>

                    <div class="bg-[#2C3E50] rounded-2xl p-5 flex-1 flex flex-col justify-center relative">
                        
                        <a href="{{route('bank-details.create')}}" class="block relative mb-4 pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#2C3E50] border-2 border-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-solid fa-building-columns text-[#D4AF37] text-lg"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Bank Detalis</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2"></i>
                            </div>
                        </a>

                        

                    </div>
                </div>
            </div>

            <!-- Billing Card -->
            <div class="group">
                <div class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08),0_2px_10px_rgb(0,0,0,0.04)] border border-[#E8E4DA] h-full flex flex-col transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.12),0_4px_15px_rgb(0,0,0,0.06)] hover:-translate-y-1">
                    
                    <div class="flex justify-center mb-5">
                        <div class="w-[72px] h-[72px] rounded-full bg-gradient-to-br from-[#D4AF37] via-[#C4A532] to-[#B8941F] flex items-center justify-center shadow-[0_8px_20px_rgba(212,175,55,0.4),inset_0_2px_4px_rgba(255,255,255,0.3)] transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-file-invoice-dollar text-white text-2xl drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]"></i>
                        </div>
                    </div>

                    <h3 class="text-center text-xl font-bold text-[#2C3E50] mb-6 tracking-wide">Billing</h3>

                    <div class="bg-[#2C3E50] rounded-2xl p-5 flex-1 flex flex-col justify-center relative">
                        
                        <a href="#" class="block relative mb-4 pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#2C3E50] border-2 border-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-solid fa-map-pin text-[#D4AF37] text-lg"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Billing Address</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2"></i>
                            </div>
                        </a>

                       

                    </div>
                </div>
            </div>

            <!-- Label, Invoice & POD Card - Fixed -->
            <div class="group">
                <div class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08),0_2px_10px_rgb(0,0,0,0.04)] border border-[#E8E4DA] h-full flex flex-col transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.12),0_4px_15px_rgb(0,0,0,0.06)] hover:-translate-y-1">
                    
                    <div class="flex justify-center mb-5">
                        <div class="w-[72px] h-[72px] rounded-full bg-gradient-to-br from-[#D4AF37] via-[#C4A532] to-[#B8941F] flex items-center justify-center shadow-[0_8px_20px_rgba(212,175,55,0.4),inset_0_2px_4px_rgba(255,255,255,0.3)] transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-file-circle-check text-white text-2xl drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]"></i>
                        </div>
                    </div>

                    <h3 class="text-center text-xl font-bold text-[#2C3E50] mb-6 tracking-wide">Label, Invoice & POD</h3>

                    <!-- Changed back to flex-1 so it fills space like Pickup Address -->
                    <div class="bg-[#2C3E50] rounded-2xl p-5 flex-1 flex flex-col justify-center relative">
                        <a href="{{route('label.index')}}" class="block relative pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-solid fa-tag text-[#2C3E50] text-lg drop-shadow-[0_1px_2px_rgba(255,255,255,0.3)]"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Label Preferences</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- API Details Card - Fixed -->
            <div class="group">
                <div class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08),0_2px_10px_rgb(0,0,0,0.04)] border border-[#E8E4DA] h-full flex flex-col transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.12),0_4px_15px_rgb(0,0,0,0.06)] hover:-translate-y-1">
                    
                    <div class="flex justify-center mb-5">
                        <div class="w-[72px] h-[72px] rounded-full bg-gradient-to-br from-[#D4AF37] via-[#C4A532] to-[#B8941F] flex items-center justify-center shadow-[0_8px_20px_rgba(212,175,55,0.4),inset_0_2px_4px_rgba(255,255,255,0.3)] transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-microchip text-white text-2xl drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]"></i>
                        </div>
                    </div>

                    <h3 class="text-center text-xl font-bold text-[#2C3E50] mb-6 tracking-wide">API Details</h3>

                    <!-- Changed back to flex-1 so it fills space like Pickup Address -->
                    <div class="bg-[#2C3E50] rounded-2xl p-5 flex-1 flex flex-col justify-center relative">
                        <a href="#" class="block relative pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-solid fa-key text-[#2C3E50] text-lg drop-shadow-[0_1px_2px_rgba(255,255,255,0.3)]"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Client Key</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Buyers Communication Card - Fixed -->
            <div class="group">
                <div class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08),0_2px_10px_rgb(0,0,0,0.04)] border border-[#E8E4DA] h-full flex flex-col transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.12),0_4px_15px_rgb(0,0,0,0.06)] hover:-translate-y-1">
                    
                    <div class="flex justify-center mb-5">
                        <div class="w-[72px] h-[72px] rounded-full bg-gradient-to-br from-[#D4AF37] via-[#C4A532] to-[#B8941F] flex items-center justify-center shadow-[0_8px_20px_rgba(212,175,55,0.4),inset_0_2px_4px_rgba(255,255,255,0.3)] transition-transform duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-comments text-white text-2xl drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]"></i>
                        </div>
                    </div>

                    <h3 class="text-center text-xl font-bold text-[#2C3E50] mb-6 tracking-wide">Buyers Communication</h3>

                    <!-- Changed back to flex-1 so it fills space like Pickup Address -->
                    <div class="bg-[#2C3E50] rounded-2xl p-5 flex-1 flex flex-col justify-center relative">
                        <a href="#" class="block relative pl-12 group/btn">
                            <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                <i class="fa-solid fa-comment-dots text-[#2C3E50] text-lg drop-shadow-[0_1px_2px_rgba(255,255,255,0.3)]"></i>
                            </div>
                            <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Webhook Settings</span>
                                <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Rules Card - Special -->
            <div class="group">
                <div class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08),0_2px_10px_rgb(0,0,0,0.04)] border border-[#E8E4DA] h-full flex flex-col transition-all duration-300 hover:shadow-[0_12px_40px_rgb(0,0,0,0.12),0_4px_15px_rgb(0,0,0,0.06)] hover:-translate-y-1 relative overflow-hidden">
                    
                    <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <circle cx="1" cy="1" r="1" fill="#D4AF37"/>
                            </pattern>
                            <rect fill="url(#grid)" width="100" height="100"/>
                        </svg>
                    </div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex justify-center mb-5">
                            <div class="w-[72px] h-[72px] rounded-full bg-gradient-to-br from-[#D4AF37] via-[#C4A532] to-[#B8941F] flex items-center justify-center shadow-[0_8px_20px_rgba(212,175,55,0.4),inset_0_2px_4px_rgba(255,255,255,0.3)] transition-transform duration-300 group-hover:scale-110">
                                <i class="fa-solid fa-list-check text-white text-2xl drop-shadow-[0_2px_4px_rgba(0,0,0,0.2)]"></i>
                            </div>
                        </div>

                        <h3 class="text-center text-xl font-bold text-[#2C3E50] mb-6 tracking-wide">Rules</h3>

                        <div class="bg-[#2C3E50] rounded-2xl p-5 flex-1 flex flex-col justify-center relative">
                            
                            <a href="{{route('seller.settings.termandcondition')}}" class="block relative mb-4 pl-12 group/btn">
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#2C3E50] border-2 border-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                    <i class="fa-solid fa-keyboard text-[#D4AF37] text-lg"></i>
                                </div>
                                <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                    <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Terms & Conditions</span>
                                    <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                                </div>
                            </a>

                            <a href="{{route('seller.settings.return-refund')}}" class="block relative mb-4 pl-12 group/btn">
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#2C3E50] border-2 border-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                    <i class="fa-solid fa-truck-fast text-[#D4AF37] text-lg"></i>
                                </div>
                                <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                    <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Return & Refund Policy</span>
                                    <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                                </div>
                            </a>

                            <a href="{{route('seller.settings.shipping-policy')}}" class="block relative mb-4 pl-12 group/btn">
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#2C3E50] border-2 border-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                    <i class="fa-solid fa-clipboard-check text-[#D4AF37] text-lg"></i>
                                </div>
                                <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                    <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Shipping Policy</span>
                                    <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                                </div>
                            </a>

                            <a href="{{route('seller.settings.privacy-policy')}}" class="block relative pl-12 group/btn">
                                <div class="absolute -left-3 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-[#2C3E50] border-2 border-[#D4AF37] flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.5)] z-10 transition-transform duration-300 group-hover/btn:scale-110">
                                    <i class="fa-solid fa-shield-halved text-[#D4AF37] text-lg"></i>
                                </div>
                                <div class="bg-[#34495E] rounded-full py-3 px-4 flex items-center shadow-[inset_0_2px_5px_rgba(0,0,0,0.3)] transition-all duration-300 group-hover/btn:bg-[#3d566e]">
                                    <span class="text-gray-200 text-xs font-semibold flex-1 tracking-wide uppercase">Privacy Policy</span>
                                    <i class="fa-solid fa-chevron-right text-[#D4AF37] text-[10px] ml-2 opacity-0 group-hover/btn:opacity-100 transition-opacity"></i>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="mt-12 text-center text-gray-400 text-xs tracking-[0.3em] font-medium uppercase">
            Copyright © 2026 FleetShyp Technologies. All Rights Reserved.
        </div>

    </div>
</div>

<style>
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #F5F1E8;
    }
    ::-webkit-scrollbar-thumb {
        background: #D4AF37;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #B8941F;
    }
</style>
@endsection