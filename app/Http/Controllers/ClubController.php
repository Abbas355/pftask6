<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClubRequest;
use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function add(ClubRequest $request)
    {
        $data = $request->only([
            'user_id', 'club_name', 'address', 'established_date', 'website',
            'contact_email', 'phone_number', 'sport_id', 'description',
            'no_of_players', 'no_of_coaches', 'club_img'
        ]);

        $club = Club::create($data);

        return response()->pfResponce($club, true);
    }

    public function update(Request $request, $id)
    {
        $club = Club::find($id);

        if ($club) {
            $fillableAttributes = [
                'user_id', 'club_name', 'address', 'established_date', 'website',
                'contact_email', 'phone_number', 'sport_id', 'description',
                'no_of_players', 'no_of_coaches', 'club_img'
            ];

            foreach ($fillableAttributes as $attribute) {
                if ($request->filled($attribute)) {
                    $club->$attribute = $request->input($attribute);
                }
            }

            $club->save();

            return response()->pfResponce($club, true);
        }

        return response()->pfResponce('Club not found', false);
    }

    public function delete(Request $request, $id)
    {
        $club = Club::find($id);

        if ($club) {
            $club->delete();
            return response()->pfResponce('Club deleted successfully', true);
        }

        return response()->pfResponce('Club not found', false);
    }

    public function list(?int $id = null)
    {
        if ($id) {
            $club = Club::with(['certificates', 'licences', 'awards'])->find($id);
        } else {
            $club = Club::with(['certificates', 'licences', 'awards'])->get();
        }

        if ($club) {
            return response()->pfResponce($club, true);
        }

        return response()->pfResponce('Club not found', false);
    }
}
