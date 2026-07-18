@extends('layouts.customer')

@section('title', 'My Wishlist - Travels & Tours')

@section('page-title', 'My Wishlist')
@section('page-subtitle', 'Tours you\'ve saved for later')

@section('customer-content')
@if($wishlists->count() > 0)
    <div class="row g-4">
        @foreach($wishlists as $wishlist)
            <div class="col-lg-4 col-md-6">
                <div class="position-relative">
                    @component('components.tour-card', ['tour' => $wishlist->tour])
                    @endcomponent
                    <button class="btn btn-sm btn-outline-danger rounded-pill mt-2 w-100 remove-wishlist" data-id="{{ $wishlist->tour_id }}">
                        <i class="bi bi-heartbreak me-1"></i>Remove from Wishlist
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="bi bi-heart fs-1 text-muted mb-3 d-block"></i>
        <h5 class="fw-bold">Your Wishlist is Empty</h5>
        <p class="text-muted mb-3">Save tours you love to your wishlist for easy booking later.</p>
        <a href="{{ route('tours.index') }}" class="btn btn-primary rounded-pill px-4">Browse Tours</a>
    </div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-wishlist').forEach(btn => {
        btn.addEventListener('click', function() {
            const tourId = this.dataset.id;
            const card = this.closest('.col-lg-4');
            fetch('/customer/wishlist/toggle/' + tourId, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            }).then(r => r.json()).then(() => {
                card.style.transition = 'opacity 0.3s';
                card.style.opacity = '0';
                setTimeout(() => { window.location.reload(); }, 300);
            });
        });
    });
});
</script>
@endpush
