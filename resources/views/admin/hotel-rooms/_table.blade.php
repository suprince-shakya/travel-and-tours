<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead><tr><th>#</th><th>Hotel</th><th>Room Type</th><th>Room Number</th><th>Capacity</th><th>Price/Night</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->hotel->name ?? 'N/A' }}</td>
                    <td class="fw-semibold">{{ ucfirst($room->room_type) }}</td>
                    <td>{{ $room->room_number ?? 'N/A' }}</td>
                    <td>{{ $room->capacity ?? 0 }}</td>
                    <td>${{ number_format($room->price_per_night ?? 0, 2) }}</td>
                    <td><span class="badge bg-{{ $room->status ? 'success' : 'secondary' }}">{{ $room->status ? 'Active' : 'Inactive' }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('admin.hotel-rooms.edit', $room->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.hotel-rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No rooms found</p></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="roomsPagination" class="d-flex justify-content-center mt-3">{{ $rooms->links() }}</div>
