@extends('layouts.admin')

@section('title', 'Vehicles')
@section('page-title', 'All Vehicles')

@section('content')
  <div class="bg-white p-4 rounded shadow">
    <table class="w-full table-auto border-collapse">
      <thead>
        <tr class="bg-gray-100">
          <th class="px-4 py-2 text-left">#</th>
          <th class="px-4 py-2 text-left">Owner</th>
          <th class="px-4 py-2 text-left">Name</th>
          <th class="px-4 py-2 text-left">Plate</th>
          <th class="px-4 py-2 text-left">Type</th>
          <th class="px-4 py-2 text-left">Instant Enabled</th>
        </tr>
      </thead>
      <tbody>
        @forelse($vehicles as $vehicle)
          <tr class="border-b">
            <td class="px-4 py-2">{{ $loop->iteration }}</td>
            <td class="px-4 py-2">{{ $vehicle->user->name ?? '-' }}</td>
            <td class="px-4 py-2">{{ $vehicle->name }}</td>
            <td class="px-4 py-2">{{ $vehicle->plate_number }}</td>
            <td class="px-4 py-2">{{ ucfirst($vehicle->type) }}</td>
            <td class="px-4 py-2">{{ $vehicle->instant_enabled ? 'Yes' : 'No' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">No vehicles found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
