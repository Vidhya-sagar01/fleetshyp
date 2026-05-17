@extends('seller.layouts.app')


@section('content')
<style>
.container-t {
    max-width: 1100px;
    margin: 30px auto;
    padding: 20px;
}
h1.main-title {
    text-align: center;
    color: #000;
    margin-bottom: 30px;
}
.card {
    background: #fff;
    padding: 25px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

h2 {
    /* border-left: 5px solid #0d6efd; */
    padding-left: 10px;
    margin-bottom: 15px;
    font-size: 20px;
}

p {
    line-height: 1.7;
    font-size: 14px;
}

ul, ol {
    padding-left: 20px;
}

.highlight {
    background: #fff3cd;
    padding: 15px;
    border-left: 5px solid #ffc107;
    margin: 20px 0;
    border-radius: 5px;
    font-weight: 500;
}

.footer-t {
    background: #fffefc;
    color: black;
    text-align: center;
    padding: 20px;
    border-radius: 10px;
}
</style>

<main>
    <div class="container-t mt-5">
    <h1 class="main-title mt-5">Refund Or Return and Cancellation policy</h1>
    <div class="card">
<h2>1. Account Closure :</h2>
   <p>You may request to close your account at any time by emailing us at Support@fleetshyp.com. Upon account closure, all your content and data will be permanently deleted from our platform. Please ensure that you intend to close your account, as this action is irreversible.</p>

   
   <h2>2. Refund Process: </h2>
   <p>If you wish to discontinue our services, you may request a refund by emailing us at Support@fleetshyp.com or raising a ticket through our support system. Our team will reach out to discuss your concerns. If you still decide to discontinue, we will review and approve your refund request.  </p> 

    <h1>Important: </h1>
    <p> If there are any in-transit shipments in the forward delivery leg, we will not refund the full amount, as those shipments may become RTO (Return to Origin), and additional charges could apply. Full refunds will only be processed when: </p>
   <ul>
    <li>There are no open shipments on the account.</li>
    <li>There is no probability of weight discrepancies being raised.</li>
   </ul>
   <p>Refunds will be approved within 7 days from the approval date and will be credited to the bank account linked to your account.</p>

      <h1>3. Service Modification or Termination </h1> 
      <p> We reserve the right to modify or terminate the service at any time without notice.</p> 


<h1>4. Fraud Prevention: </h1>
<p>If we suspect fraudulent activity in connection with your account (by investigation, conviction, settlement, or otherwise), we reserve the right to suspend or terminate your account without notice.</p>
<h1>NOTE</h1>
 <p>No refunds are offered, even if a plan is closed mid-month.</p>
<div class="footer-t">
<h1>Contact </h1>
<p>If you have any questions or comments or wish to exercise your rights under applicable legislation, please contact our grievance officer/privacy team by sending an email to Support@fleetshyp.com.</p>
</div>
</div>
</div>
</main>
@endsection