<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\KycDetail ;
use Exception;

class CompanyController extends Controller
{
  

    public function index()
    {
       
        $profile = CompanyProfile::where('seller_id', Auth::id())->first();
        return view('seller.settings.profile', compact('profile'));
    }

    public function update(Request $request)
{
  
    $validator = Validator::make($request->all(), [
        'company_name' => 'required|string|max:255',
        'brand_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'website' => 'nullable|url',
        'customer_care_email' => 'nullable|email',
        'customer_care_mobile' => 'nullable|digits_between:10,15',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {

        $profile = CompanyProfile::firstOrNew([
            'seller_id' => Auth::id()
        ]);

        $profile->company_name = $request->company_name;
        $profile->brand_name = $request->brand_name;
        $profile->email = $request->email;
        $profile->website = $request->website;
        $profile->customer_care_email = $request->customer_care_email;
        $profile->customer_care_mobile = $request->customer_care_mobile;

        $profile->has_gst = $request->has('has_gst');
        $profile->enable_state_gst = $request->has('enable_state_gst');

       
        if ($request->hasFile('logo')) {

            if ($profile->logo && Storage::disk('public')->exists($profile->logo)) {
                Storage::disk('public')->delete($profile->logo);
            }

            $file = $request->file('logo');

            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

            $path = $file->storeAs('companies/logos', $filename, 'public');

            $profile->logo = $path;
        }

        $profile->save();

        return redirect()->back()
            ->with('success', 'Company profile saved successfully');

    } catch (Exception $e) {

        return redirect()->back()
            ->with('error', 'Something went wrong: '.$e->getMessage())
            ->withInput();
    
            }    
    } 


    public function kycForm(Request $request)
   {
    $kyc = KycDetail::where('user_id', auth()->id())->first();
    
      if ($request->reapply == 1) {
        $kyc = null;
    }
    return view('seller.settings.kyc', compact('kyc'));
   }

    public function kycStore(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'verification_method' => 'required|string',
            'business_type' => 'required|string',
            'pan_number' => 'nullable|string|max:10',
            'aadhaar_number' => 'nullable|string|max:12',
            'user_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pan_card_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'aadhaar_card_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kyc = KycDetail::firstOrNew([
            'user_id' => auth()->id()
        ]);
        $kyc->fill($request->all());
        $kyc->save();

        return redirect()->back()
            ->with('success', 'KYC details submitted successfully');
    }


    public function submitKyc(Request $request)
{
    try {
          $validator = Validator::make($request->all(), [
            'verification_method'   => 'required|string|max:50',
            'business_type'         => 'required|string|max:50',

            'user_photo'            => 'required|image|mimes:jpg,jpeg,png|max:2048',

            'pan_number'            => 'nullable|string|max:10',
            'pan_card_image'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'aadhaar_number'        => 'required|string|max:14',
            'aadhaar_card_image'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
         //dd($request->all());
        DB::beginTransaction();

        $data = [];

        $data['user_id'] = Auth::id();
        $data['verification_method'] = $request->verification_method;
        $data['business_type'] = $request->business_type;
        $data['pan_number'] = $request->pan_number;
        $data['aadhaar_number'] = $request->aadhaar_number;
        $data['status'] = 'PENDING';

        
        if ($request->hasFile('user_photo')) {

            $file = $request->file('user_photo');

            $path = $file->store('kyc/user_photos', 'public');

            $data['user_photo'] = $path;
        }

       
        if ($request->hasFile('pan_card_image')) {

            $file = $request->file('pan_card_image');

            $path = $file->store('kyc/pan_cards', 'public');

            $data['pan_card_image'] = $path;
        }

       
        if ($request->hasFile('aadhaar_card_image')) {

            $file = $request->file('aadhaar_card_image');

            $path = $file->store('kyc/aadhaar_cards', 'public');

            $data['aadhaar_card_image'] = $path;
        }

      // dd($data);
        KycDetail::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        DB::commit();

        return redirect()->back()->with('success', 'KYC Submitted Successfully');

    } catch (\Exception $e) {
        //dd($e->getMessage());
        DB::rollBack();

        return redirect()->back()->with('error', 'Something went wrong');
    }
 }
public function privacypolicy()
    {
        return view('seller.settings.privacy-policy');
    }

    public function shippingpolicy()
    {
        return view('seller.settings.shipping-policy');
    }

    public function returnrefund()
    {
        return view('seller.settings.return-refund');
    }

    public function termandcondition()
    {
        return view('seller.settings.termandcondition');
    }
}   