<?php

namespace mhndev\trycatch;

use mhndev\NanoFramework\Http\Interfaces\iResponse;
use mhndev\NanoFramework\Http\Response;
use mhndev\NanoFramework\Router\Exceptions\RouteNotFound;
use mhndev\NanoFrameworkSkeleton\Exceptions\ModelNotFound;
use mhndev\trycatch\ValueObjects\JsonApiPresenter;
use mhndev\trycatch\ValueObjects\ResponseStatuses;

class handler
{

    /**
     * @param \Exception $e
     * @param iResponse $response
     * @return mixed
     */
    public function render(\Exception $e, $response)
    {
        if ($e instanceof  ModelNotFound) {

            return ((new JsonApiPresenter())
                ->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->setStatus(ResponseStatuses::ERROR)
                ->setMessage('not found')
                ->toJsonResponse($response));
        }

        elseif ($e instanceof RouteNotFound){

            return ((new JsonApiPresenter())
                ->setStatusCode(Response::HTTP_NOT_FOUND)
                ->setStatus(ResponseStatuses::ERROR)
                ->setMessage('not found')
                ->toJsonResponse($response));
        }

        else{

            //log error
        }

    }

}
