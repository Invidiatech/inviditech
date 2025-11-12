<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Store a new contact message.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'privacy' => 'required|accepted'
        ], [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'subject.required' => 'Please select a subject.',
            'message.required' => 'Please provide project details.',
            'message.max' => 'Message is too long. Please keep it under 5000 characters.',
            'privacy.required' => 'You must agree to the privacy policy.',
            'privacy.accepted' => 'You must agree to the privacy policy.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'privacy' => true,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'unread'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! I\'ll get back to you within 24 hours.',
                'contact_id' => $contact->id
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'There was an error sending your message. Please try again later.'
            ], 500);
        }
    }

    /**
     * Show the contact form (for non-React routes).
     */
    public function index()
    {
        return view('layouts.react');
    }
}
