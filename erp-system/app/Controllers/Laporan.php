<?php

namespace App\Controllers;

use App\Models\PenjualanModel;
use App\Models\PengeluaranModel;

class Laporan extends BaseController
{
    protected $penjualanModel;
    protected $pengeluaranModel;

    public function __construct()
    {
        $this->penjualanModel = new PenjualanModel();
        $this->pengeluaranModel = new PengeluaranModel();
    }

    public function index()
    {
        return view('laporan/index', ['title' => 'Laporan']);
    }

    public function pajak()
    {
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $data = [
            'title' => 'Laporan Pajak',
            'pajak' => $this->penjualanModel->getLaporanPajak($bulan, $tahun)
        ];

        return view('laporan/pajak', $data);
    }

    public function keuangan()
    {
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $data = [
            'title' => 'Laporan Keuangan',
            'penjualan' => $this->penjualanModel->getLaporanKeuangan($bulan, $tahun),
            'pengeluaran' => $this->pengeluaranModel->getLaporanKeuangan($bulan, $tahun)
        ];

        return view('laporan/keuangan', $data);
    }

    public function exportPajak()
    {
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $data = $this->penjualanModel->getLaporanPajak($bulan, $tahun);
        
        // Logic for exporting to PDF/Excel will be implemented here
        return $this->response->download('laporan_pajak.pdf', $data);
    }

    public function exportKeuangan()
    {
        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $data = [
            'penjualan' => $this->penjualanModel->getLaporanKeuangan($bulan, $tahun),
            'pengeluaran' => $this->pengeluaranModel->getLaporanKeuangan($bulan, $tahun)
        ];
        
        // Logic for exporting to PDF/Excel will be implemented here
        return $this->response->download('laporan_keuangan.pdf', $data);
    }
} 