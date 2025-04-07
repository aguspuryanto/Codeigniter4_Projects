<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranModel extends Model
{
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['tanggal', 'nominal', 'keterangan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'tanggal' => 'required|valid_date',
        'nominal' => 'required|numeric|greater_than[0]',
        'keterangan' => 'required|min_length[3]'
    ];
    protected $validationMessages = [
        'tanggal' => [
            'required' => 'Tanggal harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'nominal' => [
            'required' => 'Nominal harus diisi',
            'numeric' => 'Nominal harus berupa angka',
            'greater_than' => 'Nominal harus lebih dari 0'
        ],
        'keterangan' => [
            'required' => 'Keterangan harus diisi',
            'min_length' => 'Keterangan minimal 3 karakter'
        ]
    ];
    protected $skipValidation = false;

    /**
     * Get total expenses for the current month
     */
    public function getTotalPengeluaranBulanIni()
    {
        $bulan = date('m');
        $tahun = date('Y');
        
        return $this->selectSum('nominal')
                    ->where('MONTH(tanggal)', $bulan)
                    ->where('YEAR(tanggal)', $tahun)
                    ->first()['nominal'] ?? 0;
    }

    /**
     * Get financial report data for a specific month and year
     */
    public function getLaporanKeuangan($bulan, $tahun)
    {
        return $this->select('tanggal, nominal, keterangan')
                    ->where('MONTH(tanggal)', $bulan)
                    ->where('YEAR(tanggal)', $tahun)
                    ->findAll();
    }

    /**
     * Get expenses data for graph visualization
     */
    public function getGrafikPengeluaran()
    {
        $result = $this->select("DATE_FORMAT(tanggal, '%M %Y') as bulan, SUM(nominal) as total")
            ->groupBy("DATE_FORMAT(tanggal, '%Y-%m')")
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        // Format the data for the chart
        $formattedData = [];
        foreach ($result as $row) {
            if (is_array($row)) {
                $formattedData[] = [
                    'bulan' => $row['bulan'],
                    'total' => (float)$row['total']
                ];
            }
        }

        return $formattedData;
    }

    public function getAllPengeluaran()
    {
        $query = $this->select('*')
            ->orderBy('tanggal', 'DESC')
            ->findAll();
        // dd($query);
        // Ambil query terakhir dalam bentuk SQL
        // $lastQuery = $this->db->getLastQuery();
        // $sql = $lastQuery->getQuery(); // Mengambil string SQL

        // Tampilkan query SQL
        // echo $sql; die();
        return $query;
    }

    public function getTop5Pengeluaran()
    {
        return $this->select('pengeluaran.*, DATE_FORMAT(tanggal, "%d %M %Y") as tanggal_format')
            ->orderBy('nominal', 'DESC')
            ->limit(5)
            ->findAll();
    }

    public function getPengeluaranByKategori()
    {
        return $this->select('kategori, subkategori, SUM(nominal) as total')
            ->groupBy('kategori, subkategori')
            ->orderBy('total', 'DESC')
            ->findAll();
    }

    public function getFormattedPengeluaran()
    {
        return $this->select('pengeluaran.*, 
                            DATE_FORMAT(tanggal, "%d %M %Y") as tanggal_format,
                            kategori,
                            subkategori,
                            nominal as jumlah,
                            keterangan')
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    }
} 