<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Google_Client;
use Google_Service_Calendar;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $client = new Google_Client();
        $client->setAccessToken($googleUser->token);

        $client->addScope(Google_Service_Calendar::CALENDAR);

        if ($googleUser->token) {
            $client->fetchAccessTokenWithRefreshToken($googleUser->token);
            session(['google_access_token' => $client->getAccessToken()]);
        } else {
            return redirect()->route('login')->withErrors('Please log in again.');
        }

        $service = new Google_Service_Calendar($client);

        $requestId = time();

        $startTime = Carbon::now()->addMinutes(10);
        $endTime = $startTime->copy()->addMinutes(30);

        $event = new \Google_Service_Calendar_Event([
            'summary' => 'Private Google Meet Event',
            'location' => 'Online',
            'description' => 'A private meeting with Google Meet link',
            'start' => [
                'dateTime' => $startTime->toISOString(),
                'timeZone' => 'America/Los_Angeles',
            ],
            'creator' => [
                'displayName' => 'Vaishnavi K Shylaji',
                'email' => 'vaishnaviks199732@gmail.com',
            ],
            'organizer' => [
                'displayName' => 'Vaishnavi K Shylaji',
                'email' => 'vaishnaviks199732@gmail.com',
            ],
            'end' => [
                'dateTime' => $endTime->toISOString(),
                'timeZone' => 'America/Los_Angeles',
            ],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => $requestId,
                    'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet',
                    ],
                ],
            ],
            'attendees' => [
                [
                    'displayName' => 'Vaishnavi Hafees',
                    'email' => 'vaishnavihafees.workspace@gmail.com',
                    'responseStatus' => 'accepted',
                ],
            ],
        ]);

        $createdEvent = $service->events->insert('primary', $event, [
            'conferenceDataVersion' => 1,
        ]);


        $meetLink = $createdEvent->getHangoutLink();
        $conferenceData = $createdEvent->getConferenceData();

        $result = [
            'google_meet_link' => $meetLink,
            'conferenceData' => $conferenceData,
        ];

        return $meetLink;

    }

    public function test()
    {
        $keyFilePath = base_path(env('GOOGLE_AUTH_JSON'));
        $client = new Google_Client();
        $client->setAuthConfig($keyFilePath);
        $client->setAccessType( 'offline' );
        $client->setSubject(env('GOOGLE_ACCOUNT_MAIL'));
        $client->setApplicationName("Google Meet Integration");
        $client->setScopes([\Google_Service_Calendar::CALENDAR, \Google_Service_Calendar::CALENDAR_EVENTS]);

        $service = new Google_Service_Calendar($client);

        $randomPassword = Str::random(8);
        $requestId = Str::random(12);

        $startTime = Carbon::now()->addMinutes(10);
        $endTime = $startTime->copy()->addMinutes(30);

        $event = new \Google_Service_Calendar_Event([
            'summary' => 'Private Google Meet Event',
            'location' => 'Online',
            'description' => 'A private meeting with Google Meet link. Password: ' . $randomPassword,
            'start' => [
                'dateTime' => $startTime->toISOString(),
                'timeZone' => 'America/Los_Angeles',
            ],
            'end' => [
                'dateTime' => $endTime->toISOString(),
                'timeZone' => 'America/Los_Angeles',
            ],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => $requestId,
                    'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet',
                    ],
                ],
            ],
            'attendees' => [
                [
                    'displayName' => 'Vaishnavi Hafees',
                    'email' => 'vaishnavihafees.workspace@gmail.com',
                    'responseStatus' => 'accepted',
                ],
            ],
        ]);

        $createdEvent = $service->events->insert('primary', $event, [
            'conferenceDataVersion' => 1,
        ]);

        dd($createdEvent);
    }
}
