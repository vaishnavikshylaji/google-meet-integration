<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CaptchaController extends Controller
{
    public function index()
    {
        return view('google-captcha-enterprises.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'g-recaptcha-token' => 'required',
        ]);

        $recaptchaResponse = $request->input('g-recaptcha-token');
        $secretKey = config('services.recaptcha.site_secret');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
        ]);

        $body = $response->json();

        if (!$body['success']) {
            return back()->withErrors(['g-recaptcha-token' => 'The reCAPTCHA verification failed.']);
        }

        return 'success';
    }
}
