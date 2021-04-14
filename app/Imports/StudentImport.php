<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Employee([
            'first_name'     => $row['first_name'],
            'middle_name'     => $row['middle_name'],
            'last_name'     => $row['last_name'],
            'mobile'     => $row['mobile'],
            'gender'     => $row['gender'],
            'dob'     => $row['dob'],
            'email'    => $row['email'], 
            'address'    => $row['address'], 
            'guardian_name'     => $row['guardian_name'],
            'guardian_phone'    => $row['guardian_phone'], 
            'guardian_relation'    => $row['guardian_relation'], 
            'user_type' => 'Student',
            'is_active' => 1,
            'password' => \Hash::make('admin123'),
        ]);
    }
}