<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ShiftModel;
use App\Models\UsersModel;
use App\Models\PegawaiModel;
use App\Models\EmployeeScheduleModel;

class Shift extends BaseController
{
    protected $shiftModel;
    protected $usersModel;
    protected $pegawaiModel;
    protected $employeeScheduleModel;

    public function __construct()
    {
        $this->shiftModel = new ShiftModel();
        $this->usersModel = new UsersModel();
        $this->pegawaiModel = new PegawaiModel();
        $this->employeeScheduleModel = new EmployeeScheduleModel();
    }

    public function index()
    {
        $user_profile = $this->usersModel->getUserInfo(user_id());
        if ($user_profile->role != 'admin') {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $data['title'] = 'Data Shift';
        $data['subtitle'] = 'Data Shift';
        $data['page'] = 'shift/index';
        $data['shifts'] = $this->shiftModel->findAll();
        $data['user_profile'] = $user_profile;

        return view('shift/index', $data);
    }

    public function store()
    {
        // Validate input
        $rules = [
            'nama_shift' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save to database
        $data = [
            'nama_shift' => $this->request->getVar('nama_shift'),
            'jam_mulai' => $this->request->getVar('jam_mulai'),
            'jam_selesai' => $this->request->getVar('jam_selesai'),
        ];
        $this->shiftModel->insert($data);

        return redirect()->to('/shift')->with('message', 'Shift berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Shift';
        $data['subtitle'] = 'Edit Shift';
        $data['page'] = 'shift/edit';

        $data['shift'] = $this->shiftModel->find($id);

        return view('shift/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'nama_shift' => $this->request->getVar('nama_shift'),
            'jam_mulai' => $this->request->getVar('jam_mulai'),
            'jam_selesai' => $this->request->getVar('jam_selesai'),
        ];

        $this->shiftModel->update($id, $data);

        return redirect()->to('/shift')->with('success', 'Shift berhasil diubah');
    }

    public function delete($id)
    {
        $this->shiftModel->delete($id);

        return redirect()->to('/shift')->with('success', 'Shift berhasil dihapus');
    }

    public function settingShift()
    {
        $user_profile = $this->usersModel->getUserInfo(user_id());
        if ($user_profile->role != 'admin') {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $data_pegawai = $this->pegawaiModel->getPegawai();

        $data['title'] = 'Setting Shift';
        $data['subtitle'] = 'Setting Shift';
        $data['page'] = 'shift/setting';

        $data['shifts'] = $this->shiftModel->findAll();
        $data['user_profile'] = $user_profile;
        $data['data_pegawai'] = $data_pegawai;
        $data['employee_schedule'] = $this->employeeScheduleModel->findAll();

        return view('shift/setting', $data);
    }

    public function storeSettingShift()
    {
        $validationRules = [
            'id_pegawai' => 'required',
            'id_pegawai.*' => 'numeric',
            'id_shift' => 'required',
            'id_shift.*' => 'permit_empty|numeric'
        ];
    
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('message', $this->validator->getErrors());
        }

        $employeeId = $this->request->getPost('id_pegawai');
        $shiftId = $this->request->getPost('id_shift');
        $date = $this->request->getPost('tgl_shift');

        // Validate input
        if (empty($employeeId) || empty($shiftId) || empty($date)) {
            return redirect()->back()->with('message', 'All fields are required');
        }

        // Save assignment
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('master_shift_setting');
            
            $tempData = [];
            foreach ($employeeId as $index => $empId) {
                $data = [
                    'id_pegawai' => $empId,
                    'id_shift' => $shiftId[$index],
                    'tgl_shift' => $date[$index],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                // Check if schedule already exists
                $exists = $this->employeeScheduleModel->checkExistingSchedule($empId, $date[$index]);
                
                if (!$exists) {
                    // Insert new schedule if shift is selected
                    if (!empty($shiftId[$index])) {
                        $builder->insert($data);
                        $tempData[$index] = $data;
                    }
                } else {
                    if (!empty($shiftId[$index])) {
                        // Update existing schedule
                        $builder->where('id_pegawai', $empId)
                               ->where('tgl_shift', $date[$index])
                               ->update(['id_shift' => $shiftId[$index], 'updated_at' => date('Y-m-d H:i:s')]);
                        $tempData[$index] = $data;
                    } else {
                        // Delete schedule if no shift selected
                        // $builder->where('id_pegawai', $empId)
                        //        ->where('tgl_shift', $date[$index])
                        //        ->delete();
                    }
                }
            }

            return response()->setJSON([
                'status' => 'success',
                'message' => 'Jadwal berhasil disimpan',
                'data' => $tempData
            ]);
        } catch (\Exception $e) {
            return response()->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan jadwal: ' . $e->getMessage()
            ]);
        }
    }
}