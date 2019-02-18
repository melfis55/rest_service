<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Adress;
use App\Country;
use App\City;
use App\Street;

use App\Http\Resources\User as UserResource;

class ApiController extends Controller
{

    public function show($firstname, $lastname)
    {
        $user = User::GetUser($firstname, $lastname);
        if (count($user) <= 0)
        {
            return response()->json([
                'status' => 204,
                'message' => 'User ' . $firstname . ' ' . $lastname . ' doesn\'t exist.',
            ], 200);
        }

        return UserResource::collection($user);
    }

    public function store(Request $request)  {

        $request->validate([
            'firstname'=>'required|string',
            'lastname'=> 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
        ]);

        $context = stream_context_create(
            array(
                "http" => array(
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                )
            )
        );

        $json = json_decode(file_get_contents('https://nominatim.openstreetmap.org/search/'.$request->input('street').'%20den%20'.$request->input('city').'%20den%20'.$request->input('country').'?format=json&addressdetails=1&limit=1&polygon_svg=1', false, $context));
        if (!count($json)){
            return response()->json([
                'status' => 406,
                'message' => 'Adress ' . $request->input('country') . ' ' . $request->input('city') . ' ' . $request->input('street') . ' ' . 'doesn\'t exist',
            ], 406);
        }

        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $user = User::GetUser($firstname, $lastname);

        if (count($user) >= 1)
        {
            return response()->json([
                'status' => 204,
                'message' => 'User ' . $firstname . ' ' . $lastname . ' already exists.',
            ], 200);
        }

        $country = new Country([
            'name' => $request->input('country')
        ]);
        $country->save();

        $city = new City([
            'name' => $request->input('city')
        ]);
        $city->save();

        $street = new Street([
            'name' => $request->input('street')
        ]);
        $street->save();

        $adress = new Adress([
            'country_id' => $country->id,
            'city_id' => $city->id,
            'street_id' => $street->id,
        ]);
        $adress->save();

        $user = new User([
            'firstname' => $request->input('firstname'),
            'lastname'=> $request->input('lastname'),
            'adress_id' => $adress->id,
        ]);

        if($user->save()) {
            return response()->json([
                'status' => 201,
                'message' => 'User ' . $firstname . ' ' . $lastname . ' was created.',
            ], 201);
        }

        return response()->json([
            'status' => 204,
            'message' => 'Something goes wrong',
        ], 200);
    }
}
