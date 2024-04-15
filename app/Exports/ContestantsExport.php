<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContestantsExport implements FromCollection, WithMapping, WithHeadings
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
    public function map($audition): array
    {
        // $userd = User::where('id', $user->id)->with('details')->first();

        $videos = '';
        $links = '';
        // $types = '';
        foreach ($audition->user->videos as $i => $video) {
            $videos .= ($i+1).'.) ' .  $video->original_name . ' ';
            $links .= ($i+1).'.) ' .  route('admin.videos.show', $video) . ' ';
            // $types .= ($i+1).'.) ' .  $video->style . ' ';

            $averageRating = $video->ratings->avg('rating');
            $videoRatings[] = $averageRating;
        }


        if (count($videoRatings) > 1) {
            $userAverageRating = array_sum($videoRatings) / count($videoRatings);
        } else {
            $userAverageRating = $videoRatings[0] ?? 0;
        }

        return [
            $audition->user->details->first_name . ' ' . $audition->user->details->last_name,
            $videos,
            $links,
            // $types,
            $userAverageRating,
            $audition->user->email,
            $audition->user->details->phone,
            $audition->user->details->date_of_birth,
            $audition->user->details->education,
            $audition->user->details->occupation,
            $audition->user->details->city,
            $audition->user->details->state,
            $audition->user->details->pin_code,
            $audition->user->details->address

        ];
    }

    public function headings(): array
    {
        $headings = [
            'name',
            'videos',
            'links',
            // 'types',
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
