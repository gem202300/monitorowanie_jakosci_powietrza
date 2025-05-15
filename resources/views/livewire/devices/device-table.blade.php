<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Coordinates</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($devices as $device)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $device->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $device->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $device->status }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $device->address }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $device->latitude }}, {{ $device->longitude }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
