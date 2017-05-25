<?php

namespace App\Http\Controllers;

use App\Post;
use Mail;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests;

class PagesController extends Controller {

    public function getIndex(){
        $posts = Post::orderBy('created_at', 'desc')->limit(4)->get();
        return view('pages.welcome')->withPosts($posts);
    }

    public function getAbout(){
        $context['name'] = 'Sam';
        return view('pages.about')->with($context);
    }

    public function getContact(){
        return view('pages.contact');
    }

    public function postContact(Request $request) {
        // validation
        $this->validate($request, array(
            'email'         => 'required|email',
            'subject'       => 'min:3',
            'message'       => 'min:10'
        ));

        $data = array(
            'email'         => $request->email,
            'subject'       => $request->subject,
            'bodyMessage'   => $request->message
        );

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to('kifflavmraka@abv.bg');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your message has been sent');

        return redirect()->route('home');
    }
}