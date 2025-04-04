<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengeluaranModel;

class Pengeluaran extends BaseController
{
    protected $pengeluaranModel;

    public function __construct()
    {
        $this->pengeluaranModel = new PengeluaranModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengeluaran',
            'pengeluaran' => $this->pengeluaranModel->findAll()
        ];

        return view('pengeluaran/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Pengeluaran',
            'validation' => \Config\Services::validation()
        ];

        return view('pengeluaran/tambah', $data);
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
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus dipilih'
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan harus diisi'
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nominal harus diisi',
                    'numeric' => 'Nominal harus berupa angka'
                ]
            ]
        ])) {
            return redirect()->to('/pengeluaran/tambah')->withInput();
        }

        $this->pengeluaranModel->save([
            'tanggal' => $this->request->getVar('tanggal'),
            'kategori' => $this->request->getVar('kategori'),
            'keterangan' => $this->request->getVar('keterangan'),
            'nominal' => $this->request->getVar('nominal')
        ]);

        session()->setFlashdata('success', 'Data pengeluaran berhasil ditambahkan');
        return redirect()->to('/pengeluaran');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pengeluaran',
            'validation' => \Config\Services::validation(),
            'pengeluaran' => $this->pengeluaranModel->find($id)
        ];

        if (empty($data['pengeluaran'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('pengeluaran/edit', $data);
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
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus dipilih'
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan harus diisi'
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nominal harus diisi',
                    'numeric' => 'Nominal harus berupa angka'
                ]
            ]
        ])) {
            return redirect()->to('/pengeluaran/edit/' . $id)->withInput();
        }

        $this->pengeluaranModel->save([
            'id' => $id,
            'tanggal' => $this->request->getVar('tanggal'),
            'kategori' => $this->request->getVar('kategori'),
            'keterangan' => $this->request->getVar('keterangan'),
            'nominal' => $this->request->getVar('nominal')
        ]);

        session()->setFlashdata('success', 'Data pengeluaran berhasil diubah');
        return redirect()->to('/pengeluaran');
    }

    public function delete($id)
    {
        $this->pengeluaranModel->delete($id);
        session()->setFlashdata('success', 'Data pengeluaran berhasil dihapus');
        return redirect()->to('/pengeluaran');
    }
} 