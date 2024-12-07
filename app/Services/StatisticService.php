<?php

namespace App\Services;

use App\Models\Import;
use App\Models\ImportDetail;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Traits\APIResponse;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticService
{
    use APIResponse;
    public function getOverview(Request $request)
    {
        $year = $request->year ?? Carbon::now();
        $user = User::whereYear('user_created_at', $year)->count();
        $order = Order::whereYear('order_created_at', $year)->count();
        $product = Product::whereYear('product_created_at', $year)->count();
        //Doanh thu theo từng năm
        $yearRevenue = Order::where('order_status', 'delivered')->whereYear('order_created_at', $year)
            ->selectRaw('YEAR(order_created_at) as year, sum(order_total_amount) as total')
            ->groupBy('year')
            ->get();
        $supplier = Supplier::whereYear('supplier_created_at', $year)->count();
        $yearImport = Import::whereYear('import_created_at', $year)->selectRaw('YEAR(import_created_at) as year, sum(import_total_amount) as total')
            ->groupBy('year')->get();
        $data = [
            'user' => $user,
            'order' => $order,
            'product' => $product,
            'yearRevenue' => $yearRevenue,
            'supplier' => $supplier,
            'yearImport' => $yearImport
        ];
        return $this->responseSuccessWithData($data, "Thống kê tổng quan", 200);
    }
    public function getRevenue(Request $request)
    {
        try {

            if ($request->start_date) {
                $startDate = Carbon::parse($request->start_date);
            } else {
                $startDate = Order::orderBy('order_created_at', 'asc')->value('order_created_at');
            }

            if ($request->end_date) {
                $endDate = Carbon::parse($request->end_date);
            } else {
                $endDate = Carbon::now();
            }
            //Doanh thu theo từng ngày
            $dailyRevenue = Order::where('order_status', 'delivered')
                ->whereDate('order_created_at', '>=', $startDate)
                ->whereDate('order_created_at', '<=', $endDate)
                ->selectRaw('DATE(order_created_at) as date, sum(order_total_amount) as revenue_total')
                ->groupBy('date')
                ->get();
            $result = $dailyRevenue->pluck('revenue_total', 'date')->toArray();
            $dates = [];
            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $dates[] = $date->toDateString();
            }
            foreach ($dates as $date) {
                if (array_key_exists($date, $result)) {
                    $result[$date] = $result[$date];
                } else {
                    $result[$date] = 0;
                }
            }
            ksort($result);
            $data=$result;
            return $this->responseSuccessWithData($data, 'Lấy doanh thu thành công!', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function getOrders(Request $request)
    {
        try {
            //Tổng số đơn hàng
            $totalOrders = Order::count();
            //Số đơn hàng theo từng trạng thái
            $ordersByStatus = Order::selectRaw('order_status, count(order_id) as total')
                ->groupBy('order_status')
                ->get();
            $orderStatusPending = Order::where("order_status", "pending")->count();
            $orderStatusConfirmed = Order::where("order_status", "confirmed")->count();
            $orderStatusShipped = Order::where("order_status", "shipped")->count();
            $orderStatusDelivered = Order::where("order_status", "delivered")->count();
            $orderStatusCancelled = Order::where("order_status", "cancelled")->count();
            $data = [
                'total_orders' => $totalOrders,
                'order_pending' => $orderStatusPending,
                'order_confirmed' => $orderStatusConfirmed,
                'order_shipped' => $orderStatusShipped,
                'order_delivered' => $orderStatusDelivered,
                'order_cancelled' => $orderStatusCancelled
            ];
            return $this->responseSuccessWithData($data, 'Lấy số đơn hàng thành công!', 200);
        } catch (Throwable $e) {
            return $this->responseError($e->getMessage());
        }
    }
    public function getProfitRevenue(Request $request){
        $type=$request->type ?? 'year';
        $year = $request->year ?? Carbon::now();
        $month = $request->month ?? Carbon::now();
        $day = $request->day ?? Carbon::now();
        $startDate = $request->start_date ?? Carbon::now();
        $endDate = $request->end_date ?? Carbon::now();
        if($type == 'year'){
            $data=$this->getProfitRevenueYear($year);
        }
        else if($type == 'range'){
            $data=$this->getProfitRevenueRange($startDate,$endDate);
        }
        return $this->responseSuccessWithData($data, 'Lấy doanh thu và lợi nhuận thành công!', 200);
    }
    public function getProfitRevenueRange($startDate,$endDate){
        $orders=OrderRepository::getAll((object)['order_status' => 'delivered','from_date'=>$startDate,'to_date'=>$endDate])
                ->get();
        $revenueDaily=[];
        $profitDaily=[];
        $startDate = Carbon::parse($startDate); // Đảm bảo startDate là một đối tượng Carbon
        $endDate = Carbon::parse($endDate); // Đảm bảo endDate là một đối tượng Carbon
        // Tạo danh sách các ngày giữa startDate và endDate
        $dates = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dates[] = $date->toDateString();
        }
        // Khởi tạo các ngày trong mảng revenueDaily và profitDaily
        foreach ($dates as $date) {
            if (!array_key_exists($date, $revenueDaily)) {
                $revenueDaily[$date] = 0;
                $profitDaily[$date] = 0;
            }
        }
        foreach($orders as $order){
            $orderDetails=OrderRepository::getDetailOrder($order->order_id);
            foreach($orderDetails as $orderDetail){
                $importDetail=ImportDetail::where('product_id',$orderDetail->product_id)
                                ->where('import_detail_id',$orderDetail->import_detail_id)
                                ->first();
                $importPrice=$importDetail->import_price;
                $profit=$orderDetail->order_total_price-$importPrice*$orderDetail->order_quantity;
                $date = Carbon::parse($order->order_created_at)->toDateString(); // Lấy ngày (YYYY-MM-DD)
                $orderDate = Carbon::parse($order->order_created_at)->toDateString(); // Ngày tạo đơn hàng

                // Nếu ngày của đơn hàng nằm trong khoảng ngày
                if (in_array($orderDate, $dates)) {
                    $revenueDaily[$orderDate] += $orderDetail->order_total_price;
                    $profitDaily[$orderDate] += $profit;
                }
                
                
            }
        }
        ksort($revenueDaily);
        ksort($profitDaily);
        $data=[
            'revenue_daily'=>$revenueDaily,
            'profit_daily'=>$profitDaily
        ];
        return $data;
    }
    public function getProfitRevenueYear($year){
        $monthlyRevenue =array_fill(1, 12, 0);
        $monthlyProfit =array_fill(1, 12, 0);
        $orders = OrderRepository::getAll((object)['order_status' => 'delivered'])->whereYear('order_created_at', $year)->get();
        foreach($orders as $order){
            $orderDetails = OrderRepository::getDetailOrder($order->order_id);
            foreach($orderDetails as $orderDetail){
                $importDetail = ImportDetail::where('product_id', $orderDetail->product_id)
                                ->where('import_detail_id', $orderDetail->import_detail_id)
                                ->first();
                $importPrice = $importDetail->import_price;
                $profit = $orderDetail->order_total_price - $importPrice * $orderDetail->order_quantity;
                $date = Carbon::parse($order->order_created_at);
                $month = $date->month;
                $monthlyRevenue[$month] += $orderDetail->order_total_price;
                $monthlyProfit[$month] += $profit;
            }
        }
        $data = [
            'monthly_revenue' => $monthlyRevenue,
            'monthly_profit' => $monthlyProfit
        ];
        return $data;
    }
    public function getTopProduct(Request $reqeust){
        $year = $reqeust->year ?? Carbon::now();
        $topProducts = Order::where('order_status', 'delivered')
        ->whereYear('order_created_at', $year)
        ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
        ->join('products', 'order_details.product_id', '=', 'products.product_id')
        ->selectRaw('order_details.product_id, products.product_name, products.product_images, SUM(order_details.order_quantity) as total_quantity')
        ->groupBy('order_details.product_id', 'products.product_name', 'products.product_images')
        ->orderBy('total_quantity', 'desc')
        ->limit(5)
        ->get();

        $data = $topProducts;
        return $this->responseSuccessWithData($data, 'Lấy sản phẩm bán chạy nhất thành công!', 200);
    }
}
