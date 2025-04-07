<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenjualanModel;
use App\Models\ProdukModel;

class Penjualan extends BaseController
{
    protected $penjualanModel;
    protected $produkModel;

    public function __construct()
    {
        $this->penjualanModel = new PenjualanModel();
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Penjualan',
            'penjualan' => $this->penjualanModel->getPenjualanWithProduk(),
            'grafik_penjualan' => $this->penjualanModel->getGrafikPenjualan(),
            'produk_terlaris' => $this->penjualanModel->getTop5BestSellingProducts()
        ];

        return view('penjualan/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Penjualan',
            'validation' => \Config\Services::validation(),
            'produk' => $this->produkModel->findAll()
        ];

        return view('penjualan/tambah', $data);
    }

    public function save()
    {
        // Validation rules
        if (!$this->validate([
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi'
                ]
            ],
            'produk_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Produk harus dipilih'
                ]
            ],
            'jumlah' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Jumlah harus diisi',
                    'numeric' => 'Jumlah harus berupa angka',
                    'greater_than' => 'Jumlah harus lebih dari 0'
                ]
            ],
            'harga_satuan' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Harga satuan harus diisi',
                    'numeric' => 'Harga satuan harus berupa angka',
                    'greater_than' => 'Harga satuan harus lebih dari 0'
                ]
            ]
        ])) {
            return redirect()->to('/penjualan/tambah')->withInput();
        }

        // Get product data
        $produk = $this->produkModel->find($this->request->getVar('produk_id'));
        
        // Check stock availability
        if ($produk['stok'] < $this->request->getVar('jumlah')) {
            session()->setFlashdata('error', 'Stok tidak mencukupi');
            return redirect()->to('/penjualan/tambah')->withInput();
        }

        // Calculate total
        $total = $this->request->getVar('jumlah') * $this->request->getVar('harga_satuan');

        // Save penjualan
        $this->penjualanModel->save([
            'tanggal' => $this->request->getVar('tanggal'),
            'produk_id' => $this->request->getVar('produk_id'),
            'jumlah' => $this->request->getVar('jumlah'),
            'harga_satuan' => $this->request->getVar('harga_satuan'),
            'total' => $total
        ]);

        // Update product stock
        $this->produkModel->save([
            'id' => $produk['id'],
            'stok' => $produk['stok'] - $this->request->getVar('jumlah')
        ]);

        session()->setFlashdata('success', 'Data penjualan berhasil ditambahkan');
        return redirect()->to('/penjualan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Penjualan',
            'validation' => \Config\Services::validation(),
            'penjualan' => $this->penjualanModel->find($id),
            'produk' => $this->produkModel->findAll()
        ];

        if (empty($data['penjualan'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('penjualan/edit', $data);
    }

    public function update($id)
    {
        // Validation rules
        if (!$this->validate([
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal harus diisi'
                ]
            ],
            'produk_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Produk harus dipilih'
                ]
            ],
            'jumlah' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Jumlah harus diisi',
                    'numeric' => 'Jumlah harus berupa angka',
                    'greater_than' => 'Jumlah harus lebih dari 0'
                ]
            ],
            'harga_satuan' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Harga satuan harus diisi',
                    'numeric' => 'Harga satuan harus berupa angka',
                    'greater_than' => 'Harga satuan harus lebih dari 0'
                ]
            ]
        ])) {
            return redirect()->to('/penjualan/edit/' . $id)->withInput();
        }

        // Get product data
        $produk = $this->produkModel->find($this->request->getVar('produk_id'));
        
        // Get old penjualan data
        $oldPenjualan = $this->penjualanModel->find($id);
        
        // Calculate stock difference
        $stockDiff = $oldPenjualan['jumlah'] - $this->request->getVar('jumlah');
        
        // Check stock availability if reducing stock
        if ($stockDiff < 0 && abs($stockDiff) > $produk['stok']) {
            session()->setFlashdata('error', 'Stok tidak mencukupi');
            return redirect()->to('/penjualan/edit/' . $id)->withInput();
        }

        // Calculate total
        $total = $this->request->getVar('jumlah') * $this->request->getVar('harga_satuan');

        // Update penjualan
        $this->penjualanModel->save([
            'id' => $id,
            'tanggal' => $this->request->getVar('tanggal'),
            'produk_id' => $this->request->getVar('produk_id'),
            'jumlah' => $this->request->getVar('jumlah'),
            'harga_satuan' => $this->request->getVar('harga_satuan'),
            'total' => $total
        ]);

        // Update product stock
        $this->produkModel->save([
            'id' => $produk['id'],
            'stok' => $produk['stok'] + $stockDiff
        ]);

        session()->setFlashdata('success', 'Data penjualan berhasil diubah');
        return redirect()->to('/penjualan');
    }

    public function delete($id)
    {
        // Get penjualan data
        $penjualan = $this->penjualanModel->find($id);
        
        // Get product data
        $produk = $this->produkModel->find($penjualan['produk_id']);
        
        // Restore product stock
        $this->produkModel->save([
            'id' => $produk['id'],
            'stok' => $produk['stok'] + $penjualan['jumlah']
        ]);

        // Delete penjualan
        $this->penjualanModel->delete($id);
        
        session()->setFlashdata('success', 'Data penjualan berhasil dihapus');
        return redirect()->to('/penjualan');
    }
} 