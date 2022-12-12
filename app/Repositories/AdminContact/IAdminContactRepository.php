<?php

namespace App\Repositories\AdminContact;

use App\Models\Contact;

interface IAdminContactRepository
{
    public function allContact();

    public function deleteContact(Contact $contact);
}