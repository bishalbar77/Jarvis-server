<?php

namespace App\Imports;

use App\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

// Überschriften werden genau so übernommen wie sie in der Datei angegeben wurden
HeadingRowFormatter::default('none');

class EmployeesImport implements ToCollection, WithHeadingRow, WithEvents
{
    public $sheetNames;
    public $sheetData;
	
    public function __construct(){
        $this->sheetNames = [];
        $this->sheetData = [];
    }

    public function collection(Collection $collection)
    {
    	$this->sheetData[] = $collection;
    }
    
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
            	$this->sheetNames[] = $event->getSheet()->getTitle();
            } 
        ];
    }

}