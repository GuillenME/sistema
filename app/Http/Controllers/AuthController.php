<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Autenticar usuario
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['usuario' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', '¡Bienvenido!');
        }

        return back()->withErrors([
            'username' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('username');
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Guardar nuevo usuario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuarios,usuario',
            'password' => 'required|string|min:8|confirmed',
            'puesto' => 'required|string|max:255',
            'roles_id' => 'required|integer|exists:roles,id',
        ]);

        $userData = [
            'nombre' => $validated['name'],
            'usuario' => $validated['username'],
            'contrasena' => Hash::make($validated['password']),
            'puesto' => $validated['puesto'],
            'roles_id' => $validated['roles_id'],
        ];

        User::create($userData);

        return redirect('/login')->with('success', '¡Registro exitoso! Por favor inicia sesión.');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}
