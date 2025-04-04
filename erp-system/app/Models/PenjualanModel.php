<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tanggal', 'total_harga', 'pajak_ppn', 'pajak_pph', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'tanggal' => 'required|valid_date',
        'total_harga' => 'required|numeric|greater_than[0]',
        'pajak_ppn' => 'required|numeric|greater_than_equal_to[0]',
        'pajak_pph' => 'required|numeric|greater_than_equal_to[0]',
        'status' => 'required|in_list[lunas,belum lunas]'
    ];
    protected $validationMessages = [
        'tanggal' => [
            'required' => 'Tanggal harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'total_harga' => [
            'required' => 'Total harga harus diisi',
            'numeric' => 'Total harga harus berupa angka',
            'greater_than' => 'Total harga harus lebih dari 0'
        ],
        'pajak_ppn' => [
            'required' => 'Pajak PPN harus diisi',
            'numeric' => 'Pajak PPN harus berupa angka',
            'greater_than_equal_to' => 'Pajak PPN tidak boleh negatif'
        ],
        'pajak_pph' => [
            'required' => 'Pajak PPh harus diisi',
            'numeric' => 'Pajak PPh harus berupa angka',
            'greater_than_equal_to' => 'Pajak PPh tidak boleh negatif'
        ],
        'status' => [
            'required' => 'Status harus diisi',
            'in_list' => 'Status tidak valid'
        ]
    ];
    protected $skipValidation = false;

    /**
     * Get total sales for the current month
     */
    public function getTotalPenjualanBulanIni()
    {
        $bulan = date('m');
        $tahun = date('Y');
        
        return $this->selectSum('total_harga')
                    ->where('MONTH(tanggal)', $bulan)
                    ->where('YEAR(tanggal)', $tahun)
                    ->first()['total_harga'] ?? 0;
    }

    /**
     * Get tax report data for a specific month and year
     */
    public function getLaporanPajak($bulan, $tahun)
    {
        return $this->select('tanggal, pajak_ppn, pajak_pph')
                    ->where('MONTH(tanggal)', $bulan)
                    ->where('YEAR(tanggal)', $tahun)
                    ->findAll();
    }

    /**
     * Get financial report data for a specific month and year
     */
    public function getLaporanKeuangan($bulan, $tahun)
    {
        return $this->select('tanggal, total_harga, pajak_ppn, pajak_pph')
                    ->where('MONTH(tanggal)', $bulan)
                    ->where('YEAR(tanggal)', $tahun)
                    ->findAll();
    }

    /**
     * Get sales data for graph visualization
     */
    public function getGrafikPenjualan()
    {
        $tahun = date('Y');
        
        return $this->select('MONTH(tanggal) as bulan, SUM(total_harga) as total')
                    ->where('YEAR(tanggal)', $tahun)
                    ->groupBy('MONTH(tanggal)')
                    ->orderBy('MONTH(tanggal)', 'ASC')
                    ->findAll();
    }

    public function getPenjualanWithProduk()
    {
        $builder = $this->db->table($this->table);
        $builder->select('penjualan.*, produk.nama_produk as nama_produk, produk.kode as kode_produk');
        $builder->join('produk', 'produk.id = penjualan.produk_id');
        $builder->orderBy('penjualan.tanggal', 'DESC');
        return $builder->get()->getResultArray();
    }
} 