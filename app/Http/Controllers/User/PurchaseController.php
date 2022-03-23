<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\SponsorPackage;
use App\Purchase;
use App\Stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Braintree;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stays = Stay::all()->where('user_id', Auth::user()->id);
        $sponsorPackages = SponsorPackage::all();
        $today = date('Y-m-d h:i:s');

        $purchaseHistory = Purchase
            ::select('purchases.*','stays.title as stay_title','stays.slug as stay_slug','stays.image_path as stay_image_path', 'sponsor_packages.price as tier_price', 'sponsor_packages.name as tier_name')
            ->leftjoin('sponsor_packages','sponsor_packages.id','=','purchases.sponsor_package_id')
            ->leftjoin('stays','stays.id','=','purchases.stay_id')
            ->where('user_id', Auth::user()->id)
            ->get();

        $sponsorActive = Purchase
            ::select('purchases.*','stays.title as stay_title','stays.slug as stay_slug','stays.image_path as stay_image_path')
            ->where('end_date', '>=', $today)
            ->leftjoin('stays','stays.id','=','purchases.stay_id')
            ->where('user_id', Auth::user()->id)
            ->get();

        return response()->json([$stays, $sponsorPackages,$purchaseHistory,$sponsorActive]);
    }

    // public function getSponsoredList($stay_id) {
    //     $resultList = Purchase::where('stay_id',$stay_id)->get();
    //     return response()->json($resultList);
    // }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $payment = $request->payment;
        $data = $request->data;

        $gateway = new Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'bvvnf4975ffrmh75',
            'publicKey' => '5q962vyxyrpyg394',
            'privateKey' => '318d121d94da5170f003674abe10bd1d'
        ]);

        $price =  $data['sponsorPackage_price'] * $data['times'];
        
        $result = $gateway->transaction()->sale([
            'amount' => $price,
            'paymentMethodNonce' => $payment['nonce'],
            'options' => [
                'submitForSettlement' => True
            ]
        ]);
        
        if ($result->success) {
            date_default_timezone_set('Europe/Rome');
            $today = date('Y-m-d h:i:s');
            $hours = $data['sponsorPackage_duration'] * $data['times'];
            $newPurchase = new Purchase();
            $newPurchase->stay_id = $data['stay_id'];
            $newPurchase->sponsor_package_id = $data['sponsorPackage_id'];
            $newPurchase->price = $price;
            $newPurchase->transaction = $result->transaction->id;

            $resultList = Purchase
                ::where('stay_id',$data['stay_id'])
                ->where('end_date', '>=', $today)
                ->get();

            $resultStartDate = '';
            $resultEndDate = '';
            if(count($resultList) > 0) {
                $lastDate = date($resultList[0]->end_date);

                for ($index = 0; $index < count($resultList); $index++) {

                    if(date($resultList[$index]->end_date) > $lastDate) {
                        $lastDate = date($resultList[$index]->end_date);
                    }
                    $resultStartDate =  $lastDate;
                    $datAp = date_add(date_create($lastDate),date_interval_create_from_date_string(strval($hours).'hours'));
                    $resultEndDate = date_format($datAp,'Y-m-d h:i:s');
                }
            }
            else {
                $resultStartDate = $today;
                $datAp = date_add(date_create($today),date_interval_create_from_date_string(strval($hours).'hours'));
                $resultEndDate = date_format($datAp,'Y-m-d h:i:s');
            }
            $newPurchase->start_date = $resultStartDate;
            $newPurchase->end_date = $resultEndDate;
            $newPurchase->save();

            return response()->json($result->transaction->id);
        }   
        else {
            return response()->json($result->errors);
        }
            
    }

    public function getToken() {
        $gateway = new Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'bvvnf4975ffrmh75',
            'publicKey' => '5q962vyxyrpyg394',
            'privateKey' => '318d121d94da5170f003674abe10bd1d'
        ]);
        $token = $gateway->clientToken()->generate();
        return response()->json($token);
    }
}
