<?php
namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->recent()->paginate(20);
        $statusCounts = Contact::getStatusCounts();

        return view('seo.contacts.index', compact('contacts', 'statusCounts'));
    }

    public function show(Contact $contact)
    {
        // Mark as read when viewed
        if ($contact->status === 'unread') {
            $contact->markAsRead();
        }

        return view('seo.contacts.show', compact('contact'));
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status' => 'required|in:unread,read,replied,archived'
        ]);

        $contact->update(['status' => $validated['status']]);

        if ($validated['status'] === 'replied') {
            $contact->update(['replied_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Contact status updated successfully!'
        ]);
    }

    public function updateNotes(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:2000'
        ]);

        $contact->update(['admin_notes' => $validated['admin_notes']]);

        return response()->json([
            'success' => true,
            'message' => 'Notes updated successfully!'
        ]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('seo.contacts.index')
            ->with('success', 'Contact deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:mark_read,mark_replied,mark_archived,delete',
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id'
        ]);

        $contacts = Contact::whereIn('id', $validated['contact_ids']);

        switch ($validated['action']) {
            case 'mark_read':
                $contacts->update(['status' => 'read', 'read_at' => now()]);
                $message = 'Selected contacts marked as read.';
                break;
            case 'mark_replied':
                $contacts->update(['status' => 'replied', 'replied_at' => now()]);
                $message = 'Selected contacts marked as replied.';
                break;
            case 'mark_archived':
                $contacts->update(['status' => 'archived']);
                $message = 'Selected contacts archived.';
                break;
            case 'delete':
                $contacts->delete();
                $message = 'Selected contacts deleted.';
                break;
        }

        return redirect()->route('seo.contacts.index')
            ->with('success', $message);
    }
}