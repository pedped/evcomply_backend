<?php

namespace App\Http\Controllers\Api;

use App\DTO\Newsletter\NewsletterSubscribeResponse;
use App\Exceptions\Newsletter\NewsletterEmailExists;
use App\Http\Controllers\Controller;
use App\Services\Newsletter\NewsletterManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PharIo\Manifest\InvalidEmailException;

class NewsletterController extends Controller
{
    /**
     * this action will call when user wants to join the newsletter system
     * @return void
     */
    public function join(Request $request)
    {

        // we have to validate the inputs
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendResponse(new NewsletterSubscribeResponse(false, "Invalid email address received"));

        }

        // get email address
        $emailAddress = $request->post("email");

        // now, send the email address to newsletter manager to subscribe
        $newsletterManager = new NewsletterManager($emailAddress);
        try {
            if ($newsletterManager->joinSubscribers()) {
                return $this->sendResponse(new NewsletterSubscribeResponse(true));
            } else {
                return $this->sendResponse(new NewsletterSubscribeResponse(false, "Unable to subscribe the email to newsletter system"));
            }
        } catch (NewsletterEmailExists $e) {
            return $this->sendResponse(new NewsletterSubscribeResponse(false, "Email address already subscribed to newsletter"));
        } catch (InvalidEmailException $d) {
            return $this->sendResponse(new NewsletterSubscribeResponse(false, "Invalid email address provided"));
        }
    }

    public function sendResponse($response)
    {
        return Response::json($response);
    }
}
