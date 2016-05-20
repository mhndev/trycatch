<?php

namespace mhndev\trycatch\Controllers;

use mhndev\NanoFramework\Http\Response;
use mhndev\NanoFramework\Ioc\Interfaces\iContainer;
use mhndev\NanoFrameworkSkeleton\Controllers\BaseController;
use mhndev\trycatch\Models\User;
use mhndev\trycatch\Repository\csv\UserRepository;
use mhndev\trycatch\ValueObjects\JsonApiPresenter;
use mhndev\trycatch\ValueObjects\ResponseMessages;
use mhndev\trycatch\ValueObjects\ResponseStatuses;

class UserController extends BaseController
{

    /**
     * @var UserRepository
     */
    protected $repository;


    /**
     * UserController constructor.
     * @param iContainer $container
     */
    public function __construct(iContainer $container)
    {
        parent::__construct($container);

        $this->repository = new UserRepository(new User(), 'test.csv', $container->get('csv'));
    }


    /**
     * @return Response
     */
    public function indexAction()
    {
        $users = $this->repository->all();

        return (new JsonApiPresenter())
            ->setData(['users'=>$users])
            ->setDataMainKey('users')
            ->setStatus(ResponseStatuses::SUCCESS)
            ->setStatusCode(200)
            ->toJsonResponse(new Response());
    }


    /**
     * @return Response
     */
    public function createAction()
    {
        $data = $this->request->getParsedBody();

        $user = $this->repository->create($data);

        return (new JsonApiPresenter())
            ->setData(['user'=>$user])
            ->setDataMainKey('user')
            ->setStatus(ResponseStatuses::SUCCESS)
            ->setStatusCode(200)
            ->toJsonResponse(new Response());
    }


    /**
     * @return Response
     */
    public function showAction()
    {
        $id = $this->request->getQueryParams()['id'];

        $user = $this->repository->findOneById($id);

        return (new JsonApiPresenter())
            ->setData(['user'=>$user])
            ->setDataMainKey('user')
            ->setStatus(ResponseStatuses::SUCCESS)
            ->setStatusCode(200)
            ->toJsonResponse(new Response());

    }


    /**
     * @return Response
     */
    public function deleteAction()
    {
        $id = $this->request->getQueryParams()['id'];

        $this->repository->deleteOneById($id);


        return (new JsonApiPresenter())
            ->setStatus(ResponseStatuses::SUCCESS)
            ->setStatusCode(200)
            ->setMessage(ResponseMessages::DELETED)
            ->toJsonResponse(new Response());
    }


    /**
     * @return Response
     */
    public function updateAction()
    {
        $id = $this->request->getQueryParams()['id'];
        $data = $this->request->getParsedBody();

        $user = $this->repository->updateOneById($id, $data);

        return (new JsonApiPresenter())
            ->setStatus(ResponseStatuses::SUCCESS)
            ->setStatusCode(200)
            ->setData(['user'=>$user])
            ->setDataMainKey('user')
            ->setMessage(ResponseMessages::UPDATED)
            ->toJsonResponse(new Response());
    }


    /**
     * @return Response
     */
    public function deleteBulkAction()
    {
        $this->repository->deleteManyByIds($this->request->getParsedBody()['ids']);


        return (new JsonApiPresenter())
            ->setStatus(ResponseStatuses::SUCCESS)
            ->setStatusCode(200)
            ->setMessage(ResponseMessages::DELETED)
            ->toJsonResponse(new Response());
    }
    

}
