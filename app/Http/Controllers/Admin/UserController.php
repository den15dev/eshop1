<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BaseRequest;
use App\Models\User;
use App\Services\Admin\ImageService as AdminImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public static function edit(string $id): View
    {
        $user = User::where('id', $id)
            ->with('orders:id,user_id,status')
            ->withCount('reviews')
            ->first();

        $current_user = Auth::user();

        return view('admin.users.edit', compact('user', 'current_user'));
    }


    public static function update(
        BaseRequest $request,
        int $id
    ) {
        $message = '';

        if ($request->has('role')) {
            if (Auth::user()->isBoss()) {
                $user = User::find($id);
                $user->role = $request->input('role');
                $user->save();

                $message = 'Пользователь ' . $user->name . ' (id: ' . $user->id . ')' . ' теперь ' . $user->role_str . '.';

            } else abort(403);
        }

        $request->flashMessage($message);

        return back();
    }


    public static function destroy(
        BaseRequest $request,
        AdminImageService $admImageService,
        int $id
    )
    {
        $user = User::find($id);
        $user->delete();
        if ($user->image) {
            $admImageService->deleteImageByName('users', $id, $user->image);
        }

        $request->flashMessage('Аккаунт ' . $user->name . ' (id: ' . $user->id . ')' . ' успешно удалён.');

        return redirect()->route('admin.users');
    }
}
