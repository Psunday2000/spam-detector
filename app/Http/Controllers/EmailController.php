<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $inbox_count = Email::where('is_spam', 1)
                ->where('receiver_email', auth()->user()->email)
                ->count();

            $sent_count = Email::where('user_id', auth()->id())
                ->count();

            $spam_count = Email::where('is_spam', 0)
                ->where('receiver_email', auth()->user()->email)
                ->count();

            $trash_count = Email::onlyTrashed()
                ->where(function($query) {
                    $query->where('user_id', auth()->id())
                        ->orWhere('receiver_email', auth()->user()->email);
                })
                ->count();

            $emails = Email::where('is_spam', 1)
                ->where('receiver_email', auth()->user()->email)
                ->with('user')
                ->get();

            foreach ($emails as $email) {
                $email->is_spam = $this->detectSpam($email->body);
                $email->save();
            }

            return view('emails.index', compact('emails', 'inbox_count', 'sent_count', 'spam_count', 'trash_count'));
        } else {
            return redirect(route('home'));
        }
    }

    public function show(Email $email)
    {
         // Check if the user is authenticated
         if (Auth::check()) {
            return view('emails.show', compact('email'));
        } else {
            return redirect(route('home'));
        }
    }

    public function sent()
    {
         // Check if the user is authenticated
         if (Auth::check()) {
            $inbox_count = Email::where('is_spam', 1)
                ->where('receiver_email', auth()->user()->email)
                ->count();

            $sent_count = Email::where('user_id', auth()->id())
                ->count();

            $spam_count = Email::where('is_spam', 0)
                ->where('receiver_email', auth()->user()->email)
                ->count();

            $trash_count = Email::onlyTrashed()
                ->where(function($query) {
                    $query->where('user_id', auth()->id())
                        ->orWhere('receiver_email', auth()->user()->email);
                })
                ->count();
            $emails = Email::where('user_id', auth()->id())->get();
            return view('emails.index', compact('emails', 'inbox_count', 'sent_count', 'spam_count', 'trash_count'));
        } else {
            return redirect(route('home'));
        }
    }

    public function spam()
    {
         // Check if the user is authenticated
         if (Auth::check()) {
            $inbox_count = Email::where('is_spam', 1)
                ->where('receiver_email', auth()->user()->email)
                ->count();

            $sent_count = Email::where('user_id', auth()->id())
                ->count();

            $spam_count = Email::where('is_spam', 0)
                ->where('receiver_email', auth()->user()->email)
                ->count();

            $trash_count = Email::onlyTrashed()
                ->where(function($query) {
                    $query->where('user_id', auth()->id())
                        ->orWhere('receiver_email', auth()->user()->email);
                })
                ->count();
            $emails = Email::where('is_spam', 0)
                        ->where(function($query) {
                                $query->where('receiver_email', auth()->user()->email);
                            })
                        ->get();

            return view('emails.index', compact('emails', 'inbox_count', 'sent_count', 'spam_count', 'trash_count'));
        } else {
            return redirect(route('home'));
        }
    }

    public function trash()
    {
         // Check if the user is authenticated
         if (Auth::check()) {
            $inbox_count = Email::where('is_spam', 1)
                ->where('receiver_email', auth()->user()->email)
                ->count();

            $sent_count = Email::where('user_id', auth()->id())
                ->count();

            $spam_count = Email::where('is_spam', 0)
                ->where('receiver_email', auth()->user()->email)
                ->count();

            $trash_count = Email::onlyTrashed()
                ->where(function($query) {
                    $query->where('user_id', auth()->id())
                        ->orWhere('receiver_email', auth()->user()->email);
                })
                ->count();
            $emails = Email::onlyTrashed()
                        ->where(function($query) {
                                $query->where('user_id', auth()->id())
                                    ->orWhere('receiver_email', auth()->user()->email);
                            })
                        ->get();
    
            return view('emails.index', compact('emails', 'inbox_count', 'sent_count', 'spam_count', 'trash_count'));
        } else {
            return redirect(route('home'));
        }
    }

    public function create()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $users = User::all();
        return view('emails.create', compact('users'));
        } else {
            return redirect(route('home'));
        }
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'sender_email' => 'required|email|exists:users,email',
            'receiver_email' => 'required|email|exists:users,email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        // Extract email data
        $emailData = $request->only(['user_id', 'sender_email', 'receiver_email', 'subject', 'body']);

        // Detect spam using Flask API
        $emailData['is_spam'] = $this->detectSpam($emailData['body']);

        // Create and save the email
        Email::create($emailData);

        return redirect()->route('emails.index')->with('success', 'Email Sent');
    }

    private function detectSpam($body)
    {
    // Log the start of the spam detection process
    Log::info('Detecting spam for email body:', ['body' => $body]);

    try {
        // Call the Flask API to detect spam
        $response = Http::post('http://localhost:5000/predict', [
            'email_content' => $body,
        ]);

        // Log the API response
        Log::info('Spam detection API response:', ['response' => $response->json()]);

        // Check if the response was successful and return the spam status
        if ($response->successful()) {
            return $response->json()['is_spam'];
        } else {
            // Log the failure case
            Log::error('Spam detection API call failed:', ['response' => $response->body()]);
        }
    } catch (\Exception $e) {
        // Log any exceptions
        Log::error('Exception occurred during spam detection:', ['exception' => $e->getMessage()]);
    }

    // Handle the case where the API call fails
    return false; // or handle the failure case appropriately
    }


    public function softDelete($id)
    {
         // Check if the user is authenticated
         if (Auth::check()) {
            $email = Email::findOrFail($id);
        $email->delete();

        return redirect()->route('emails.index')->with('success', 'Email soft deleted successfully');
        } else {
            return redirect(route('home'));
        }
    }
    
    public function restore($id)
    {
         // Check if the user is authenticated
         if (Auth::check()) {
            $email = Email::onlyTrashed()->findOrFail($id);
            $email->restore();
    
            return redirect()->route('emails.index')->with('success', 'Email restored successfully');
        } else {
            return redirect(route('home'));
        }
    }

}
