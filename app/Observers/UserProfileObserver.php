<?php
namespace App\Observers;
use App\Models\UserProfile;

class UserProfileObserver
{
    public function saving(UserProfile $profile) {
        // $profile->intro = clean( $profile->intro, 'default');
        $profile->intro = strip_tags($profile->intro);
    }
}