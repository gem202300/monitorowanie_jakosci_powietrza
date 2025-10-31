<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Device;
use App\Enums\Auth\RoleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicemanController extends Controller
{
   public function index(Request $request)
{
    $query = User::role(RoleType::SERWISANT->value);

    if ($search = $request->input('search')) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $servicemen = $query->paginate(15);

    return view('admin.servicemen.index', compact('servicemen'));
}

    public function show(User $serviceman)
{
    // Вибираємо лише ті пристрої, які не мають жодного сервісанта
    $devices = Device::whereDoesntHave('users')->get();

    return view('admin.servicemen.show', compact('serviceman', 'devices'));
}


    public function assign(User $serviceman, Request $request)
    {
        if (!$serviceman->devices->contains($request->device_id)) {
            $serviceman->devices()->attach($request->device_id, ['assign_at' => now()]);
        }
        return back()->with('success', 'Device assigned.');
    }

    public function unassign(User $serviceman, Request $request)
    {
        $serviceman->devices()->detach($request->device_id);
        return back()->with('success', 'Device unassigned.');
    }
}
