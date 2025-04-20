<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeScheduleModel extends Model
{
    protected $table = 'master_shift_setting';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pegawai', 'id_shift', 'tgl_shift'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getEmployeeSchedule($id_pegawai = false, $start_date = false, $end_date = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            master_shift_setting.*,
            pegawai.nama as nama_pegawai,
            master_shift.nama_shift,
            master_shift.jam_masuk,
            master_shift.jam_pulang
        ');
        
        $builder->join('pegawai', 'pegawai.id = master_shift_setting.id_pegawai');
        $builder->join('master_shift', 'master_shift.id = master_shift_setting.id_shift');

        if ($id_pegawai) {
            $builder->where('master_shift_setting.id_pegawai', $id_pegawai);
        }

        if ($start_date && $end_date) {
            $builder->where('master_shift_setting.tgl_shift >=', $start_date);
            $builder->where('master_shift_setting.tgl_shift <=', $end_date);
        }

        $builder->orderBy('master_shift_setting.tgl_shift', 'ASC');
        
        $query = $builder->get();
        return $query->getResult();
    }

    public function getScheduleByDate($date)
    {
        $builder = $this->db->table($this->table);
        $builder->select('
            master_shift_setting.*,
            pegawai.nama as nama_pegawai,
            master_shift.nama_shift,
            master_shift.jam_masuk,
            master_shift.jam_pulang
        ');
        
        $builder->join('pegawai', 'pegawai.id = master_shift_setting.id_pegawai');
        $builder->join('master_shift', 'master_shift.id = master_shift_setting.id_shift');
        $builder->where('master_shift_setting.tgl_shift', $date);
        
        $query = $builder->get();
        return $query->getResult();
    }

    public function checkExistingSchedule($id_pegawai, $tgl_shift)
    {
        return $this->where('id_pegawai', $id_pegawai)
                    ->where('tgl_shift', $tgl_shift)
                    ->first();
    }

    public function updateSchedule($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteSchedule($id)
    {
        return $this->delete($id);
    }
} 