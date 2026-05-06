<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\SantriModel;
use App\Models\SppModel;

class GenerateBills extends BaseCommand
{
    protected $group       = 'SPP';
    protected $name        = 'spp:generate';
    protected $description = 'Generate monthly SPP bills for all students based on their class price.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $sppModel = new SppModel();

        $month = date('n');
        $year = date('Y');
        $dueDate = date('Y-m-10');

        // Fetch students joined with classes to get spp_price
        $students = $db->table('santri')
                       ->select('santri.id, classes.spp_price')
                       ->join('classes', 'classes.id = santri.class_id')
                       ->get()
                       ->getResultArray();

        $count = 0;

        foreach ($students as $student) {
            $exists = $sppModel->where([
                'santri_id' => $student['id'],
                'month' => $month,
                'year' => $year
            ])->first();

            if (!$exists) {
                $sppModel->insert([
                    'santri_id' => $student['id'],
                    'month' => $month,
                    'year' => $year,
                    'due_date' => $dueDate,
                    'amount' => $student['spp_price'],
                    'total_paid' => 0,
                    'status' => 'belum'
                ]);
                $count++;
            }
        }

        CLI::write("Success! Generated $count new bills for $month/$year.", 'green');
    }
}
