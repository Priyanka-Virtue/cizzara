<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    // public function headings(): array
    // {
    //     return ["ID", "Name", "Email"];
    // }

    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }
    public function collection()
    {
        return $this->users;
    }

    // public function array(): array
    // {
    //     return $this->invoices;
    // }
}
