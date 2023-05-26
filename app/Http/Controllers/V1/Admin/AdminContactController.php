<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;

use App\Models\Contact;
use App\Repositories\AdminContact\AdminContactRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminContactController extends Controller
{
    public $contact;

    public function __construct(AdminContactRepository $contact)
    {
        $this->contact = $contact;
    }
    public function index()
    {
        $count = Contact::orderBy('id', 'desc')->count();

        $adminContacts = cache()->remember('contacts', 30, function () {
            return $this->contact->allContact();
        });

        return response()->json([$count, $adminContacts]);
    }

   
    public function destroy(Contact $contact)
    {
       $this->contact->deleteContact($contact);

       Cache::pull('contact');

       return response()->json([
        'status' => 'Contact Deleted Successfully'
    ]);
    }
}
