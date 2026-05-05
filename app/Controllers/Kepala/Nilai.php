<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;

class Nilai extends BaseController
{
    protected $gradeModel;
    protected $santriModel;
    protected $classModel;

    public function __construct()
    {
        $this->gradeModel = new \App\Models\GradeModel();
        $this->santriModel = new \App\Models\SantriModel();
        $this->classModel = new \App\Models\ClassModel();
    }

    public function index()
    {
        $classId = $this->request->getGet('class_id');
        
        $query = $this->santriModel->select('santri.*, classes.name as class_name')
                                   ->join('classes', 'classes.id = santri.class_id', 'left');

        if ($classId) {
            $query->where('santri.class_id', $classId);
        }

        $santris = $query->findAll();

        // For each santri, get their latest grades or average?
        // Requirement says "Melihat semua nilai santri" and "Rekap nilai"
        // I'll just list them for now and maybe add a "Detail" link
        
        $data = [
            'title'   => 'Rekap Nilai Santri',
            'santris' => $santris,
            'classes' => $this->classModel->findAll(),
            'selected_class' => $classId
        ];

        return view('kepala/nilai/index', $data);
    }
}
