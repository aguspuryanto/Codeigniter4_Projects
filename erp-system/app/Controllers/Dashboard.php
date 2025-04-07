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
        // Get current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Get total sales for current month
        $total_penjualan = $this->penjualanModel->selectSum('total_harga')
            ->where('MONTH(tanggal)', $currentMonth)
            ->where('YEAR(tanggal)', $currentYear)
            ->get()
            ->getRow()
            ->total_harga ?? 0;

        // Get total expenses for current month
        $total_pengeluaran = $this->pengeluaranModel->selectSum('nominal')
            ->where('MONTH(tanggal)', $currentMonth)
            ->where('YEAR(tanggal)', $currentYear)
            ->get()
            ->getRow()
            ->nominal ?? 0;

        // Get total debt
        $total_hutang = $this->hutangPiutangModel->selectSum('nominal')
            ->where('jenis', 'hutang')
            ->get()
            ->getRow()
            ->nominal ?? 0;

        // Get total receivables
        $total_piutang = $this->hutangPiutangModel->selectSum('nominal')
            ->where('jenis', 'piutang')
            ->get()
            ->getRow()
            ->nominal ?? 0;

        // Get sales data for chart (last 6 months)
        $grafik_penjualan = [
            'labels' => [],
            'data' => []
        ];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-$i months"));
            $month = date('M', strtotime($date));
            $year = date('Y', strtotime($date));
            
            $total = $this->penjualanModel->selectSum('total_harga')
                ->where('MONTH(tanggal)', date('m', strtotime($date)))
                ->where('YEAR(tanggal)', $year)
                ->get()
                ->getRow()
                ->total_harga ?? 0;
            
            $grafik_penjualan['labels'][] = $month;
            $grafik_penjualan['data'][] = $total;
        }

        // Get expenses data for chart (last 6 months)
        $grafik_pengeluaran = [
            'labels' => [],
            'data' => []
        ];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-$i months"));
            $month = date('M', strtotime($date));
            $year = date('Y', strtotime($date));
            
            $total = $this->pengeluaranModel->selectSum('nominal')
                ->where('MONTH(tanggal)', date('m', strtotime($date)))
                ->where('YEAR(tanggal)', $year)
                ->get()
                ->getRow()
                ->nominal ?? 0;
            
            $grafik_pengeluaran['labels'][] = $month;
            $grafik_pengeluaran['data'][] = $total;
        }

        // Get best selling products
        $produk_terlaris = $this->penjualanModel->select('produk.nama_produk, SUM(penjualan.total_harga) as total')
            ->join('produk', 'produk.id = penjualan.produk_id')
            ->groupBy('produk.id')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Add colors for best selling products chart
        $colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];
        foreach ($produk_terlaris as $key => $produk) {
            $produk_terlaris[$key]['color'] = $colors[$key] ?? '#858796';
        }

        // Get debt status
        $status_hutang = [
            [
                'nama' => 'Lunas',
                'persentase' => $this->hutangPiutangModel->where('jenis', 'hutang')->where('status', 'sudah bayar')->countAllResults() * 100 / max(1, $this->hutangPiutangModel->where('jenis', 'hutang')->countAllResults()),
                'class' => 'bg-success'
            ],
            [
                'nama' => 'Belum Lunas',
                'persentase' => $this->hutangPiutangModel->where('jenis', 'hutang')->where('status', 'belum bayar')->countAllResults() * 100 / max(1, $this->hutangPiutangModel->where('jenis', 'hutang')->countAllResults()),
                'class' => 'bg-warning'
            ]
        ];

        // Get recent activities
        $aktivitas_terakhir = [];
        
        // Get recent sales
        $penjualan_terakhir = $this->penjualanModel->select('tanggal, total_harga as jumlah')
            ->orderBy('tanggal', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        foreach ($penjualan_terakhir as $penjualan) {
            $aktivitas_terakhir[] = [
                'tanggal' => date('d/m/Y', strtotime($penjualan['tanggal'])),
                'aktivitas' => 'Penjualan',
                'jumlah' => $penjualan['jumlah']
            ];
        }
        
        // Get recent expenses
        $pengeluaran_terakhir = $this->pengeluaranModel->select('tanggal, nominal')
            ->orderBy('tanggal', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        foreach ($pengeluaran_terakhir as $pengeluaran) {
            $aktivitas_terakhir[] = [
                'tanggal' => date('d/m/Y', strtotime($pengeluaran['tanggal'])),
                'aktivitas' => 'Pengeluaran',
                'jumlah' => $pengeluaran['nominal']
            ];
        }
        
        // Sort activities by date
        usort($aktivitas_terakhir, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });
        
        // Limit to 5 most recent activities
        $aktivitas_terakhir = array_slice($aktivitas_terakhir, 0, 5);

        $data = [
            'title' => 'Dashboard',
            'total_penjualan' => $total_penjualan,
            'total_pengeluaran' => $total_pengeluaran,
            'total_hutang' => $total_hutang,
            'total_piutang' => $total_piutang,
            'grafik_penjualan' => $grafik_penjualan,
            'grafik_pengeluaran' => $grafik_pengeluaran,
            'produk_terlaris' => $produk_terlaris,
            'status_hutang' => $status_hutang,
            'aktivitas_terakhir' => $aktivitas_terakhir
        ];

        return view('dashboard/index', $data);
    }
} 