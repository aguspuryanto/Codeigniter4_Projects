<?php

namespace App\Models;

use CodeIgniter\Model;

class HutangPiutangModel extends Model
{
    protected $table = 'hutang_piutang';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['jenis', 'nominal', 'tanggal', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'jenis' => 'required|in_list[hutang,piutang]',
        'nominal' => 'required|numeric|greater_than[0]',
        'tanggal' => 'required|valid_date',
        'status' => 'required|in_list[belum bayar,sudah bayar]'
    ];
    protected $validationMessages = [
        'jenis' => [
            'required' => 'Jenis harus diisi',
            'in_list' => 'Jenis tidak valid'
        ],
        'nominal' => [
            'required' => 'Nominal harus diisi',
            'numeric' => 'Nominal harus berupa angka',
            'greater_than' => 'Nominal harus lebih dari 0'
        ],
        'tanggal' => [
            'required' => 'Tanggal harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'status' => [
            'required' => 'Status harus diisi',
            'in_list' => 'Status tidak valid'
        ]
    ];
    protected $skipValidation = false;

    /**
     * Get total receivables
     */
    public function getTotalPiutang()
    {
        return $this->selectSum('nominal')
                    ->where('jenis', 'piutang')
                    ->where('status', 'belum bayar')
                    ->first()['nominal'] ?? 0;
    }

    /**
     * Get total payables
     */
    public function getTotalHutang()
    {
        return $this->selectSum('nominal')
                    ->where('jenis', 'hutang')
                    ->where('status', 'belum bayar')
                    ->first()['nominal'] ?? 0;
    }

    /**
     * Get overdue receivables
     */
    public function getPiutangJatuhTempo()
    {
        return $this->where('jenis', 'piutang')
                    ->where('status', 'belum bayar')
                    ->where('tanggal <', date('Y-m-d'))
                    ->findAll();
    }

    /**
     * Get overdue payables
     */
    public function getHutangJatuhTempo()
    {
        return $this->where('jenis', 'hutang')
                    ->where('status', 'belum bayar')
                    ->where('tanggal <', date('Y-m-d'))
                    ->findAll();
    }

    /**
     * Mark as paid
     */
    public function markAsPaid($id)
    {
        return $this->update($id, ['status' => 'sudah bayar']);
    }

    /**
     * Get monthly summary
     */
    public function getRingkasanBulanan($bulan, $tahun)
    {
        $data = [
            'hutang' => $this->selectSum('nominal')
                            ->where('jenis', 'hutang')
                            ->where('MONTH(tanggal)', $bulan)
                            ->where('YEAR(tanggal)', $tahun)
                            ->first()['nominal'] ?? 0,
            'piutang' => $this->selectSum('nominal')
                             ->where('jenis', 'piutang')
                             ->where('MONTH(tanggal)', $bulan)
                             ->where('YEAR(tanggal)', $tahun)
                             ->first()['nominal'] ?? 0
        ];
        
        return $data;
    }

    public function getGrafikHutangPiutang()
    {
        // Get total hutang
        $totalHutang = $this->select('SUM(nominal) as total')
            ->where('jenis', 'hutang')
            ->first();

        // Get total piutang
        $totalPiutang = $this->select('SUM(nominal) as total')
            ->where('jenis', 'piutang')
            ->first();

        // Get total hutang yang sudah dibayar
        $hutangLunas = $this->select('SUM(nominal) as total')
            ->where('jenis', 'hutang')
            ->where('status', 'sudah bayar')
            ->first();

        // Get total piutang yang sudah dibayar
        $piutangLunas = $this->select('SUM(nominal) as total')
            ->where('jenis', 'piutang')
            ->where('status', 'sudah bayar')
            ->first();

        return [
            'total_hutang' => (float)($totalHutang['total'] ?? 0),
            'total_piutang' => (float)($totalPiutang['total'] ?? 0),
            'hutang_lunas' => (float)($hutangLunas['total'] ?? 0),
            'piutang_lunas' => (float)($piutangLunas['total'] ?? 0)
        ];
    }
} 