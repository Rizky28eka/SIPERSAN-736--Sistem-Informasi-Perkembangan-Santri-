<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\ClassModel;

class Santri extends BaseController
{
    protected $santriModel;
    protected $classModel;

    public function __construct()
    {
        $this->santriModel = new SantriModel();
        $this->classModel = new ClassModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $keyword = $this->request->getGet('keyword');
        
        // Get classes managed by this teacher
        $classes = $this->classModel->where('teacher_id', $userId)->findAll();
        $classIds = array_column($classes, 'id');

        if (empty($classIds)) {
            $santriList = [];
        } else {
            $builder = $this->santriModel->select('santri.*, classes.name as class_name')
                                         ->join('classes', 'classes.id = santri.class_id')
                                         ->whereIn('santri.class_id', $classIds);
            
            if ($keyword) {
                $builder->groupStart()
                        ->like('santri.name', $keyword)
                        ->orLike('santri.nisn', $keyword)
                        ->groupEnd();
            }
            
            $santriList = $builder->findAll();
        }

        $data = [
            'title'   => 'Data Santri',
            'santri'  => $santriList,
            'keyword' => $keyword
        ];

        return view('guru/santri/index', $data);
    }
}
