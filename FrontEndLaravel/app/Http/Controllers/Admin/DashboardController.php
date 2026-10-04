<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSampah;
use App\Models\MarketplaceOrder;
use App\Models\MarketplaceProduct;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = User::where('role', 'user')->count();

        $totalBankSampah = BankSampah::count();

        $totalProducts = MarketplaceProduct::count();

        $totalOrders = MarketplaceOrder::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBankSampah',
            'totalProducts',
            'totalOrders'
        ));
    }
}