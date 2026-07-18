@extends('layouts.frontend')

@section('title', 'Frequently Asked Questions - Travels & Tours')
@section('meta_description', 'Find answers to frequently asked questions about booking, payments, tours, and travel with Travels & Tours.')

@section('content')

<section class="faq-hero">
    <div class="container text-center text-white">
        <h1 class="fw-bold display-5 mb-3">Frequently Asked Questions</h1>
        <p class="lead mb-4 text-white-50">Everything you need to know about booking and traveling with us</p>
        <form class="faq-search mx-auto d-flex" id="faqSearchForm">
            <input type="text" id="faqSearch" placeholder="Search FAQs..." autocomplete="off">
            <button type="submit" class="btn"><i class="bi bi-search me-1"></i>Search</button>
        </form>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="category-tabs mb-5" id="categoryTabs">
            <button class="category-tab active" data-category="all">All Questions</button>
            @foreach($categories as $category => $items)
                <button class="category-tab" data-category="{{ Str::slug($category) }}">{{ $category }}</button>
            @endforeach
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                @forelse($categories as $category => $faqs)
                    <div class="mb-5" data-category="{{ Str::slug($category) }}">
                        <div class="category-section-title">
                            <div class="icon-circle" style="background: var(--primary-color, #3c453e);">
                                @php $icons = ['Booking' => 'calendar-check', 'Payment' => 'credit-card', 'Tours' => 'compass', 'Travel' => 'globe2']; @endphp
                                <i class="bi bi-{{ $icons[$category] ?? 'question-circle' }}"></i>
                            </div>
                            <h3 class="fw-bold mb-0" style="color: var(--secondary-color, #181d2e);">{{ $category }}</h3>
                        </div>

                        <div class="faq-accordion accordion" id="accordion{{ Str::slug($category) }}">
                            @foreach($faqs as $index => $faq)
                                <div class="accordion-item faq-item" data-search="{{ Str::lower($faq->question . ' ' . $faq->answer) }}">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#faq{{ $faq->id }}"
                                                aria-expanded="false">
                                            {{ $faq->question }}
                                            <span class="category-badge">{{ $category }}</span>
                                        </button>
                                    </h2>
                                    <div id="faq{{ $faq->id }}" class="accordion-collapse collapse"
                                         data-bs-parent="#accordion{{ Str::slug($category) }}">
                                        <div class="accordion-body">
                                            {{ $faq->answer }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-question-circle" style="font-size: 3rem;"></i>
                        <p class="mt-3">No FAQs available at the moment. Please check back later.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container text-center">
        <h4 class="fw-bold mb-2" style="color: var(--secondary-color, #181d2e);">Still have questions?</h4>
        <p class="text-muted mb-4">We're here to help! Reach out to our support team.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('contact') }}" class="btn btn-primary rounded-pill px-5 py-3">
                <i class="bi bi-envelope me-2"></i>Contact Us
            </a>
            <a href="mailto:info@travels.com" class="btn btn-outline-primary rounded-pill px-5 py-3">
                <i class="bi bi-chat-dots me-2"></i>Live Chat
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('faqSearch');
    const categoryTabs = document.querySelectorAll('.category-tab');

    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            categoryTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const cat = this.dataset.category;
            document.querySelectorAll('[data-category]').forEach(el => {
                if (el.id === 'categoryTabs') return;
                if (cat === 'all') { el.style.display = 'block'; }
                else { el.style.display = el.dataset.category === cat ? 'block' : 'none'; }
            });
            searchInput.value = '';
            document.querySelectorAll('.faq-item').forEach(el => el.style.display = 'block');
        });
    });

    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('.faq-item').forEach(el => {
            const text = el.dataset.search || '';
            el.style.display = !q || text.includes(q) ? 'block' : 'none';
        });
        if (q) {
            categoryTabs.forEach(t => t.classList.remove('active'));
        } else {
            document.querySelector('.category-tab[data-category="all"]')?.classList.add('active');
        }
    });

    document.getElementById('faqSearchForm').addEventListener('submit', function (e) {
        e.preventDefault();
    });
});
</script>
@endpush