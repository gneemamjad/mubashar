<?php

namespace App\Services;

use App\Models\User;
use App\Repository\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    

    public function getDataTable()
    {
        return $this->userRepository->getDataTable();
    }

    public function toggleBlock($id)
    {
        return $this->userRepository->toggleBlock($id);
    }

    public function toggleActive($id)
    {
        return $this->userRepository->toggleActive($id);
    }
} 