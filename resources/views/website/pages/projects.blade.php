@extends('website.layouts.app')
@section('title', 'Projects - InvidiaTech')
@section('meta_title', 'Projects & Portfolio - InvidiaTech')
@section('meta_description', 'Browse selected web development projects delivered with Laravel, PHP, and modern JavaScript frameworks.')
@section('meta_keywords', 'Projects, Portfolio, Laravel, PHP, React, InvidiaTech')

@section('content')
<section class="page-header">
    <div class="page-header-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center animate">
                <h1 class="fw-bold mb-3">Projects & Portfolio</h1>
                <p class="lead">Selected work across web apps, APIs, and admin systems.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 animate">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold">Multi-tenant SaaS Platform</h5>
                        <p class="text-muted">Designed scalable tenancy with role-based access and billing automation.</p>
                        <span class="badge bg-primary">Laravel</span>
                        <span class="badge bg-secondary">MySQL</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 animate">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold">Real-time Analytics Dashboard</h5>
                        <p class="text-muted">Built interactive dashboards with optimized queries and caching.</p>
                        <span class="badge bg-info">API</span>
                        <span class="badge bg-dark">Performance</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 animate">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold">E-commerce Backend</h5>
                        <p class="text-muted">Implemented order flow, inventory management, and webhook integrations.</p>
                        <span class="badge bg-success">Laravel</span>
                        <span class="badge bg-warning text-dark">Stripe</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 animate">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold">Content Publishing System</h5>
                        <p class="text-muted">Created SEO-ready publishing workflows and analytics.</p>
                        <span class="badge bg-primary">SEO</span>
                        <span class="badge bg-secondary">Blade</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
