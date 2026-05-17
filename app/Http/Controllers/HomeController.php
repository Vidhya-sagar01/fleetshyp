<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        return view('web.home');
    }

      public function about()
    {
        return view('web.about');
    }
      public function services()
    {
        return view('web.services');
    }

    public function pricing()
    {
        return view('web.pricing');
    }
      public function contact()
    {
        return view('web.contact');
    }

    public function termscondition()
    {
        return view('web.termscondition');
    }

    public function privacypolicy()
    {
        return view('web.privacypolicy');
    }

    public function shippingpolicy()
    {
      return view('web.shippingpolicy');  
    }

    public function refundcancellation()
    {
        return view('web.refundcancellation');
    }

    public function trackorder()
    {
        return view('web.trackorder');
    }
    public function partner()
    {
        return view('web.partner');
    }

    public function careers()
    {
        return view('web.careers');
    }


    public function termconditionpdf()
{
    // try {
        // Exact file path define karein
        $filePath = public_path('assets/docs/terms_and_conditions.pdf');

        // 1. Check karein ki file physical location par hai ya nahi
        if (!file_exists($filePath)) {
            // Agar file nahi hai, toh custom error throw karein jo catch block mein jayega
            throw new \Exception("File not found at: " . $filePath);
        }

        // 2. Agar file mil gayi, toh download response return karein
        return response()->download($filePath, 'terms_and_conditions.pdf', [
            'Content-Type' => 'application/pdf',
        ]);

 
}
}