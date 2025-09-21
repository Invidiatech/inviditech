<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'privacy' => 'required|accepted',
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'Please select a subject.',
            'message.required' => 'Please enter your message.',
            'privacy.required' => 'You must agree to the privacy policy.',
            'privacy.accepted' => 'You must agree to the privacy policy.',
        ]);

        try {
            // Create contact record
            $contact = Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'privacy' => true,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Send email notification (optional)
            // Mail::to('sardarnawaz122@gmail.com')->send(new ContactFormMail($contact));

            return redirect()->back()->with('success', 
                'Thank you for reaching out! Your message has been received and I\'ll get back to you within 24 hours.'
            );

        } catch (\Exception $e) {
            \Log::error('Contact form submission failed: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 
                'Sorry, there was an issue sending your message. Please try again or contact me directly via email.'
            )->withInput();
        }
    }
}
