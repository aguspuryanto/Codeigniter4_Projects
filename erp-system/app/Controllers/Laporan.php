<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenjualanModel;
use App\Models\PengeluaranModel;
use App\Models\HutangPiutangModel;
use App\Models\ProdukModel;

class Laporan extends BaseController
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
        // Get filter parameters
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-t');
        $jenis = $this->request->getGet('jenis') ?? 'semua';

        // Get summary data
        $total_penjualan = $this->penjualanModel->selectSum('total_harga')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $total_pengeluaran = $this->pengeluaranModel->selectSum('nominal')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->get()
            ->getRow()
            ->nominal ?? 0;

        $total_hutang = $this->hutangPiutangModel->selectSum('nominal')
            ->where('jenis', 'hutang')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->get()
            ->getRow()
            ->nominal ?? 0;

        $total_piutang = $this->hutangPiutangModel->selectSum('nominal')
            ->where('jenis', 'piutang')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->get()
            ->getRow()
            ->nominal ?? 0;

        // Get chart data
        $grafik_penjualan = $this->getGrafikPenjualan($start_date, $end_date);
        $grafik_pengeluaran = $this->getGrafikPengeluaran($start_date, $end_date);
        $grafik_hutang_piutang = $this->getGrafikHutangPiutang($start_date, $end_date);

        // Get transaction details
        $transaksi = [];
        
        if ($jenis == 'semua' || $jenis == 'penjualan') {
            $penjualan = $this->penjualanModel->select('penjualan.*, produk.nama_produk as nama_produk')
                ->join('produk', 'produk.id = penjualan.produk_id')
                ->where('penjualan.tanggal >=', $start_date)
                ->where('penjualan.tanggal <=', $end_date)
                ->findAll();
            
            foreach ($penjualan as $p) {
                $transaksi[] = [
                    'tanggal' => $p['tanggal'],
                    'jenis' => 'Penjualan',
                    'keterangan' => $p['nama_produk'],
                    'jumlah' => $p['total_harga'],
                    'tipe' => 'masuk'
                ];
            }
        }
        
        if ($jenis == 'semua' || $jenis == 'pengeluaran') {
            $pengeluaran = $this->pengeluaranModel->where('tanggal >=', $start_date)
                ->where('tanggal <=', $end_date)
                ->findAll();
            
            foreach ($pengeluaran as $p) {
                $transaksi[] = [
                    'tanggal' => $p['tanggal'],
                    'jenis' => 'Pengeluaran',
                    'keterangan' => $p['keterangan'],
                    'jumlah' => $p['nominal'],
                    'tipe' => 'keluar'
                ];
            }
        }
        
        if ($jenis == 'semua' || $jenis == 'hutang') {
            $hutang = $this->hutangPiutangModel->where('jenis', 'hutang')
                ->where('tanggal >=', $start_date)
                ->where('tanggal <=', $end_date)
                ->findAll();
            
            foreach ($hutang as $h) {
                $transaksi[] = [
                    'tanggal' => $h['tanggal'],
                    'jenis' => 'Hutang',
                    'keterangan' => $h['keterangan'],
                    'jumlah' => $h['nominal'],
                    'tipe' => 'keluar'
                ];
            }
        }
        
        if ($jenis == 'semua' || $jenis == 'piutang') {
            $piutang = $this->hutangPiutangModel->where('jenis', 'piutang')
                ->where('tanggal >=', $start_date)
                ->where('tanggal <=', $end_date)
                ->findAll();
            
            foreach ($piutang as $p) {
                $transaksi[] = [
                    'tanggal' => $p['tanggal'],
                    'jenis' => 'Piutang',
                    'keterangan' => $p['keterangan'],
                    'jumlah' => $p['nominal'],
                    'tipe' => 'masuk'
                ];
            }
        }

        // Sort transactions by date
        usort($transaksi, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        $data = [
            'title' => 'Laporan Keuangan',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'jenis' => $jenis,
            'total_penjualan' => $total_penjualan,
            'total_pengeluaran' => $total_pengeluaran,
            'total_hutang' => $total_hutang,
            'total_piutang' => $total_piutang,
            'grafik_penjualan' => $grafik_penjualan,
            'grafik_pengeluaran' => $grafik_pengeluaran,
            'grafik_hutang_piutang' => $grafik_hutang_piutang,
            'transaksi' => $transaksi
        ];

        return view('laporan/index', $data);
    }

    private function getGrafikPenjualan($start_date, $end_date)
    {
        $data = [];
        $current = strtotime($start_date);
        $end = strtotime($end_date);

        while ($current <= $end) {
            $date = date('Y-m-d', $current);
            $total = $this->penjualanModel->selectSum('total_harga')
                ->where('tanggal', $date)
                ->get()
                ->getRow()
                ->total_harga ?? 0;

            $data['labels'][] = date('d M', $current);
            $data['data'][] = $total;

            $current = strtotime('+1 day', $current);
        }

        return $data;
    }

    private function getGrafikPengeluaran($start_date, $end_date)
    {
        $data = [];
        $current = strtotime($start_date);
        $end = strtotime($end_date);

        while ($current <= $end) {
            $date = date('Y-m-d', $current);
            $total = $this->pengeluaranModel->selectSum('nominal')
                ->where('tanggal', $date)
                ->get()
                ->getRow()
                ->nominal ?? 0;

            $data['labels'][] = date('d M', $current);
            $data['data'][] = $total;

            $current = strtotime('+1 day', $current);
        }

        return $data;
    }

    private function getGrafikHutangPiutang($start_date, $end_date)
    {
        $data = [];
        $current = strtotime($start_date);
        $end = strtotime($end_date);

        while ($current <= $end) {
            $date = date('Y-m-d', $current);
            
            $hutang = $this->hutangPiutangModel->selectSum('nominal')
                ->where('jenis', 'hutang')
                ->where('tanggal', $date)
                ->get()
                ->getRow()
                ->nominal ?? 0;

            $piutang = $this->hutangPiutangModel->selectSum('nominal')
                ->where('jenis', 'piutang')
                ->where('tanggal', $date)
                ->get()
                ->getRow()
                ->nominal ?? 0;

            $data['labels'][] = date('d M', $current);
            $data['hutang'][] = $hutang;
            $data['piutang'][] = $piutang;

            $current = strtotime('+1 day', $current);
        }

        return $data;
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

    public function print()
    {
        // Get filter parameters
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end_date = $this->request->getGet('end_date') ?? date('Y-m-t');
        $jenis = $this->request->getGet('jenis') ?? 'semua';

        // Get summary data
        $total_penjualan = $this->penjualanModel->selectSum('total_harga')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        $total_pengeluaran = $this->pengeluaranModel->selectSum('nominal')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->get()
            ->getRow()
            ->nominal ?? 0;

        $total_hutang = $this->hutangPiutangModel->selectSum('nominal')
            ->where('jenis', 'hutang')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->get()
            ->getRow()
            ->nominal ?? 0;

        $total_piutang = $this->hutangPiutangModel->selectSum('nominal')
            ->where('jenis', 'piutang')
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->get()
            ->getRow()
            ->nominal ?? 0;

        // Get transaction details
        $transaksi = [];
        
        if ($jenis == 'semua' || $jenis == 'penjualan') {
            $penjualan = $this->penjualanModel->select('penjualan.*, produk.nama_produk as nama_produk')
                ->join('produk', 'produk.id = penjualan.produk_id')
                ->where('penjualan.tanggal >=', $start_date)
                ->where('penjualan.tanggal <=', $end_date)
                ->findAll();
            
            foreach ($penjualan as $p) {
                $transaksi[] = [
                    'tanggal' => $p['tanggal'],
                    'jenis' => 'Penjualan',
                    'keterangan' => $p['nama_produk'],
                    'jumlah' => $p['total_harga'],
                    'tipe' => 'masuk'
                ];
            }
        }
        
        if ($jenis == 'semua' || $jenis == 'pengeluaran') {
            $pengeluaran = $this->pengeluaranModel->where('tanggal >=', $start_date)
                ->where('tanggal <=', $end_date)
                ->findAll();
            
            foreach ($pengeluaran as $p) {
                $transaksi[] = [
                    'tanggal' => $p['tanggal'],
                    'jenis' => 'Pengeluaran',
                    'keterangan' => $p['keterangan'],
                    'jumlah' => $p['nominal'],
                    'tipe' => 'keluar'
                ];
            }
        }
        
        if ($jenis == 'semua' || $jenis == 'hutang') {
            $hutang = $this->hutangPiutangModel->where('jenis', 'hutang')
                ->where('tanggal >=', $start_date)
                ->where('tanggal <=', $end_date)
                ->findAll();
            
            foreach ($hutang as $h) {
                $transaksi[] = [
                    'tanggal' => $h['tanggal'],
                    'jenis' => 'Hutang',
                    'keterangan' => $h['keterangan'],
                    'jumlah' => $h['nominal'],
                    'tipe' => 'keluar'
                ];
            }
        }
        
        if ($jenis == 'semua' || $jenis == 'piutang') {
            $piutang = $this->hutangPiutangModel->where('jenis', 'piutang')
                ->where('tanggal >=', $start_date)
                ->where('tanggal <=', $end_date)
                ->findAll();
            
            foreach ($piutang as $p) {
                $transaksi[] = [
                    'tanggal' => $p['tanggal'],
                    'jenis' => 'Piutang',
                    'keterangan' => $p['keterangan'],
                    'jumlah' => $p['nominal'],
                    'tipe' => 'masuk'
                ];
            }
        }

        // Sort transactions by date
        usort($transaksi, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        $data = [
            'title' => 'Laporan Keuangan',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'jenis' => $jenis,
            'total_penjualan' => $total_penjualan,
            'total_pengeluaran' => $total_pengeluaran,
            'total_hutang' => $total_hutang,
            'total_piutang' => $total_piutang,
            'transaksi' => $transaksi
        ];

        return view('laporan/print', $data);
    }
} 