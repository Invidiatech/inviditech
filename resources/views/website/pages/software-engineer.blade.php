@extends('website.layouts.app')
@section('title', 'Software Engineer - Muhammad Nawaz | InvidiaTech')
@section('meta_title', 'Software Engineer | Muhammad Nawaz')
@section('meta_description', 'Muhammad Nawaz is a full-stack software engineer specializing in Laravel, PHP, and modern web development. View skills, services, and projects.')
@section('meta_keywords', 'Software Engineer, Full Stack Developer, Laravel, PHP, JavaScript, InvidiaTech')

@section('schema_markup')
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "Muhammad Nawaz",
  "jobTitle": "Full Stack Software Engineer",
  "url": "{{ url('/software-engineer') }}",
  "image": "{{ asset('assets/profile/Muhammad Nawaz.jpg') }}",
  "worksFor": {
    "@type": "Organization",
    "name": "InvidiaTech",
    "url": "{{ url('/') }}"
  },
  "sameAs": [
    "https://www.linkedin.com/in/muhammad-nawaz-43a354201/",
    "https://github.com/nawazfdev",
    "https://www.facebook.com/Muhammad.Nawaz.Dev/"
  ]
}
@endsection

@section('content')
<section class="page-header">
    <div class="page-header-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center animate">
                <h1 class="fw-bold mb-3">Muhammad Nawaz</h1>
                <p class="lead mb-4">Full Stack Software Engineer specializing in Laravel, scalable APIs, and modern web experiences.</p>
                <a href="{{ route('contact') }}" class="btn btn-primary me-2">Hire Me</a>
                <a href="{{ route('cv') }}" class="btn btn-outline-light">View Resume</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5 animate">
                <img src="{{ asset('assets/profile/Muhammad Nawaz.jpg') }}" alt="Muhammad Nawaz" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-7 animate">
                <h2 class="fw-bold mb-3">Engineer focused on performance and clarity</h2>
                <p class="text-muted">I design and build robust web applications with Laravel, PHP 8+, and modern JavaScript frameworks. My focus is on clean architecture, optimized queries, and maintainable codebases that scale.</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <span class="badge bg-primary">Laravel</span>
                    <span class="badge bg-secondary">PHP</span>
                    <span class="badge bg-info">MySQL</span>
                    <span class="badge bg-dark">REST APIs</span>
                    <span class="badge bg-success">React</span>
                    <span class="badge bg-warning text-dark">Vue.js</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 animate">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold">Core Skills</h5>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Laravel & PHP Architecture</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>API Design & Integration</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Database Optimization</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Frontend Systems</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 animate">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold">What I Deliver</h5>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Scalable Laravel apps</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Secure authentication</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Performance boosts</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Code reviews & audits</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 animate">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold">Lets Collaborate</h5>
                        <p class="text-muted">Available for freelance and long-term projects. Let’s build reliable, elegant software.</p>
                        <a href="{{ route('hire-us') }}" class="btn btn-primary w-100">Start a Project</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
