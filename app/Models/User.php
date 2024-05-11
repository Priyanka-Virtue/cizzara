<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable, HasRoles;
    public function sendEmailVerificationNotification()
{
    $this->notify(new VerifyEmailNotification);
}
//     public function sendEmailVerificationNotification()
// {
//     $url = URL::temporarySignedRoute(
//         'verification.verify',
//         now()->addMinutes(60),
//         ['id' => $this->id, 'hash' => sha1($this->email_verification_token)]
//     );

//     $mail = new MailMessage;
//     $mail->line('Click the button below to verify your email address:')
//         ->action('Verify Email', $url)
//         ->from('audition@theunitedproduction.com', 'TUP');

//     Mail::to($this->email)->send($mail);
// }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    public function details()  {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_guru', 'guru_id', 'plan_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }


    public function scopeWithVideosByAudition($query, $plan, $sortByRating = false, $direction = 'asc')
    {
        $query = $query->whereHas('videos', function ($query) use ($plan) {
            $query->where('plan_id', $plan);
        })->with(['videos.ratings']);

        if ($sortByRating) {
            $query->leftJoin('videos', 'users.id', '=', 'videos.user_id')
                ->leftJoin('video_ratings', 'videos.id', '=', 'video_ratings.video_id')
                ->select('users.*')
                ->selectRaw('COUNT(video_ratings.id) as rating_count')
                ->groupBy('users.id')
                ->orderBy('rating_count', $direction);
        }

        return $query;
    }

}
