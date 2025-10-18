<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use App\Models\Vehicle;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:Pasajero,Conductor'],
        ];

        // Si es conductor, validamos también los datos del vehículo
        if (isset($data['role']) && $data['role'] === 'Conductor') {
            $rules['vehicles.*.plate'] = ['required', 'string', 'max:10'];
            $rules['vehicles.*.brand'] = ['required', 'string', 'max:255'];
            $rules['vehicles.*.model'] = ['required', 'string', 'max:255'];
            $rules['vehicles.*.color'] = ['nullable', 'string', 'max:50'];
        }

        return Validator::make($data, $rules);
    }

    protected function create(array $data)
    {
        return DB::transaction(function() use ($data) {
            // Crear usuario
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Asignar rol
            $role = Role::where('name', $data['role'])->first();
            $user->roles()->attach($role);

            // Si es conductor, crear vehículos
            if ($data['role'] === 'Conductor' && isset($data['vehicles'])) {
                foreach ($data['vehicles'] as $v) {
                    $user->vehicles()->create([
                        'plate' => $v['plate'],
                        'brand' => $v['brand'],
                        'model' => $v['model'],
                        'color' => $v['color'] ?? null,
                    ]);
                }
            }

            return $user;
        });
    }
}
