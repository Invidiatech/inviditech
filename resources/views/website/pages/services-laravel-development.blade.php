@extends('website.layouts.app')
@section('title', 'Laravel Development - InvidiaTech')
@section('meta_title', 'Laravel Development Services')
@section('meta_description', 'Custom Laravel development for scalable web apps, APIs, and backend systems.')
@section('meta_keywords', 'Laravel Development, PHP, API Development, InvidiaTech')

@section('schema_markup')
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Laravel Development",
  "provider": {
    "@type": "Organization",
    "name": "InvidiaTech",
    "url": "{{ url('/') }}"
  },
  "areaServed": "Global",
  "serviceType": "Web Development"
}
@endsection

@section('content')
<section class="page-header">
    <div class="page-header-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center animate">
                <h1 class="fw-bold mb-3">Laravel Development</h1>
                <p class="lead">Build secure, scalable Laravel applications with clean architecture and performance in mind.</p>
                <a href="{{ route('contact') }}" class="btn btn-primary">Request a Quote</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 animate">
                <h3 class="fw-bold">What’s Included</h3>
                <ul class="list-unstyled mt-3">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Custom Laravel applications</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Authentication & authorization</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Optimized database queries</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Testing and deployment</li>
                </ul>
            </div>
            <div class="col-lg-6 animate">
                <h3 class="fw-bold">Best For</h3>
                <p class="text-muted">Startups, SaaS platforms, and enterprise systems that need reliable backend architecture.</p>
                <a href="{{ route('hire-us') }}" class="btn btn-outline-primary">Start a Project</a>
            </div>
        </div>
    </div>
</section>
@endsection
