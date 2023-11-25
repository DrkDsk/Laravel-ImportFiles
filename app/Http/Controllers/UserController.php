<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Brand;
use App\Models\User;
use App\Services\BrandService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct(protected readonly BrandService $brandService)
    {
        $this->authorizeResource(User::class);
    }

    public function index() : Response
    {
        return Inertia::render('Dashboard/Users/Index', [
            "users" => User::with('roles')->get()
        ]);
    }

    public function store(UserCreateRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $this->brandService->create($user, $request->validated('brand'));
        $user->assignRole($request->role);

        return redirect()->route('dashboard.users.index');
    }

    public function create() :  Response
    {
        return Inertia::render('Dashboard/Users/Create', [
            "roles" => Role::all(),
            "brands" => Brand::all()
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->brandService->create($user, $request->validated('brand'));
        $user->roles()->detach();
        $user->update($request->validated());
        $user->assignRole($request->validated()["role"]);
        return redirect()->route("dashboard.users.index");
    }

    public function edit(User $user) : Response
    {
        $userBrands = $user->brands->map(function ($userBrand) {
            return $userBrand->brand;
        });

        return Inertia::render('Dashboard/Users/Edit', [
            "user" => $user,
            "roles" => Role::all(),
            "brands" => Brand::all(),
            "userBrands" => $userBrands,
            "userRole"  => $user->roles[0]
        ]);
    }
}
