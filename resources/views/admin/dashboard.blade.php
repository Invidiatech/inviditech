 @extends('layouts.admin.master')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

    <!-- Alert Box -->
    <div id="alertBox" class="alert alert-danger align-items-center gap-1 justify-content-between mb-3" role="alert" style="display: flex">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-bell"></i>
            <div>
                <strong>Note</strong> This is a demo dashboard for testing purposes.
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Featured Blog Post Alert -->
    <div>
        <div class="alert flash-deal-alert d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex flex-column">
                <div class="deal-text">Latest Tech Trends 2025</div>
                <div class="deal-title">Featured Blog Post</div>
            </div>
            <div class="countdown d-flex align-items-center">
                <!-- Days -->
                <div class="countdown-section">
                    <div class="countdown-label">Days</div>
                    <div id="days" class="countdown-time">03</div>
                </div>
                <!-- Hours -->
                <div class="countdown-section">
                    <div class="countdown-label">Hours</div>
                    <div id="hours" class="countdown-time">10</div>
                </div>
                <!-- Minutes -->
                <div class="countdown-section">
                    <div class="countdown-label">Minutes</div>
                    <div id="minutes" class="countdown-time">45</div>
                </div>
                <!-- Seconds -->
                <div class="countdown-section">
                    <div class="countdown-label">Seconds</div>
                    <div id="seconds" class="countdown-time">20</div>
                </div>
            </div>
            <a href="#" class="btn btn-primary py-2.5 addBtn">
                Read Now
            </a>
        </div>
    </div>
    <!-- End Featured Blog Post Alert -->

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="dashboard-box item-1">
                        <h2 class="count">15</h2>
                        <h3 class="title">Total Services</h3>
                        <div class="icon">
                            <img src="assets/icons-admin/service-icon.svg" alt="icon" loading="lazy" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="dashboard-box item-2">
                        <h2 class="count">50</h2>
                        <h3 class="title">Blog Posts</h3>
                        <div class="icon">
                            <img src="assets/icons-admin/blog-icon.svg" alt="icon" loading="lazy" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="dashboard-box item-3">
                        <h2 class="count">120</h2>
                        <h3 class="title">Client Inquiries</h3>
                        <div class="icon">
                            <img src="assets/icons-admin/inquiry-icon.svg" alt="icon" loading="lazy" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="dashboard-box item-4">
                        <h2 class="count">25</h2>
                        <h3 class="title">Countries Served</h3>
                        <div class="icon">
                            <img src="assets/icons-admin/globe-icon.svg" alt="icon" loading="lazy" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---- Inquiry Status -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="cardTitleBox">
                <h5 class="card-title chartTitle">
                    Inquiry Status
                </h5>
            </div>

            <div class="d-flex flex-wrap gap-3 orderStatus">
                <a href="#" class="d-flex status flex-grow-1 pending">
                    <div class="d-flex align-items-center gap-2 justify-content-between w-100">
                        <div class="d-flex align-items-center gap-2">
                            <img src="assets/icons-admin/clock.svg" alt="icon" loading="lazy" />
                            <span>Pending</span>
                        </div>
                        <div class="icon">
                            <img src="assets/icons-admin/arrow-export.svg" alt="icon" loading="lazy" />
                        </div>
                    </div>
                    <span class="count">30</span>
                </a>
                <a href="#" class="d-flex status flex-grow-1 inProgress">
                    <div class="d-flex align-items-center gap-2 justify-content-between w-100">
                        <div class="d-flex align-items-center gap-2">
                            <img src="assets/icons-admin/rotate-circle.svg" alt="icon" loading="lazy" />
                            <span>In Progress</span>
                        </div>
                        <div class="icon">
                            <img src="assets/icons-admin/arrow-export.svg" alt="icon" loading="lazy" />
                        </div>
                    </div>
                    <span class="count">40</span>
                </a>
                <a href="#" class="d-flex status flex-grow-1 completed">
                    <div class="d-flex align-items-center gap-2 justify-content-between w-100">
                        <div class="d-flex align-items-center gap-2">
                            <img src="assets/icons-admin/box-check.svg" alt="icon" loading="lazy" />
                            <span>Completed</span>
                        </div>
                        <div class="icon">
                            <img src="assets/icons-admin/arrow-export.svg" alt="icon" loading="lazy" />
                        </div>
                    </div>
                    <span class="count">50</span>
                </a>
            </div>
        </div>
    </div>

    <!---- Agency Revenue -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="cardTitleBox">
                <h5 class="card-title chartTitle">
                    Agency Revenue
                </h5>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <div class="wallet h-100">
                        <h3 class="balance">$25,000.00</h3>
                        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap w-100">
                            <div>
                                <div class="d-flex align-items-center gap-1 percentUp">
                                    <span>+12.5%</span>
                                    <img src="assets/icons-admin/arrow.svg" alt="icon" loading="lazy" />
                                </div>
                                <div class="title">Total Revenue</div>
                            </div>
                            <div class="wallet-icon svg-bg">
                                <img src="assets/icons-admin/wallet.svg" alt="" width="100%">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="wallet-others">
                                <div class="amount">$15,000.00</div>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="title">Service Income</div>
                                    <div class="icon svg-bg">
                                        <img src="assets/icons-admin/service-income.svg" alt="icon" loading="lazy" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="wallet-others">
                                <div class="amount">$8,000.00</div>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="title">Consulting Fees</div>
                                    <div class="icon">
                                        <img src="assets/icons-admin/consulting-fee.svg" alt="icon" loading="lazy" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="wallet-others">
                                <div class="amount">$2,000.00</div>
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <div class="title">Pending Payments</div>
                                    <div class="icon">
                                        <img src="assets/icons-admin/credit-card-orange.svg" alt="icon" loading="lazy" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Statistics -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="cardTitleBox d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="card-title chartTitle mb-0">Blog Statistics</h5>
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <button class="statisticsBtn active" data-value="daily">
                            Daily
                        </button>
                        <button class="statisticsBtn" data-value="monthly">
                            Monthly
                        </button>
                        <button class="statisticsBtn" data-value="yearly">
                            Yearly
                        </button>
                    </div>

                    <div class="statisticsDivder"></div>

                    <div>
                        <input type="date" name="date" class="statisticsInput" value="2025-04-06">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card theme-dark">
                        <div class="card-body">
                            <div class="border-bottom pb-3">
                                <h3 id="totalBlogPosts">50</h3>
                                <p>Total Blog Posts</p>
                            </div>
                            <canvas id="myChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card h-100 border theme-dark">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="border-bottom pb-3">
                                <h3>75</h3>
                                <p>Visitor Overview</p>
                            </div>
                            <div class="mt-auto colorDark">
                                <canvas id="myPieChart" width="200" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Inquiries -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="cardTitleBox">
                <h5 class="card-title chartTitle">
                    Recent Inquiries <span style="color: #687387">(Latest 5 Inquiries)</span>
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table dashboard">
                    <thead>
                        <tr>
                            <th><strong>Inquiry ID</strong></th>
                            <th><strong>Client Name</strong></th>
                            <th><strong>Service</strong></th>
                            <th><strong>Date</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Action</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="tableId">#INQ001</td>
                            <td class="tablecustomer">John Doe</td>
                            <td class="tableId">Web Development</td>
                            <td class="tableId">06 Apr, 2025</td>
                            <td class="tableStatus">
                                <div class="statusItem">
                                    <div class="circleDot animatedCompleted"></div>
                                    <div class="statusText">
                                        <span class="statusCompleted">Completed</span>
                                    </div>
                                </div>
                            </td>
                            <td class="tableAction">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="View details" class="circleIcon btn-sm btn-outline-primary svg-bg">
                                    <img src="assets/icons-admin/eye.svg" alt="icon" loading="lazy">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableId">#INQ002</td>
                            <td class="tablecustomer">Jane Smith</td>
                            <td class="tableId">SEO Services</td>
                            <td class="tableId">05 Apr, 2025</td>
                            <td class="tableStatus">
                                <div class="statusItem">
                                    <div class="circleDot animatedInProgress"></div>
                                    <div class="statusText">
                                        <span class="statusInProgress">In Progress</span>
                                    </div>
                                </div>
                            </td>
                            <td class="tableAction">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="View details" class="circleIcon btn-sm btn-outline-primary svg-bg">
                                    <img src="assets/icons-admin/eye.svg" alt="icon" loading="lazy">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableId">#INQ003</td>
                            <td class="tablecustomer">Alex Brown</td>
                            <td class="tableId">App Development</td>
                            <td class="tableId">04 Apr, 2025</td>
                            <td class="tableStatus">
                                <div class="statusItem">
                                    <div class="circleDot animatedPending"></div>
                                    <div class="statusText">
                                        <span class="statusPending">Pending</span>
                                    </div>
                                </div>
                            </td>
                            <td class="tableAction">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="View details" class="circleIcon btn-sm btn-outline-primary svg-bg">
                                    <img src="assets/icons-admin/eye.svg" alt="icon" loading="lazy">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableId">#INQ004</td>
                            <td class="tablecustomer">Maria Garcia</td>
                            <td class="tableId">Content Writing</td>
                            <td class="tableId">03 Apr, 2025</td>
                            <td class="tableStatus">
                                <div class="statusItem">
                                    <div class="circleDot animatedCompleted"></div>
                                    <div class="statusText">
                                        <span class="statusCompleted">Completed</span>
                                    </div>
                                </div>
                            </td>
                            <td class="tableAction">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="View details" class="circleIcon btn-sm btn-outline-primary svg-bg">
                                    <img src="assets/icons-admin/eye.svg" alt="icon" loading="lazy">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="tableId">#INQ005</td>
                            <td class="tablecustomer">Liam Johnson</td>
                            <td class="tableId">Cloud Consulting</td>
                            <td class="tableId">02 Apr, 2025</td>
                            <td class="tableStatus">
                                <div class="statusItem">
                                    <div class="circleDot animatedPending"></div>
                                    <div class="statusText">
                                        <span class="statusPending">Pending</span>
                                    </div>
                                </div>
                            </td>
                            <td class="tableAction">
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="View details" class="circleIcon btn-sm btn-outline-primary svg-bg">
                                    <img src="assets/icons-admin/eye.svg" alt="icon" loading="lazy">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Top Services -->
        <div class="col-xxl-4 col-lg-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="cardTitleBox">
                        <h5 class="card-title chartTitle">
                            Top Services
                        </h5>
                    </div>

                    <div class="d-flex flex-column gap-1">
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <img src="assets/service1-icon.png" alt="icon" loading="lazy"/>
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">Web Development</p>
                                    <p class="order">Inquiries: 45</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <img src="assets/service2-icon.png" alt="icon" loading="lazy"/>
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">SEO Services</p>
                                    <p class="order">Inquiries: 30</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Most Popular Blog Posts -->
        <div class="col-xxl-4 col-lg-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="cardTitleBox">
                        <h5 class="card-title chartTitle">
                            Most Popular Blog Posts
                        </h5>
                    </div>

                    <div class="d-flex flex-column gap-1">
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <img src="assets/blog1-thumbnail.png" alt="icon" loading="lazy"/>
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">AI in 2025</p>
                                    <div class="d-flex gap-1 align-items-center text-black">
                                        <i class="bi bi-eye-fill"></i> 1,200 Views
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <img src="assets/blog2-thumbnail.png" alt="icon" loading="lazy"/>
                                </div>
                                <div class="customer-about">
                                    <p class="name text-dark">Cloud Computing Trends</p>
                                    <div class="d-flex gap-1 align-items-center text-black">
                                        <i class="bi bi-eye-fill"></i> 900 Views
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Global Reach -->
        <div class="col-xxl-4 col-lg-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="cardTitleBox">
                        <h5 class="card-title chartTitle">
                            Top Countries
                        </h5>
                    </div>

                    <div class="d-flex flex-column gap-1">
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <img src="assets/flag-us.png" alt="icon" loading="lazy" />
                                </div>
                                <div class="customer-about">
                                    <p class="text-dark name">United States</p>
                                    <p class="order">Clients: 35</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="customer-section">
                            <div class="customer-details">
                                <div class="customer-image">
                                    <img src="assets/flag-uk.png" alt="icon" loading="lazy" />
                                </div>
                                <div class="customer-about">
                                    <p class="text-dark name">United Kingdom</p>
                                    <p class="order">Clients: 20</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    // Any dashboard-specific JavaScript can go here
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any dashboard components
        console.log('Dashboard loaded');
    });
</script>
@endsection