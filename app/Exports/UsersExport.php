<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

use function PHPSTORM_META\map;

class UsersExport implements FromCollection, WithMapping, WithHeadings
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
            $user->details->first_name . ' ' . $user->details->last_name,
            $user->email,
            $user->details->phone,
            $user->details->date_of_birth,
            $user->details->education,
            $user->details->occupation,
            $user->details->city,
            $user->details->state,
            $user->details->pin_code,
            $user->details->address

        ];
    }

    public function headings(): array
    {
        $headings = [
            'name',
           
            'email',
            'phone',
            'date_of_birth',
            'education',
            'occupation',
            'city',
            'state',
            'pin_code',
            'address'

        ];
        return array_map('strtoupper', $headings);
    }


}
