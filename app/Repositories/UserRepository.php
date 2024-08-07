<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class UserRepository
{
    /**
     * @param array $data
     * @param int|null $userId
     * @return LengthAwarePaginator
     */
    public function getItems(array $data): LengthAwarePaginator
    {
        return User::query()->paginate($data['perPage'] ?? null, ['*'], 'page', $data['page'] ?? null);
    }

    /**
     * @param array $data
     * @return User
     */
    public function storeItem(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    /**
     * @param User $note
     * @param array $data
     * @return User
     */
    public function updateItem(User $user, array $data): User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return $user->refresh();
    }


    /**
     * @param User $user
     * @return bool
     */
    public function destroyItem(User $user) :bool
    {
        try {
            $user->delete();
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
            return false;
        }

        return true;
    }

}
