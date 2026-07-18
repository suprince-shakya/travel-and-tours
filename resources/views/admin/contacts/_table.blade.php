<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Subject</th><th>Status</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
            @forelse($contacts as $contact)
                <tr class="{{ $contact->status === 'unread' ? 'fw-bold' : '' }}">
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ Str::limit($contact->subject, 40) }}</td>
                    <td>
                        @php $cs = $contact->status ?? 'unread'; $cb = match($cs) {'read'=>'badge-soft-info','replied'=>'badge-soft-success',default=>'badge-soft-warning'}; @endphp
                        <span class="badge {{ $cb }}">{{ ucfirst($cs) }}</span>
                    </td>
                    <td>{{ $contact->created_at ? $contact->created_at->format('M d, Y') : 'N/A' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No inquiries found</p></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div id="contactsPagination" class="d-flex justify-content-center mt-3">{{ $contacts->links() }}</div>
