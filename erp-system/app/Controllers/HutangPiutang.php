<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HutangPiutangModel;

class HutangPiutang extends BaseController
{
    protected $hutangPiutangModel;

    public function __construct()
    {
        $this->hutangPiutangModel = new HutangPiutangModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Hutang & Piutang',
            'hutang' => $this->hutangPiutangModel->where('jenis', 'Hutang')->findAll(),
            'piutang' => $this->hutangPiutangModel->where('jenis', 'Piutang')->findAll()
        ];

        return view('hutang_piutang/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Hutang/Piutang',
            'validation' => \Config\Services::validation()
        ];

        return view('hutang_piutang/create', $data);
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
            'jenis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis harus dipilih'
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nominal harus diisi',
                    'numeric' => 'Nominal harus berupa angka'
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan harus diisi'
                ]
            ]
        ])) {
            return redirect()->to('/hutang-piutang/create')->withInput();
        }

        $this->hutangPiutangModel->save([
            'tanggal' => $this->request->getVar('tanggal'),
            'jenis' => $this->request->getVar('jenis'),
            'nominal' => $this->request->getVar('nominal'),
            'keterangan' => $this->request->getVar('keterangan'),
            'status' => 'Belum Lunas'
        ]);

        session()->setFlashdata('success', 'Data berhasil ditambahkan');
        return redirect()->to('/hutang-piutang');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Hutang/Piutang',
            'validation' => \Config\Services::validation(),
            'hutang_piutang' => $this->hutangPiutangModel->find($id)
        ];

        if (empty($data['hutang_piutang'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('hutang_piutang/edit', $data);
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
            'jenis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis harus dipilih'
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nominal harus diisi',
                    'numeric' => 'Nominal harus berupa angka'
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan harus diisi'
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status harus dipilih'
                ]
            ]
        ])) {
            return redirect()->to('/hutang-piutang/edit/' . $id)->withInput();
        }

        $this->hutangPiutangModel->save([
            'id' => $id,
            'tanggal' => $this->request->getVar('tanggal'),
            'jenis' => $this->request->getVar('jenis'),
            'nominal' => $this->request->getVar('nominal'),
            'keterangan' => $this->request->getVar('keterangan'),
            'status' => $this->request->getVar('status')
        ]);

        session()->setFlashdata('success', 'Data berhasil diubah');
        return redirect()->to('/hutang-piutang');
    }

    public function delete($id)
    {
        $this->hutangPiutangModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('/hutang-piutang');
    }
} 