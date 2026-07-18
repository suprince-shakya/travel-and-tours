<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr><th>#</th><th>User</th><th>Tour</th><th>Rating</th><th>Review</th><th>Status</th><th>Verified</th><th class="text-end">Actions</th></tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->user_name ?? $review->user->name ?? 'Anonymous' }}</td>
                    <td>{{ $review->tour_name ?? $review->tour->title ?? 'N/A' }}</td>
                    <td><span class="stars">@for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$review->rating ? '-fill' : '' }}"></i>@endfor</span></td>
                    <td><div class="review-excerpt">{{ $review->comment ?? $review->review ?? '' }}</div></td>
                    <td>
                        @php $rs = $review->status ?? 'pending'; $rb = match($rs) {'approved'=>'badge-soft-success','rejected'=>'badge-soft-danger',default=>'badge-soft-warning'}; @endphp
                        <span class="badge {{ $rb }}">{{ ucfirst($rs) }}</span>
                    </td>
                    <td>@if($review->verified)<span class="badge bg-success"><i class="bi bi-check-circle"></i> Verified</span>@else<span class="badge bg-light text-muted">No</span>@endif</td>
                    <td class="text-end">
                        @if($review->status !== 'approved')
                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button type="submit" class="btn btn-sm btn-outline-success" title="Approve"><i class="bi bi-check-lg"></i></button></form>
                        @endif
                        @if($review->status !== 'rejected')
                            <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button type="submit" class="btn btn-sm btn-outline-warning" title="Reject"><i class="bi bi-x-lg"></i></button></form>
                        @endif
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox" style="font-size:2rem;"></i><p class="mt-2 mb-0">No reviews found</p></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center mt-3" id="reviewsPagination">
    {{ $reviews->links() }}
</div>
