<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $q = Enquiry::with('property')->latest('id');

        if ($s = $request->query('status')) {
            $q->where('status', $s);
        }

        $enquiries = $q->paginate(20)->withQueryString();

        /* Page kholte hi sab "dekhi hui" ho jaati hain, isliye sidebar
           ka badge bujh jaata hai. Ye `status` se alag hai -- wo tab
           badalta hai jab aap call karte ho. */
        Enquiry::unseen()->update(['seen_at' => now()]);

        return view('admin.enquiries.index', compact('enquiries'));
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        $enquiry->update($request->validate([
            'status'     => ['required', 'string', 'max:20'],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]));

        return back()->with('ok', 'Update ho gaya.');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return back()->with('ok', 'Enquiry hata di.');
    }
}
