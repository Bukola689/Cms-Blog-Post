<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index()
    {
        $adminContacts = Contact::orderBy('id', 'desc')->get();

        return response()->json($adminContacts);
    }

    public function getTotalContact()
    {
        $contact = Contact::count();

        return response()->json($contact);
    }

    public function delete(Contact $contact)
    {
        $contact = $contact->delete();

        return response()->json([
            'status' => true,
            'message' => $contact
        ]);
    }
}
