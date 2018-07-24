<?php
namespace App\Observers;
use App\Models\UserFeedback;

class UserFeedbackObserver
{
    public function saving(UserFeedback $feedback) {
        $feedback->description = clean( $feedback->description, 'default');
    }
}