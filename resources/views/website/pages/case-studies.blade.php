@extends('website.layouts.app')
@section('title', 'Case Studies - InvidiaTech')
@section('meta_title', 'Case Studies - InvidiaTech')
@section('meta_description', 'Explore case studies showcasing Laravel development, API optimization, and performance improvements delivered by InvidiaTech.')
@section('meta_keywords', 'Case Studies, Laravel Projects, API Optimization, Performance, InvidiaTech')

@section('content')
<section class="page-header">
    <div class="page-header-pattern"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center animate">
                <h1 class="fw-bold mb-3">Case Studies</h1>
                <p class="lead">Real-world projects with measurable results.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 animate">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold">Marketplace API Optimization</h5>
                        <p class="text-muted">Reduced average API response time by 62% and improved checkout throughput.</p>
                        <ul class="list-unstyled small text-muted mb-0">
                            <li>Stack: Laravel, MySQL, Redis</li>
                            <li>Focus: Caching, query tuning</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 animate">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold">SaaS Dashboard Rebuild</h5>
                        <p class="text-muted">Unified legacy systems into a modern admin platform with clean UX.</p>
                        <ul class="list-unstyled small text-muted mb-0">
                            <li>Stack: Laravel, Vue.js</li>
                            <li>Focus: Modular UI, auth</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 animate">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold">Content Platform SEO Boost</h5>
                        <p class="text-muted">Implemented structured data and on-page SEO leading to 3x organic traffic.</p>
                        <ul class="list-unstyled small text-muted mb-0">
                            <li>Stack: Laravel, Blade</li>
                            <li>Focus: SEO + schema</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
