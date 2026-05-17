<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\KycController;
use App\Http\Controllers\Admin\AgreementController;
use App\Http\Controllers\Admin\AdminBankDetailController;
use App\Http\Controllers\Admin\RateCardController;
use App\Http\Controllers\Admin\MiniOrderController;
use App\Http\Controllers\Admin\RapidshypRateCardController;
use App\Http\Controllers\Admin\CourierController;
use App\Http\Controllers\Admin\AdminCodRemittanceController;
use App\Http\Controllers\Admin\RechageToUserController;
use App\Http\Controllers\Seller\SellerRatecardController;
use App\Http\Controllers\Seller\SettingsController;
use App\Http\Controllers\Seller\CompanyController;
use App\Http\Controllers\Seller\SellerAgreementController;
use App\Http\Controllers\Seller\BankDetailController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\SellerPickupAddressController;
use App\Http\Controllers\Seller\StatusController;
use App\Http\Controllers\Seller\NdrController;
use App\Http\Controllers\Seller\B2cOrderController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\LabelController;
use App\Http\Controllers\Seller\ForgotPasswordController;
use App\Http\Controllers\Seller\SellerProfileController;
use App\Http\Controllers\Seller\RapidshypB2cController;
use App\Http\Controllers\Seller\RapidshypB2cShippingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalletTransactionController;
use App\Http\Controllers\ChannelController ;
use App\Http\Controllers\Seller\ShippingController;
use App\Http\Controllers\TicketController ;
use App\Http\Controllers\Seller\FshipReverseOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RapidshypWarehouseController;
use App\Http\Controllers\ProductCatelogController;
use App\Http\Controllers\PhonePeController;

use Illuminate\Support\Facades\Mail;




Route::get('/test-mail', function () {
    try {
        Mail::raw('This is a test mail', function ($message) {
            $message->to('testinglifeinfotech@gmail.com')
                    ->subject('Test Mail');
        });

        return response()->json([
            'status' => true,
            'message' => 'Mail sent successfully!'
        ]);

    } catch (\Exception $e) {

dd($e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Mail sending failed!',
            'error' => $e->getMessage()
        ]);
    }
});

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/seller/login', [AuthController::class, 'showSellerLogin'])->name('seller.login');

// web start
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/careers', [HomeController::class, 'careers'])->name('careers');
Route::get('/termconditionpdf', [HomeController::class, 'termconditionpdf'])->name('termconditionpdf');
Route::get('/termscondition', [HomeController::class, 'termscondition']);
Route::get('/privacypolicy', [HomeController::class, 'privacypolicy']);
Route::get('/shippingpolicy', [HomeController::class, 'shippingpolicy']); 
Route::get('/refundcancellation', [HomeController::class, 'refundcancellation']);
Route::get('/trackorder', [HomeController::class, 'trackorder']);
Route::get('/partner',[HomeController::class,'partner']);


//  seller Forgot Password Routes

Route::get('/auth/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password');
Route::post('/auth/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('send-email-forgot-password');
Route::post('/auth/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('forgot-password.verify-otp');
Route::post('/auth/forgot-password/update-password', [ForgotPasswordController::class, 'updatePassword'])->name('forgot-password.update');

// web end

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::middleware('guest')->group(function () {

    //  ADMIN AUTH
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin']) ->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');

    //  SELLER AUTH
    Route::post('/seller/login', [AuthController::class, 'sellerLogin']);

    Route::get('/seller/register', [AuthController::class, 'showSellerRegister'])->name('seller.register');
    Route::post('/seller/register', [AuthController::class, 'sellerRegister']);
});



// Logout Route (Sirf login user ke liye)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/seller/logout', [AuthController::class, 'sellerLogout'])->name('seller.logout')->middleware('auth');





// Admin Routes Group
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');

    


    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customers.index');
    Route::post('/customers', [AdminCustomerController::class, 'store'])->name('admin.customers.store');
    Route::get('/customers/{user}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');
    Route::get('/customers/{user}/edit', [AdminCustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::put('/customers/{user}', [AdminCustomerController::class, 'update'])->name('admin.customers.update');
    Route::delete('/customers/{user}', [AdminCustomerController::class, 'destroy'])->name('admin.customers.destroy');
    
    //kyc details
    Route::get('/kyc/pending', [KycController::class, 'getPendingKyc'])->name('kyc.pending');
    Route::get('/kyc/approved', [KycController::class, 'approvedIndex'])->name('kyc.approved');
    Route::get('/kyc/rejected', [KycController::class, 'rejectedIndex'])->name('kyc.rejected');
    Route::get('/kyc/{id}/view', [KycController::class, 'show'])->name('kyc.show');
    Route::post('/kyc/{id}/approve', [KycController::class, 'approve'])->name('kyc.approve');
    Route::post('/kyc/{id}/reject', [KycController::class, 'reject'])->name('kyc.reject');
    Route::post('/kyc/{id}/reapprove', [KycController::class, 'reapprove'])->name('kyc.reapprove');
    Route::get('/kyc/export/{type}', [KycController::class, 'export'])->name('kyc.export');
    Route::get('/kyc/{id}/download', [KycController::class, 'download'])->name('kyc.download');
    
    // Bulk Actions
    Route::post('/customers/bulk', [AdminCustomerController::class, 'bulkAction'])->name('admin.customers.bulk');
    Route::patch('/customers/{user}/status', [AdminCustomerController::class, 'updateStatus'])->name('admin.customers.status');
    Route::get('/customers/export', [AdminCustomerController::class, 'export'])->name('admin.customers.export');

    //Agrrement Management
    Route::get('/agreements', [AgreementController::class, 'index'])->name('admin.agreements.index');
    Route::post('/agreements', [AgreementController::class, 'store'])->name('admin.agreements.store');
    Route::get('/seller/agreements/stats', [AgreementController::class, 'stats'])->name('admin.agreements.stats');
    Route::get('/seller/agreements/signed-list', [AgreementController::class, 'signedAgreements'])->name('admin.agreements.signedList');
    Route::get('/admin/agreements/{id}/download', [AgreementController::class, 'download'])->name('admin.agreements.download');


    //bank route 
    Route::get('/bank-details', [AdminBankDetailController::class, 'index'])->name('admin.bank.index');
    Route::get('/bank-details/{id}', [AdminBankDetailController::class, 'show'])->name('admin.bank.show');
    Route::post('/bank-details/{id}/approve', [AdminBankDetailController::class, 'approve'])->name('admin.bank.approve');
    Route::post('/bank-details/{id}/reject', [AdminBankDetailController::class, 'reject'])->name('admin.bank.reject');
    Route::get('/admin/bank-cheque/{id}', [AdminBankDetailController::class, 'viewCheque'])->name('admin.bank.cheque.view');
    Route::get('/bank-details/approved', [AdminBankDetailController::class, 'approvedList'])->name('admin.bank.approved');


    


    //mini oreder routes 

    Route::get('/minioerders', [MiniOrderController::class, 'index'])->name('miniOerder.index');
    Route::get('/miniorderslist', [MiniOrderController::class, 'ordersList'])->name('api.orders-list');
    Route::get('/minioerder/api/users', [MiniOrderController::class, 'usersData'])->name('api.users');
    Route::get('/miniorder/api/locations', [MiniOrderController::class, 'locationsData'])->name('api.locations');
    Route::get('/miniorder/api/orders', [MiniOrderController::class, 'ordersData'])->name('api.orders');
    Route::get('/miniorder/users/{userId}', [MiniOrderController::class, 'userDetails'])->name('user.details');
    Route::get('/miniorder/export', [MiniOrderController::class, 'export'])->name('miniOerder.export');
    //rate card
   
    // Courier Management
    //fship courier
    Route::get('couriers', [CourierController::class, 'index'])->name('couriers.index');
    Route::post('couriers', [CourierController::class, 'store'])->name('couriers.store');
    Route::get('couriers/{courier}/edit', [CourierController::class, 'edit'])->name('couriers.edit');
    Route::put('couriers/{courier}', [CourierController::class, 'update'])->name('couriers.update');
    Route::delete('couriers/{courier}', [CourierController::class, 'destroy'])->name('couriers.destroy');
    Route::get('couriers/sync', [CourierController::class, 'syncFromApi'])->name('couriers.sync');


  
    // Rate Card Management
    Route::get('/rate-cards', [RateCardController::class, 'rate'])->name('rate-cards.index');
    Route::get('/rate-cards/create', [RateCardController::class, 'create'])->name('rate-cards.create'); 
    Route::post('/rate-cards/store', [RateCardController::class, 'store'])->name('rate-cards.store');
    Route::get('/rate-cards/{rateCard}/edit', [RateCardController::class, 'edit'])->name('rate-cards.edit');
    Route::put('/rate-cards/{rateCard}/update', [RateCardController::class, 'update'])->name('rate-cards.update');
    Route::delete('/rate-cards/{rateCard}/delete', [RateCardController::class, 'destroy'])->name('rate-cards.destroy');
    Route::post('/rate-cards/bulk', [RateCardController::class, 'bulkAction'])->name('rate-cards.bulk');
    Route::get('/rate-cards/{rateCard}/edit-data', [RateCardController::class, 'editData'])->name('rate-cards.edit-data');
    
    
    
    //Rapidshyp Rate Card Management
    Route::get('/rapidshyp-rates', [RapidshypRateCardController::class, 'b2cIndex'])->name('Rapidshyp.rate-cards.index');
    Route::post('/rapidshyp-rates/store', [RapidshypRateCardController::class, 'b2cStore'])->name('Rapidshyp.rate-cards.store');
    Route::get('/rapidshyp-rates/{id}/edit', [RapidshypRateCardController::class, 'b2cEdit'])->name('Rapidshyp.rate-cards.edit');
    Route::post('/rapidshyp-rates/{id}/update', [RapidshypRateCardController::class, 'b2cUpdate'])->name('Rapidshyp.rate-cards.update');
    Route::delete('/rapidshyp-rates/{id}/delete', [RapidshypRateCardController::class, 'b2cDelete'])->name('Rapidshyp.rate-cards.delete');
    Route::get('/rapidshyp-rates/export', [RapidshypRateCardController::class, 'b2cExport'])->name('Rapidshyp.rate-cards.export');


    //wellet rechage 
    Route::get('/user-debit', [RechageToUserController::class, 'adminRechargeToUser'])->name('user.rerharge.index');
    Route::post('/user-debit/store', [RechageToUserController::class, 'recharge'])->name('user.rerharge.store');
    Route::post('/wallet/{user}/adjust', [RechageToUserController::class, 'adjustBalance'])->name('admin.wallet.adjust');
    Route::get('/wallet/{user}/transactions', [RechageToUserController::class, 'getTransactions'])->name('wallet.transactions');



  

    


    // Wallet Management
    
    Route::post('/customers/{user}/wallet', [AdminCustomerController::class, 'wallet'])->name('');

   //mini codRimintwnce 
    Route::get('/cod-remittance', [AdminCodRemittanceController::class, 'index'])->name('codRemittance.index');
    Route::post('/process-payment', [AdminCodRemittanceController::class, 'processPayment'])->name('processPayment');
    Route::post('/bulk-process', [AdminCodRemittanceController::class, 'bulkProcess'])->name('bulkProcess');
    Route::get('/payment-detail/{identifier}', [AdminCodRemittanceController::class, 'paymentDetail'])->name('paymentDetail');
    Route::get('/statement/{userId}', [AdminCodRemittanceController::class, 'generateStatement'])->name('statement');



   

});

// Seller Routes Group

Route::middleware(['auth', 'role:seller_admin'])->prefix('seller')->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('seller.dashboard.index');
    // })->name('seller.dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('seller.dashboard');


    // seller profile
    Route::get('/profile/sellerprofile', [SellerProfileController::class, 'index'])->name('seller.profile.sellerprofile');
    Route::post('/seller/profile/update-image', [SellerProfileController::class, 'updateImage'])->name('seller.profile.update.image');
    Route::post('/seller/profile/update', [SellerProfileController::class, 'updateProfile'])->name('seller.profile.update');
    Route::post('/seller/profile/change-password', [SellerProfileController::class, 'changePassword'])->name('seller.profile.change.password');

     // company route
    Route::get('/settings', [SettingsController::class, 'index'])->name('seller.settings');
    Route::get('/settings/company/profile', [CompanyController::class, 'index'])->name('seller.settings.profile');
    Route::post('/settings/company/update', [CompanyController::class, 'update'])->name('seller.settings.update');
    Route::get('/settings/company/kyc', [CompanyController::class, 'kycForm'])->name('seller.settings.kyc');
    Route::post('/settings/company/kyc/store', [CompanyController::class, 'submitKyc'])->name('seller.settings.kyc.submit');
    Route::get('/settings/company/privacy-policy', [CompanyController::class, 'privacypolicy'])->name('seller.settings.privacy-policy');
    Route::get('/settings/company/shipping-policy', [CompanyController::class, 'shippingpolicy'])->name('seller.settings.shipping-policy');
    Route::get('/settings/company/return-refund', [CompanyController::class, 'returnrefund'])->name('seller.settings.return-refund');
    Route::get('/settings/company/termandcondition', [CompanyController::class, 'termandcondition'])->name('seller.settings.termandcondition');
    
    //agarement
    Route::get('/agreement', [SellerAgreementController::class, 'show'])->name('agreement.show');
    Route::post('/agreement/accept', [SellerAgreementController::class, 'accept'])->name('agreement.accept');

    //bank route
    Route::get('/bank-details/create', [BankDetailController::class, 'index'])->name('bank-details.create');
    Route::post('/bank-details', [BankDetailController::class, 'store'])->name('bank-details.store');
    Route::get('/bank-details/{id}/edit', [BankDetailController::class, 'edit'])->name('bank-details.edit');
    Route::get('/bank-details/{id}/document', [BankDetailController::class, 'document'])->name('bank-details.document');

    //Add Where house 
    Route::get('/addWhereHouse/create', [SellerPickupAddressController::class, 'index'])->name('add.whereHouse');
    Route::post('/addWhereHouse', [SellerPickupAddressController::class, 'store'])->name('add.whereHouse.store');
    Route::get('/addWhereHouse/{id}/edit', [SellerPickupAddressController::class, 'edit'])->name('add.whereHouse.edit');
    Route::put('/addWhereHouse/{id}', [SellerPickupAddressController::class, 'update'])->name('add.whereHouse.update');
    Route::post('/set-primary-address',[SellerPickupAddressController::class, 'setPrimary'])->name('set.primary.address');
    Route::get('/warehouses/template', [SellerPickupAddressController::class, 'downloadTemplate'])->name('warehouses.template');

    //mini order 
    Route::get('/orders', [B2cOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [B2cOrderController::class, 'createOrederShow'])->name('orders.create');
    Route::get('/check-pincode', [B2cOrderController::class, 'checkPincode'])->name('pincode.check');
    Route::post('/orders', [B2cOrderController::class, 'store'])->name('b2c.order.store');
    Route::get('/orders/{order}/edit-data', [OrderController::class, 'editData'])->name('orders.edit-data');
    Route::post('/orders/{order}/update', [OrderController::class, 'updateFromModal'])->name('orders.update-modal');
    Route::post('/orders/bulk-update-dimensions', [OrderController::class, 'bulkUpdateDimensions'])->name('orders.bulk-update-dimensions');
   
    
    //order routes
    Route::get('/orders/{id}/details', [OrderController::class, 'getDetails'])->name('orders.details');
    Route::get('/orders/get-rates/{id}', [OrderController::class, 'getRates'])->name('orders.get-rates');
    Route::get('/pickup-addresses', [OrderController::class, 'getPickupAddresses'])->name('pickup-addresses.index');
    Route::post('/orders/book', [OrderController::class, 'bookCourier'])->name('orders.book');
    Route::post('/orders/bulk-action', [OrderController::class, 'bulkAction'])->name('orders.bulk-action');
    Route::post('/orders/update-tag', [OrderController::class, 'updateTag'])->name('orders.update-tag');




     //lebal 
    Route::get('/label/create/conditionally', [LabelController::class, 'index'])->name('label.index');
    Route::post('/shipping-label-settings', [LabelController::class, 'update'])->name('shipping-label-settings.update');
    Route::match(['get', 'post'], '/orders/bulk-manifest', [LabelController::class, 'bulkManifest'])->name('orders.bulk-manifest');
    Route::post('/orders/bulk-cancel', [LabelController::class, 'bulkCancel'])->name('orders.bulk-cancel');
    Route::post('/orders/bulk-clone', [LabelController::class, 'bulkClone'])->name('orders.bulk-clone');
    Route::get('/orders/export-excel', [LabelController::class, 'exportExcel'])->name('orders.export-excel');
    Route::get('/orders/bulk-print-label/{ids}', [LabelController::class, 'bulkPrintLabel'])->name('orders.print-label');
    Route::post('/seller/orders/sync-status', [LabelController::class, 'syncShipmentStatus'])->name('orders.sync-status');
    Route::get('/orders/manifest/customize/{pickup_id}', [LabelController::class, 'customizeManifest'])->name('manifest.customize');
    Route::get('/orders/bulk-download-manifest', [LabelController::class, 'bulkCustomizeManifest'])->name('manifest.bulk');
    Route::get('/orders/download-picklist/{ids}', [LabelController::class, 'downloadPicklist'])->name('orders.download-picklist');





    //ndr action route
    Route::get('/ndr-action', [NdrController::class, 'index'])->name('fship.ndr.action');
    Route::post('/take-action', [NdrController::class, 'takeAction'])->name('seller.ndr.action');
    Route::post('/ndr/auto-track', [NdrController::class, 'autoTrackStatus'])->name('ndr.autoTrack');
    Route::get('/ndr/tracking-history', [NdrController::class, 'getTrackingHistory'])->name('ndr.trackingHistory');
    
    // Reversed 
    Route::get('/reverse-order/create', [FshipReverseOrderController::class, 'createReturnFrom'])->name('create');
    Route::get('/reverse-orders', [FshipReverseOrderController::class, 'index'])->name('index');
    Route::get('/reverse-orders/{id}', [FshipReverseOrderController::class, 'show'])->name('show');
    Route::post('/reverse-order/search-awb', [FshipReverseOrderController::class, 'searchOrderByAwb'])->name('search-awb');
    Route::get('/api/pincode-details', [FshipReverseOrderController::class, 'getPincodeDetails'])->name('pincode.details');
    Route::post('/reverse-order', [FshipReverseOrderController::class, 'storeReverseOrder'])->name('store');
    Route::post('/reverse-orders/{id}/cancel', [FshipReverseOrderController::class, 'cancel'])->name('cancel');

    //rate card
    Route::get('/ratecard', [SellerRatecardController::class, 'index'])->name('ratecard.index');



   
    
     

    //trac status live
    Route::get('/status/index',[StatusController::class,'index'])->name('status.index');

   //phone pay route
   Route::post('/phonepe/pay', [PhonePeController::class, 'pay'])->name('phonepe.pay');
   Route::match(['get', 'post'], '/phonepe/callback', [PhonePeController::class, 'callback'])->name('phonepe.callback');
   Route::get('/phonepe/status/{id}', [PhonePeController::class, 'checkStatus'])->name('phonepe.status');

   
    


     

    //  Ticket Route
    Route::get('/ticket/index', [TicketController::class, 'index'])->name('seller.ticket.index');
    Route::get('/ticket/createticket', [TicketController::class, 'showcreateticket'])->name('seller.ticket.createticket');
    Route::post('/ticket/store', [TicketController::class, 'store'])->name('seller.ticket.store');


    // Report 
    Route::get('/report/index', [ReportController::class, 'showReport'])->name('seller.report.index');
    

    //billing
    Route::get('/billing/shipping', [ShippingController::class, 'index'])->name('seller.billing.shipping');
    Route::get('/billing/codRemittance', [ShippingController::class, 'codRemittance'])->name('seller.billing.codRemittance');
    Route::get('/payment-detail/{identifier}', [AdminCodRemittanceController::class, 'paymentDetail'])->name('paymentDetail');
    Route::get('/cod-remittance/export', [ShippingController::class, 'exportCodRemittance'])->name('codRemittance.export');

   // wallat tranjection
    Route::get('/transactions', [WalletTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/seller/transactions-download', [WalletTransactionController::class, 'download'])->name('transactions.download');
    Route::get('/wallet/recharge', [WalletTransactionController::class, 'recharge'])->name('wallet.recharge');
    Route::post('/wallet/create-order', [WalletTransactionController::class, 'createOrder']) ->name('wallet.create.order');
    Route::post('/wallet/verify-payment', [WalletTransactionController::class, 'verifyPayment'])->name('wallet.verify.payment');
    Route::get('/wallet/recharges', [WalletTransactionController::class, 'rechargeHistory'])->name('wallet.recharges');
    
    //  channel 
    Route::get('/channel/showchannel',[ChannelController::class,'showchannel']);
    Route::get('/channel/addchannel', [ChannelController::class, 'index'])->name('channel.addchannel');
    //  Ticket Route
    Route::get('/ticket/index', [TicketController::class, 'index'])->name('seller.ticket.index');
    Route::get('/ticket/createticket', [TicketController::class, 'showcreateticket'])->name('seller.ticket.createticket');
    Route::post('/ticket/store', [TicketController::class, 'store'])->name('seller.ticket.store');


    
    

    // Report 
    Route::get('/report/index', [ReportController::class, 'showReport'])->name('seller.report.index');
    Route::get('/tools/productcatelog',[ProductCatelogController::class,'index'])->name('seller.tools.productcatelog');



    // rapidshyp ware house route


    Route::get('/warehouses', [RapidshypWarehouseController::class, 'index'])->name('warehouses.index');
    Route::get('/api/location/{pincode}', [RapidshypWarehouseController::class, 'getByPincode'])->name('seller.api.location.check');
    Route::post('/warehouses', [RapidshypWarehouseController::class, 'store'])->name('warehouses.store');
    Route::get('/warehouses/{id}/edit', [RapidshypWarehouseController::class, 'edit'])->name('warehouses.edit');
    Route::put('/warehouses/{id}', [RapidshypWarehouseController::class, 'update'])->name('warehouses.update'); 
    Route::post('/warehouses/{id}/set-primary', [RapidshypWarehouseController::class, 'setPrimary'])->name('warehouses.set-primary');
    Route::post('/warehouses/{id}/toggle-status', [RapidshypWarehouseController::class, 'toggleStatus'])->name('warehouses.toggle-status');



// rapidshyp B2c 
   Route::get('/b2c/orders', [RapidshypB2cController::class, 'index'])->name('rapidshyp.b2c.orders.index');
   Route::get('/b2c/orders/create/single', [RapidshypB2cController::class, 'createSingle'])->name('orders.create.single');
   Route::post('/b2c/orders/create/single', [RapidshypB2cController::class, 'store'])->name('rapidshyp.b2c.orders.store');
//shipping route
   Route::get('/shipping/create', [RapidshypB2cShippingController::class, 'index'])->name('shipping.create');
   Route::get('/shipping/{Id}/details', [RapidshypB2cShippingController::class, 'details'])->name('shipping.details');
   Route::post('/orders/check-serviceability', [RapidshypB2cController::class, 'checkServiceability'])->name('rapidshyp.b2c.orders.check-serviceability');
   Route::post('/shipping/{shipmentId}/assign-awb', [RapidshypB2cShippingController::class, 'assignAwb'])->name('shipping.assign-awb');    
   Route::post('/shipping/{shipmentId}/schedule-pickup', [RapidshypB2cShippingController::class, 'schedulePickup'])->name('shipping.schedule-pickup');
   Route::get('/shipping/{shipmentId}/label', [RapidshypB2cShippingController::class, 'generateLabel'])->name('shipping.label');
   Route::get('/shipping/{shipmentId}/invoice', [RapidshypB2cShippingController::class, 'generateInvoice'])->name('shipping.invoice');
   Route::get('/shipping/{shipmentId}/tracking', [RapidshypB2cShippingController::class, 'trackShipment'])->name('shipping.tracking');
   Route::post('/shipping/{shipmentId}/cancel', [RapidshypB2cShippingController::class, 'cancelShipment'])->name('shipping.cancel');
   Route::get('/shipping/{shipmentId}', [RapidshypB2cShippingController::class, 'show'])->name('shipping.show');
   Route::get('/shipping/{shipmentId}/products', [RapidshypB2cShippingController::class, 'getProducts'])->name('shipping.products');

});