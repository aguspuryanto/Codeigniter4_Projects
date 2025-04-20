<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\TransactionModel;

class DashboardController extends BaseController
{
    protected $productModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        if (!session('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Dashboard | Kasir CI4',
            'total_products' => $this->productModel->countAll(),
            'total_transactions' => $this->transactionModel->countAll(),
            'recent_transactions' => $this->transactionModel->orderBy('created_at', 'DESC')->limit(5)->findAll()
        ];

        return view('dashboard/index', $data);
    }
}
