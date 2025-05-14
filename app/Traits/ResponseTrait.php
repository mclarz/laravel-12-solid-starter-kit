<?php

namespace App\Traits;

trait ResponseTrait
{
    /**
     * Send a success response.
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($message = 'Success', $data = null, $code = 200)
    {
        $result = [];

        if ($message) {
            $result['message'] = $message;
        }

        if ($data) {
            $result['data'] = $data;
        }

        return response()->json($result, $code);
    }

    /**
     * unauthorized response.
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthorized($message = 'Unauthorized', $data = null)
    {
        return $this->error($message, $data, 401);
    }

    /**
     * Send a 422 error response.
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unprocessable($message = 'Unprocessable Entity', $data = null)
    {
        return $this->error($message, $data, 422);
    }

    /**
     * Send a 400 error response.
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message = 'Bad Request', $data = null)
    {
        return $this->error($message, $data, 400);
    }

    /**
     * Send a 500 error response.
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function serverError($message = 'Server Error', $data = null)
    {
        return $this->error($message, $data, 500);
    }

    /**
     * Send a forbidden response.
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function forbidden($message = 'Forbidden', $data = null)
    {
        return $this->error($message, $data, 403);
    }

    /**
     * Send a created response.
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function created($message = 'Created', $data = null)
    {
        return $this->success($message, $data, 201);
    }

    /**
     * Send an error response.
     *
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function notFound($message = 'Not Found', $data = null)
    {
        return $this->error($message, $data, 404);
    }

    /**
     * Send an error response.
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message = 'Error', $data = null, $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
