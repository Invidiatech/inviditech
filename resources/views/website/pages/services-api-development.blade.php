@extends('website.layouts.app')
@section('title', 'API Development - InvidiaTech')
@section('meta_title', 'API Development Services')
@section('meta_description', 'Design and build secure REST APIs with Laravel and modern tooling.')
@section('meta_keywords', 'API Development, REST, Laravel, Backend, InvidiaTech')

@section('schema_markup')
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "API Development",
  "provider": {
    "@type": "Organization",
    "name": "InvidiaTech",
    "url": "{{ url('/') }}"
  },
  "areaServed": "Global",
  "serviceType": "API Engineering"
}
@endsection

@section('content')
<section class="page-header">
    <div class="page-header-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center animate">
                <h1 class="fw-bold mb-3">API Development</h1>
                <p class="lead">REST APIs engineered for performance, security, and easy integrations.</p>
                <a href="{{ route('contact') }}" class="btn btn-primary">Discuss Your API</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 animate">
                <h3 class="fw-bold">Deliverables</h3>
                <ul class="list-unstyled mt-3">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>RESTful API design</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>OAuth/JWT authentication</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Rate limiting & logging</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>API documentation</li>
                </ul>
            </div>
            <div class="col-lg-6 animate">
                <h3 class="fw-bold">Use Cases</h3>
                <p class="text-muted">Mobile apps, third‑party integrations, and backend services that need reliable data exchange.</p>
                <a href="{{ route('hire-us') }}" class="btn btn-outline-primary">Start a Project</a>
            </div>
        </div>
    </div>
</section>
@endsection
