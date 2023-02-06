<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Показывает список всех пользователей
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::query()->paginate(5);
        // foreach ($users->items() as $user) {
        //     dump($user->orders()->count());
        //     dump($user->name);
        // }
        // dump($orders);
        // dd($users);

        return view('admin.user.index', compact('users'));
    }

    /**
     * Показывает форму для редактирования пользователя
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Обновляет данные пользователя в базе данных
     *
     * @param Request $request
     * @param User    $user
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        //Проверяем данные формы
        $this->validator($request->all(), $user->id)->validate();
        //Обновляем пользователя
        if ($request->change_password) { // если надо изменить пароль
            $request->merge([ 'password' => Hash::make($request->password) ]);
            $user->update($request->all());
        } else {
            $user->update($request->except('password'));
        }

        //Возвращаемся к списку
        return redirect()->route('admin.user.index')->with('success', 'Данные пользователя успешно обновлены');
    }

    /**
     * Возвращает объект валидатора с нужными нам правилами
     *
     * @param array $data
     * @param int   $id
     * @return \Illuminate\Validation\Validator
     */
    private function validator(array $data, int $id): \Illuminate\Validation\Validator
    {
        $rules = [
            'name'  => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // проверка на уникальность email, исключая
                // этого пользователя по идентификатору
                'unique:users,email,' . $id . ',id',
            ],
        ];
        if (isset($data['change_password'])) {
            $rules['password'] = [ 'required', 'string', 'min:8', 'confirmed' ];
        }

        return Validator::make($data, $rules);
    }
}
