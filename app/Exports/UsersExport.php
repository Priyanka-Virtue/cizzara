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
        $userd = User::where('id', $user->id)->with('details')->first();

        $videos = '';
        $links = '';
        $types = '';
        foreach ($userd->videos as $i => $video) {

            $videos .= ($i+1).'.) ' .  $video->original_name . ' ';
            $links .= ($i+1).'.) ' .  route('admin.videos.show', $video) . ' ';
            $types .= ($i+1).'.) ' .  $video->style . ' ';

            $averageRating = $video->ratings->avg('rating');
            $videoRatings[] = $averageRating;
        }


        if (count($videoRatings) > 1) {
            $userAverageRating = array_sum($videoRatings) / count($videoRatings);
        } else {
            $userAverageRating = $videoRatings[0] ?? 0;
        }

        return [
            $userd->details->first_name . ' ' . $userd->details->last_name,
            $videos,
            $links,
            $types,
            $userAverageRating,
            $userd->email,
            $userd->details->phone,
            $userd->details->date_of_birth,
            $userd->details->education,
            $userd->details->occupation,
            $userd->details->city,
            $userd->details->state,
            $userd->details->pin_code,
            $userd->details->address

        ];
    }

    public function headings(): array
    {
        $headings = [
            'name',
            'videos',
            'links',
            'types',
            'Average Rating',
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
