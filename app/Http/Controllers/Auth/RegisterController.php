<?php

namespace App\Http\Controllers\Auth;

use App\Actions\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterUserResource;
use App\Models\User;
use App\Models\UserInterest;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    use ResponseTrait;
    public function __invoke(RegisterRequest $request, CreateUserAction $action)
    {
        // create user
        $user = $action->execute($request->validated());

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;
            return $this->success(
                'Successfully created user!',
                $user->toResource(RegisterUserResource::class),
                Response::HTTP_CREATED
            );
        } else {
            return $this->serverError('Failed to create user.');
        }
    }
}
