<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ProductionModel;
use App\Model\DeliveryModel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $periods = CarbonPeriod::create(Carbon::now()->subDays(30), Carbon::now());

        $production_data = ProductionModel::selectRaw("
                SUM(production_qty) as production_qty, 
                CONVERT(varchar, production_time, 101) as production_time
            ")
            ->where('production_time', '>=', Carbon::now()->subDays(30))
            ->groupBy(DB::raw("CONVERT(varchar, production_time, 101)"))
            ->get();

        $delivery_data = DeliveryModel::selectRaw("
                SUM(deliverydet_qty) as delivery_qty, 
                CONVERT(varchar, delivery_time, 101) as delivery_time
            ")
            ->join('deliverydet', 'deliverydet.deliverydet_delivery_id', '=', 'delivery.delivery_id')
            ->where('delivery_time', '>=', Carbon::now()->subDays(30))
            ->groupBy(DB::raw("CONVERT(varchar, delivery_time, 101)"))
            ->get();

        $final = [];
        foreach ($periods as $period) {
            $date = $period->format('d-m-Y');
            $production_qty = 0;
            foreach ($production_data as $production) {
                if($production->production_time == $date){
                    $production_qty = $production->production_qty;
                }
            }

            $delivery_qty = 0;
            foreach ($delivery_data as $delivery) {
                if($delivery->delivery_time == $date){
                    $delivery_qty = $delivery->delivery_qty;
                }
            }
            $final[] = [$date, $production_qty, $delivery_qty];
        }

        return view('home')->with([
            'data'=>$final,
        ]);
    }
}
