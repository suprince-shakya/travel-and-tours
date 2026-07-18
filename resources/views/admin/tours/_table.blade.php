<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>Category</th>
                <th>Country</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Difficulty</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Popular</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody id="toursTableBody">
            @forelse($tours as $tour)
                <tr>
                    <td>{{ $tour->id }}</td>
                    <td>
                        @if($tour->thumbnail)
                            <img src="{{ storage_url($tour->thumbnail) }}" alt="{{ $tour->title }}" class="rounded" width="50" height="35" style="object-fit: cover;">
                        @else
                            <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:50px;height:35px;">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $tour->title }}</td>
                    <td>{{ $tour->category->name ?? 'N/A' }}</td>
                    <td>{{ $tour->country->name ?? 'N/A' }}</td>
                    <td>${{ number_format($tour->price, 2) }}</td>
                    <td>{{ $tour->duration }} {{ $tour->duration_unit ?? 'days' }}</td>
                    <td>
                        @php
                            $diffBadge = match($tour->difficulty) {
                                'easy' => 'success',
                                'moderate' => 'info',
                                'challenging' => 'warning',
                                'difficult' => 'danger',
                                'extreme' => 'dark',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $diffBadge }}">{{ ucfirst($tour->difficulty) }}</span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $tour->status ? 'success' : 'secondary' }}">
                            {{ $tour->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        @if($tour->featured)
                            <span class="badge bg-warning text-dark"><i class="bi bi-star-fill"></i> Featured</span>
                        @else
                            <span class="badge bg-light text-muted">No</span>
                        @endif
                    </td>
                    <td>
                        @if($tour->popular)
                            <span class="badge bg-danger"><i class="bi bi-fire"></i> Popular</span>
                        @else
                            <span class="badge bg-light text-muted">No</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.tours.edit', $tour->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this tour?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-0">No tours found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center mt-3" id="toursPagination">
    {{ $tours->links() }}
</div>