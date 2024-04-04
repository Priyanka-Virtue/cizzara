<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */



    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }
    public function collection()
    {
        return $this->users;
    }
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            // Access and map the related data (e.g., details)
            $user->details->phone, // Example: Concatenate multiple detail records
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Details', // Example: Heading for the related data
        ];
    }

    // public function array(): array
    // {
    //     return $this->invoices;
    // }
}
