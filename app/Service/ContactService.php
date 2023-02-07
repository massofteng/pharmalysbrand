<?php

namespace App\Services;

use App\Models\Contact;

class ContactService
{

    public static function SaveContact($request)
    {
        $contact = new Contact();
        $contact->salution = $request->salutation;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $save = $contact->save();

        if ($save) {
            return true;
        }

        return false;
    }
}
