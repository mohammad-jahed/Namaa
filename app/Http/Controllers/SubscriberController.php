<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SubscribeRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubscriberController extends Controller
{

    public function index(): JsonResponse
    {
        $subscribers = User::query()->paginate(10);

        if ($subscribers->isEmpty()) {

            return $this->getJsonResponse(null, "There Are No Subscribers Found!");
        }

        return $this->getJsonResponse($subscribers, "Subscribers Fetched Successfully");
    }


    public function subscribe(SubscribeRequest $request): JsonResponse
    {

        try {
            $credentials = $request->validated();

            DB::beginTransaction();

            $credentials['password'] = Hash::make($credentials['password']);

            /**
             * @var User $user ;
             */
            $user = User::query()->create($credentials);

            $success[] = $user;

            $success['token'] =  $user->createToken('Auth')->plainTextToken;

            DB::commit();

            return $this->getJsonResponse($success, "User Registered Successfully");

        }
        catch (Exception $exception)
        {
            DB::rollBack();

            return $this->getJsonResponse($exception->getMessage(), "Something Went Wrong!!", 0);

        }
    }


    public function login(LoginRequest $request)//: JsonResponse
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            /**
             * @var User $user ;
             */
            $user = Auth::user();

            $success['token'] = $user->createToken('Auth')->plainTextToken;

            if ($user && $user->first_login != 1) {
                $deviceIdentifier = $user->device_identifier;
                $cookieIdentifier = $request->cookie('device_identifier');

                if ($deviceIdentifier !== $cookieIdentifier) {
                    auth()->logout();
                    return $this->getJsonResponse(null, "You can only login from your first device.");
                }
            }

            if ($user->first_login == 1) {
                $deviceIdentifier = $this->generateUniqueDeviceIdentifier(now(), $request->server('HTTP_USER_AGENT'));
                $user->update([
                    'device_identifier' => $deviceIdentifier,
                    'first_login' => 0
                ]);

                return $this->getJsonResponse($success, 'User Login Successfully.')
                    ->withCookie(cookie()->forever('device_identifier', $deviceIdentifier));
            }

                return $this->getJsonResponse($success, 'User Login Successfully.');
            } else {
                return $this->getJsonResponse('Unauthorised', 'Wrong username or password');
            }
    }

    public function generateUniqueDeviceIdentifier($timestamp, $userAgent): string
    {
        $combinedString = $timestamp . $userAgent;

        return hash('sha256', $combinedString);
    }


    public function show(User $user): JsonResponse
    {
//        dd("sss");
        return $this->getJsonResponse($user, "User Fetched Successfully");
    }



    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->validated();

        $user->update($data);

        return $this->getJsonResponse($user, "User Updated Successfully");
    }


    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->getJsonResponse(null, "User Deleted Successfully");
    }
}
