<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['kode', 'nama_produk', 'kategori', 'stok', 'harga_beli', 'harga_jual', 'satuan', 'status', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama_produk' => 'required|min_length[3]|is_unique[produk.nama_produk,id,{id}]',
        'stok' => 'required|numeric|greater_than_equal_to[0]',
        'harga_beli' => 'required|numeric|greater_than[0]',
        'harga_jual' => 'required|numeric|greater_than[0]'
    ];
    protected $validationMessages = [
        'nama_produk' => [
            'required' => 'Nama produk harus diisi',
            'min_length' => 'Nama produk minimal 3 karakter',
            'is_unique' => 'Nama produk sudah digunakan'
        ],
        'stok' => [
            'required' => 'Stok harus diisi',
            'numeric' => 'Stok harus berupa angka',
            'greater_than_equal_to' => 'Stok tidak boleh negatif'
        ],
        'harga_beli' => [
            'required' => 'Harga beli harus diisi',
            'numeric' => 'Harga beli harus berupa angka',
            'greater_than' => 'Harga beli harus lebih dari 0'
        ],
        'harga_jual' => [
            'required' => 'Harga jual harus diisi',
            'numeric' => 'Harga jual harus berupa angka',
            'greater_than' => 'Harga jual harus lebih dari 0'
        ]
    ];
    protected $skipValidation = false;

    /**
     * Get products with low stock (less than 10)
     */
    public function getProdukStokMenipis()
    {
        return $this->where('stok <', 10)
                    ->findAll();
    }

    /**
     * Update stock after sale
     */
    public function updateStok($id, $jumlah)
    {
        $produk = $this->find($id);
        if ($produk) {
            $newStok = $produk['stok'] - $jumlah;
            if ($newStok >= 0) {
                return $this->update($id, ['stok' => $newStok]);
            }
        }
        return false;
    }

    /**
     * Add stock
     */
    public function tambahStok($id, $jumlah)
    {
        $produk = $this->find($id);
        if ($produk) {
            $newStok = $produk['stok'] + $jumlah;
            return $this->update($id, ['stok' => $newStok]);
        }
        return false;
    }

    /**
     * Calculate profit margin
     */
    public function hitungMargin($id)
    {
        $produk = $this->find($id);
        if ($produk) {
            return $produk['harga_jual'] - $produk['harga_beli'];
        }
        return 0;
    }

    /**
     * Get total inventory value
     */
    public function getTotalNilaiInventori()
    {
        $produk = $this->findAll();
        $total = 0;
        foreach ($produk as $item) {
            $total += $item['stok'] * $item['harga_beli'];
        }
        return $total;
    }
} 