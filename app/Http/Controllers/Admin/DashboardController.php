<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $now = now();
        $year = $year ?? now()->year;
        $allUsers = User::count();
        $totalSubscriptions = Subscription::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalClients = User::where('user_type', 'client')->count();
        // $totalIncome = Transaction::all('status', 'pending')->sum('amount');
        // $totalTransactions = Transaction::where('status', 'completed')->sum('amount');
        // $totalWalletTransactions= Transaction::where('type', 'credit')->sum('amount');
        // $totalExpense = Transaction::where('transaction_type', 'payment')->sum('amount');
        $lastUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        $lastSubscriptions = Subscription::with('pack', 'user')->orderBy('created_at', 'desc')->limit(5)->get();

        $thirtyDaysAgo = $now->copy()->subDays(30);
        $sixtyDaysAgo = $now->copy()->subDays(60);

        // users
        $previousPeriodUsersCount = User::whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->count();
        $currentPeriodUsersCount = User::where('created_at', '>=', $thirtyDaysAgo)->count();
        $usersChange = $currentPeriodUsersCount - $previousPeriodUsersCount;

        // subscriptions
        $previousPeriodSubscriptionsCount = Subscription::whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->count();
        $currentPeriodSubscriptionsCount = Subscription::where('created_at', '>=', $thirtyDaysAgo)->count();

        $subscriptionsChange = $currentPeriodSubscriptionsCount - $previousPeriodSubscriptionsCount;

        // clients
        $previousPeriodClientsCount = User::whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->where('user_type', 'client')->count();
        $currentPeriodClientsCount = User::where('created_at', '>=', $thirtyDaysAgo)->where('user_type', 'client')->count();

        $clientsChange = $currentPeriodClientsCount - $previousPeriodClientsCount;

        $professionalsCount = User::where('user_type', 'professional')->count();

        $previousPeriodProfessionalsCount = User::whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->where('user_type', 'professional')->count();
        $currentPeriodProfessionalsCount = User::where('created_at', '>=', $thirtyDaysAgo)->where('user_type', 'professional')->count();

        $professionalsChange = $currentPeriodProfessionalsCount - $previousPeriodProfessionalsCount;

        // total oders price
        $totalOrdersPrice = Order::where('status', 'completed')->sum('total_price');

        $previousPeriodOrdersPrice = Order::whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->where('status', 'completed')->sum('total_price');
        $currentPeriodOrdersPrice = Order::where('created_at', '>=', $thirtyDaysAgo)->where('status', 'completed')->sum('total_price');

        $ordersPriceChange = $currentPeriodOrdersPrice - $previousPeriodOrdersPrice;


        $totalOrdersPending = Order::where('status', 'pending')->sum('total_price');


        $rawOrdersData = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total_sales')
        )
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy('month');

        // Generate collection of 12 months with 0 as default
        $ordersData = collect();

        for ($i = 1; $i <= 12; $i++) {
            $ordersData->push([
                'month' => $i,
                'total_sales' => $rawOrdersData->has($i) ? $rawOrdersData[$i]->total_sales : 0
            ]);
        }

        $weeklyOrderData = Order::select(
            DB::raw('DATE(created_at) as day'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(total_price) as total_amount')
        )
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        $weeklyOrderDataTotalPrice = $weeklyOrderData->sum('total_amount');


        $topProfessionals = \App\Models\Order::select('professional_id', DB::raw('SUM(total_price) as total_amount'), DB::raw('COUNT(*) as total_orders'))
            ->where('status', 'completed')
            ->groupBy('professional_id')
            ->orderByDesc('total_amount')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $item->professional = \App\Models\User::find($item->professional_id);
                return $item;
            });

            $transactionData = Transaction::select(
                'status',
                DB::raw('COUNT(*) as count')
            )
                ->whereIn('status', ['pending', 'completed', 'failed'])
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
                ->toArray();
    
            $transactionStats = [
                'pending_payment' => $transactionData['pending'] ?? 0,
                'completed_payment' => $transactionData['completed'] ?? 0, 
                'failed_payment' => $transactionData['failed'] ?? 0,
            ];

        return view('admin.dashboard.index', compact(
            'now',
            'year',
            'allUsers',
            'usersChange',
            'totalSubscriptions',
            'totalUsers',
            'totalClients',
            'clientsChange',
            'professionalsCount',
            'professionalsChange',
            'lastUsers',
            'lastSubscriptions',
            'totalOrdersPrice',
            'ordersPriceChange',
            'totalOrdersPending',
            'ordersData',
            'weeklyOrderData',
            'weeklyOrderDataTotalPrice',
            'topProfessionals',
            'transactionStats'
            // 'totalIncome',
            // 'totalTransactions',
            // 'totalExpense',
            // 'totalWalletTransactions',
            // 'lastUsers',
            // 'lastSubscriptions'
        ));
    }

    public function index2()
    {
        return view('dashboard/index2');
    }

    public function index3()
    {
        return view('dashboard/index3');
    }

    public function index4()
    {
        return view('dashboard/index4');
    }

    public function index5()
    {
        return view('dashboard/index5');
    }

    public function index6()
    {
        return view('dashboard/index6');
    }

    public function index7()
    {
        return view('dashboard/index7');
    }

    public function index8()
    {
        return view('dashboard/index8');
    }

    public function index9()
    {
        return view('dashboard/index9');
    }

    public function index10()
    {
        return view('dashboard/index10');
    }
}
