<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdukModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Produk',
            'produk' => $this->produkModel->findAll()
        ];
        // echo  json_encode($data);

        return view('produk/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Produk',
            'validation' => \Config\Services::validation()
        ];

        return view('produk/tambah', $data);
    }

    public function save()
    {
        // Validation rules
        if (!$this->validate([
            'kode' => [
                'rules' => 'required|is_unique[produk.kode]',
                'errors' => [
                    'required' => 'Kode produk harus diisi',
                    'is_unique' => 'Kode produk sudah terdaftar'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk harus diisi'
                ]
            ],
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus dipilih'
                ]
            ],
            'harga' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Harga harus diisi',
                    'numeric' => 'Harga harus berupa angka',
                    'greater_than' => 'Harga harus lebih dari 0'
                ]
            ],
            'stok' => [
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => [
                    'required' => 'Stok harus diisi',
                    'numeric' => 'Stok harus berupa angka',
                    'greater_than_equal_to' => 'Stok tidak boleh negatif'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[aktif,nonaktif]',
                'errors' => [
                    'required' => 'Status harus dipilih',
                    'in_list' => 'Status tidak valid'
                ]
            ]
        ])) {
            return redirect()->to('/produk/tambah')->withInput();
        }

        $this->produkModel->save([
            'kode' => $this->request->getVar('kode'),
            'nama' => $this->request->getVar('nama'),
            'kategori' => $this->request->getVar('kategori'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'status' => $this->request->getVar('status')
        ]);

        session()->setFlashdata('success', 'Data produk berhasil ditambahkan');
        return redirect()->to('/produk');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Produk',
            'validation' => \Config\Services::validation(),
            'produk' => $this->produkModel->find($id)
        ];

        if (empty($data['produk'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        return view('produk/edit', $data);
    }

    public function update($id)
    {
        // Check if kode is changed
        $produk = $this->produkModel->find($id);
        $kodeRule = 'required';
        if ($produk['kode'] !== $this->request->getVar('kode')) {
            $kodeRule .= '|is_unique[produk.kode]';
        }

        // Validation rules
        if (!$this->validate([
            'kode' => [
                'rules' => $kodeRule,
                'errors' => [
                    'required' => 'Kode produk harus diisi',
                    'is_unique' => 'Kode produk sudah terdaftar'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk harus diisi'
                ]
            ],
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus dipilih'
                ]
            ],
            'harga' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Harga harus diisi',
                    'numeric' => 'Harga harus berupa angka',
                    'greater_than' => 'Harga harus lebih dari 0'
                ]
            ],
            'stok' => [
                'rules' => 'required|numeric|greater_than_equal_to[0]',
                'errors' => [
                    'required' => 'Stok harus diisi',
                    'numeric' => 'Stok harus berupa angka',
                    'greater_than_equal_to' => 'Stok tidak boleh negatif'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[aktif,nonaktif]',
                'errors' => [
                    'required' => 'Status harus dipilih',
                    'in_list' => 'Status tidak valid'
                ]
            ]
        ])) {
            return redirect()->to('/produk/edit/' . $id)->withInput();
        }

        $this->produkModel->save([
            'id' => $id,
            'kode' => $this->request->getVar('kode'),
            'nama' => $this->request->getVar('nama'),
            'kategori' => $this->request->getVar('kategori'),
            'harga' => $this->request->getVar('harga'),
            'stok' => $this->request->getVar('stok'),
            'status' => $this->request->getVar('status')
        ]);

        session()->setFlashdata('success', 'Data produk berhasil diubah');
        return redirect()->to('/produk');
    }

    public function delete($id)
    {
        $produk = $this->produkModel->find($id);
        
        if (empty($produk)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }

        $this->produkModel->delete($id);
        session()->setFlashdata('success', 'Data produk berhasil dihapus');
        return redirect()->to('/produk');
    }
} 