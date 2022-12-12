<?php

namespace App\Repositories\AdminContact;

use App\Models\Contact;

class AdminContactRepository implements IAdminContactRepository
{
    public function allContact()
    {
        $adminContacts = Contact::orderBy('id', 'desc')->get();

        return response()->json($adminContacts);
    }

    public function deleteContact(Contact $contact)
    {
        $contact = $contact->delete();
    }
}