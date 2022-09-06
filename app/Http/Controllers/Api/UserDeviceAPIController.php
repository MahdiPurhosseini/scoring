<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Api\Eloquent\UserDeviceRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class UserDeviceAPIController extends Controller
{
    /** @var UserDeviceRepository */
    public UserDeviceRepository $userDeviceRepo;

    /**
     * UserDeviceAPIController constructor.
     * @param  UserDeviceRepository  $userDeviceRepo
     */
    public function __construct(UserDeviceRepository $userDeviceRepo)
    {
        $this->userDeviceRepo = $userDeviceRepo;
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function registerDevice(Request $request): JsonResponse
    {
        $this->userDeviceRepo->updateOrCreate($request->all());

        return $this->sendSuccess('The device has been registered successfully.');
    }

    /**
     * @param $playerId
     * @return JsonResponse
     */
    public function updateNotificationStatus($playerId): JsonResponse
    {
        $this->userDeviceRepo->updateStatus($playerId);

        return $this->sendSuccess('The notification status has been updated successfully.');
    }

    /**
     * @param $message
     * @return JsonResponse
     */
    private function sendSuccess($message): JsonResponse
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
