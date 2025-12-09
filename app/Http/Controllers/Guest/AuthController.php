<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

/**
 * Auth Controller
 *
 * Handles all authentication related functionality including login, registration,
 * and logout processes. Supports both web and API requests for future mobile app integration.
 *
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('guest.auth.modern-login');
    }

    /**
     * Handle login request
     *
     * Authenticates users and redirects them based on their role.
     * Also supports API authentication for mobile applications.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            // Validate input data
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Attempt authentication
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();

                // Get authenticated user
                $user = Auth::user();
                $userRole = strtoupper($user->role);

                // API response for mobile app
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'user' => $user,
                        'role' => $userRole,
                        // Note: Token-based authentication requires Laravel Sanctum
                        // 'token' => $user->createToken('auth_token')->plainTextToken
                    ]);
                }

                // Web response - redirect based on user role with success message
                if ($userRole === 'ADMIN') {
                    return redirect()->route('admin.dashboard')
                        ->with('success', 'Selamat datang kembali, Admin! Anda telah berjaya log masuk.');
                } elseif ($userRole === 'PROVIDER') {
                    return redirect()->route('provider.dashboard')
                        ->with('success', 'Selamat datang kembali, Provider! Anda telah berjaya log masuk.');
                } else {
                    // Default redirect for customers and other roles
                    return redirect()->route('home')
                        ->with('success', 'Selamat datang kembali! Anda telah berjaya log masuk.');
                }
            }

            // Failed authentication
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            return back()->withErrors([
                'email' => 'Maklumat log masuk yang diberikan tidak sepadan dengan rekod kami.',
            ])->with('error', 'Log masuk gagal. Sila semak e-mel dan kata laluan anda.');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication failed',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'error' => 'Ralat berlaku semasa log masuk. Sila cuba lagi.'
            ])->with('error', 'Ralat sistem. Sila cuba lagi sebentar lagi.');
        }
    }

    /**
     * Show the registration form
     *
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        return view('guest.auth.register');
    }

    /**
     * Handle registration request
     *
     * Creates a new user account. Supports both web and API requests.
     * Converted from Livewire to traditional controller method.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            // Validate input data with enhanced validation messages
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'username' => 'nullable|string|max:255|unique:users|alpha_dash',
                'password' => 'required|string|min:8|confirmed',
                'terms' => 'accepted',
            ], [
                'name.required' => 'Sila masukkan nama penuh anda.',
                'email.required' => 'Sila masukkan alamat e-mel anda.',
                'email.email' => 'Sila masukkan alamat e-mel yang sah.',
                'email.unique' => 'Alamat e-mel ini telah digunakan.',
                'username.unique' => 'Nama pengguna ini telah digunakan.',
                'username.alpha_dash' => 'Nama pengguna hanya boleh mengandungi huruf, nombor, tanda sengkang dan garis bawah.',
                'password.required' => 'Sila masukkan kata laluan.',
                'password.min' => 'Kata laluan mestilah sekurang-kurangnya 8 aksara.',
                'password.confirmed' => 'Pengesahan kata laluan tidak sepadan.',
                'terms.accepted' => 'Anda mesti bersetuju dengan terma perkhidmatan kami.',
            ]);

            if ($validator->fails()) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()
                    ], 422);
                }

                return back()->withErrors($validator)->withInput();
            }

            // Generate username from email if not provided
            $username = $request->username;
            if (empty($username)) {
                $emailParts = explode('@', $request->email);
                $baseUsername = $emailParts[0];

                // Make it unique by adding random characters if needed
                $username = $baseUsername;
                $counter = 0;

                // Check if username exists and add random string if needed
                while (User::where('username', $username)->exists()) {
                    $counter++;
                    $username = $baseUsername . Str::random(3) . $counter;
                }
            }

            // Additional check if email already exists (defensive programming)
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return back()->withErrors([
                    'email' => 'Alamat e-mel ini telah digunakan.'
                ])->withInput();
            }

            // Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $username,
                'password' => Hash::make($request->password),
                'role' => 'CUSTOMER',
            ]);

            // API response for mobile app
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful',
                    'user' => $user,
                    // Note: Token-based authentication requires Laravel Sanctum
                    // 'token' => $user->createToken('auth_token')->plainTextToken
                ]);
            }

            // Web response with success message
            return redirect()->route('login')->with('success', 'Pendaftaran berjaya! Sila log masuk dengan akaun anda.');

        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration failed',
                    'error' => $e->getMessage()
                ], 500);
            }

            return back()->withErrors([
                'general' => 'Ralat semasa pendaftaran. Sila cuba lagi.'
            ])->withInput();
        }
    }

    /**
     * Display the password reset request form.
     *
     * @return \Illuminate\View\View
     */
    public function showForgotPasswordForm()
    {
        return view('guest.auth.passwords.email');
    }

    /**
     * Handle sending a password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset form.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetPasswordForm(string $token)
    {
        return view('guest.auth.passwords.reset', [
            'token' => $token,
            'email' => request('email')
        ]);
    }

    /**
     * Handle resetting the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Kata laluan anda berjaya ditetapkan semula. Sila log masuk.');
        }

        return back()->withErrors([
            'email' => [__($status)]
        ]);
    }

    /**
     * Handle logout request
     *
     * Logs out the user and invalidates their session.
     * Also supports API logout for mobile applications.
     *
     * @param Request $request The incoming request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            // For API requests
            if ($request->wantsJson()) {
                // Note: Token revocation requires Laravel Sanctum
                // if ($request->user()) {
                //     $request->user()->currentAccessToken()->delete();
                // }

                return response()->json([
                    'success' => true,
                    'message' => 'Logged out successfully'
                ]);
            }

            // For web requests
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        } catch (\Exception $e) {
            // Error handling
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Logout failed',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect('/');
        }
    }
}
