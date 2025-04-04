<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenjualanModel;
use App\Models\PengeluaranModel;
use App\Models\HutangPiutangModel;
use App\Models\ProdukModel;

class Dashboard extends BaseController
{
    protected $penjualanModel;
    protected $pengeluaranModel;
    protected $hutangPiutangModel;
    protected $produkModel;

    public function __construct()
    {
        $this->penjualanModel = new PenjualanModel();
        $this->pengeluaranModel = new PengeluaranModel();
        $this->hutangPiutangModel = new HutangPiutangModel();
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        // Get current month's data
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Get total penjualan for current month
        $total_penjualan = $this->penjualanModel->getTotalPenjualanBulanIni($currentMonth, $currentYear);

        // Get total pengeluaran for current month
        $total_pengeluaran = $this->pengeluaranModel->getTotalPengeluaranBulanIni($currentMonth, $currentYear);

        // Get monthly sales data for chart
        $grafik_penjualan = $this->penjualanModel->getGrafikPenjualan($currentYear);

        // Get monthly expense data for chart
        $grafik_pengeluaran = $this->pengeluaranModel->getGrafikPengeluaran($currentYear);

        // Get products with low stock (less than 10)
        $produk_menipis = $this->produkModel->where('stok <', 10)->findAll();

        // Get overdue debts and receivables
        $hutang_jatuh_tempo = $this->hutangPiutangModel->getHutangJatuhTempo();
        $piutang_jatuh_tempo = $this->hutangPiutangModel->getPiutangJatuhTempo();

        $data = [
            'title' => 'Dashboard',
            'total_penjualan' => $total_penjualan,
            'total_pengeluaran' => $total_pengeluaran,
            'grafik_penjualan' => $grafik_penjualan,
            'grafik_pengeluaran' => $grafik_pengeluaran,
            'produk_menipis' => $produk_menipis,
            'hutang_jatuh_tempo' => $hutang_jatuh_tempo,
            'piutang_jatuh_tempo' => $piutang_jatuh_tempo,
            'hutang_piutang_model' => $this->hutangPiutangModel
        ];

        return view('dashboard/index', $data);
    }
} 