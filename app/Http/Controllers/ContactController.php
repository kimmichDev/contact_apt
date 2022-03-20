<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function checkExistence($id)
    // {

    //     return $contact;
    // }

    public function index()
    {
        $contact = Contact::latest("id")->get();
        return response()->json($contact);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        Contact::create([
            "name" => $request->name,
            "phone" => $request->phone
        ]);
        return response()->json(["message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $contact = Contact::find($id);
        if (is_null($contact)) {
            return response()->json(["message" => "No contact with such id", "status" => "204"]);
        };
        return response()->json($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        if ($request->has('name')) {
            $contact->name = $request->name;
        }
        if ($request->has('phone')) {
            $contact->phone = $request->phone;
        }
        $contact->update();
        return response()->json($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return response()->json(["message" => "No contact with such id", "status" => "204"]);
        };
        $contact->delete();
        return response("Successfully deleted");
    }
}
