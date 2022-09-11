<?php

namespace App\Models\Newsletter;

use App\Enums\NewsletterStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        "email",
        "status"
    ];

    /**
     * this function will check the database and see
     * if such email already exists in database
     * @param string $emailAddress
     * @return bool true if we have found that email in system and false if we did not
     */
    public static function emailExistsInSystem(string $emailAddress): bool
    {
        return self::where([
                ["email", $emailAddress]
            ])->count() > 0;
    }


    /**
     * this function will check the database and see
     * if such email is active in database
     * @param string $emailAddress
     * @return bool true if we have found that email in system and false if we did not
     */
    public static function emailIsActive(string $emailAddress): bool
    {
        return self::where([
                ["email", $emailAddress],
                ["status", NewsletterStatus::$active]
            ])->count() > 0;
    }

    /**
     * this function will activate the email address again
     * @param string $emailAddress the email address that we want to save
     * @return bool return true if it activated and false when it is not activated
     */
    public static function activateEmailAddress(string $emailAddress): bool
    {
        // get the newsletter
        $newsletterEmail = self::where("email", $emailAddress)->first();

        // set the status to true
        $newsletterEmail->status = NewsletterStatus::$active;

        // save it
        return $newsletterEmail->save();
    }


    /**
     * this function will add the email address to the database
     * @param string $emailAddress the email address that we want to save
     * @return bool return true if it the email address added and activated and false when it is failed
     */
    public static function addEmailAddress(string $emailAddress): bool
    {
        // get the newsletter
        $newsletterEmail = new NewsletterEmail();

        // set the status to true
        $newsletterEmail->email = $emailAddress;
        $newsletterEmail->status = NewsletterStatus::$active;

        // save it
        return $newsletterEmail->save();
    }
}
