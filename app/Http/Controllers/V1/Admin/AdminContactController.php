<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;

use App\Models\Contact;
use App\Repositories\AdminContact\AdminContactRepository;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public $contact;

    public function __construct(AdminContactRepository $contact)
    {
        $this->contact = $contact;
    }
    public function index()
    {
        $adminContacts = $this->contact->allContact();

        return response()->json($adminContacts);
    }

    public function getTotalContact()
    {
        $contact = Contact::count();

        return response()->json($contact);
    }

    public function destroy(Contact $contact)
    {
       $this->contact->deleteContact($contact);

       return response()->json([
        'status' => 'Contact Deleted Successfully'
    ]);
    }
}
