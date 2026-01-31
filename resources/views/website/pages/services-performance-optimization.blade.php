@extends('website.layouts.app')
@section('title', 'Performance Optimization - InvidiaTech')
@section('meta_title', 'Performance Optimization Services')
@section('meta_description', 'Improve speed, scalability, and reliability through database and application optimization.')
@section('meta_keywords', 'Performance Optimization, Laravel, Database Tuning, InvidiaTech')

@section('schema_markup')
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Performance Optimization",
  "provider": {
    "@type": "Organization",
    "name": "InvidiaTech",
    "url": "{{ url('/') }}"
  },
  "areaServed": "Global",
  "serviceType": "Performance Optimization"
}
@endsection

@section('content')
<section class="page-header">
    <div class="page-header-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center animate">
                <h1 class="fw-bold mb-3">Performance Optimization</h1>
                <p class="lead">Reduce load times and improve throughput with practical optimization strategies.</p>
                <a href="{{ route('contact') }}" class="btn btn-primary">Optimize My App</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 animate">
                <h3 class="fw-bold">Optimization Focus</h3>
                <ul class="list-unstyled mt-3">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Database query tuning</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Caching strategies</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Queue and worker performance</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Infrastructure review</li>
                </ul>
            </div>
            <div class="col-lg-6 animate">
                <h3 class="fw-bold">Outcome</h3>
                <p class="text-muted">Faster pages, efficient APIs, and better user experience across devices.</p>
                <a href="{{ route('hire-us') }}" class="btn btn-outline-primary">Start a Project</a>
            </div>
        </div>
    </div>
</section>
@endsection
