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
    $devices = Device::whereDoesntHave('users')->get();

    return view('admin.servicemen.show', compact('serviceman', 'devices'));
}


    public function assign(User $serviceman, Request $request)
{
    $deviceId = $request->device_id;

    if (!$serviceman->devices->contains($deviceId)) {
       
        $serviceman->devices()->attach($deviceId, ['assign_at' => now()]);

        \App\Models\DeviceAssignmentHistory::create([
            'device_id' => $deviceId,
            'user_id' => $serviceman->id,
            'assigned_by' => auth()->id(), 
            'assigned_at' => now(),
        ]);
    }

    return back()->with('success', 'Device assigned.');
}

    public function unassign(User $serviceman, Request $request)
{
    $deviceId = $request->device_id;

    $serviceman->devices()->detach($deviceId);

    \App\Models\DeviceAssignmentHistory::where('device_id', $deviceId)
        ->where('user_id', $serviceman->id)
        ->whereNull('unassigned_at')
        ->update(['unassigned_at' => now()]);

    return back()->with('success', 'Device unassigned.');
}

}
