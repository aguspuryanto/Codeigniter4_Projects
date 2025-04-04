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
        $tahun = date('Y');
        
        return $this->select('MONTH(tanggal) as bulan, SUM(nominal) as total')
                    ->where('YEAR(tanggal)', $tahun)
                    ->groupBy('MONTH(tanggal)')
                    ->orderBy('MONTH(tanggal)', 'ASC')
                    ->findAll();
    }
} 