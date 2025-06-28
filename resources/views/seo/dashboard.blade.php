@extends('layouts.seo')
@section('seo-content')
<style>/* Dashboard Card Styles */
.card-h5-dashboard {
    font-weight: 600;
    font-size: 60px;
    margin: 0;
    text-align: right;
    color: white;
}

.card-text {
    width: 141px;
    height: 27px;
    color: rgba(255, 255, 255, 1);
    font-size: 18px;
    font-weight: 600;
}

/* Background Gradients for Cards */
.bg-gradient-blue {
    background: linear-gradient(98.86deg, #6BAAFC 0%, #305FEC 100%);
}

.bg-gradient-red {
    background: linear-gradient(98.86deg, #EF5E7A 0%, #D35385 100%);
}

.bg-gradient-purple {
    background: linear-gradient(98.86deg, #D623FE 0%, #A530F2 100%);
}

.bg-gradient-orange {
    background: linear-gradient(98.86deg, #FEA623 0%, #C97900 100%);
}

/* Card Icon (Shadow Background Image) */
.card-icon {
    font-weight: 900;
    font-size: 62px;
    position: absolute;
    left: -3px;
    top: 83px;
    transform: rotate(-30deg);
    color: rgba(255, 255, 255, 0.13);
}
</style>
<div class="page-content">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-10 bg-gradient-blue position-relative" style="padding: 0px !important">
                <div class="card-body text-white text-center">
                    <img class="card-icon" src="{{ asset('assets/images/avatars/Vector (1).png') }}">
                   <p class="mb-1 card-text">Total Page Views</p>
                    <h5 class="mb-0 card-h5-dashboard">32</h5>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-purple position-relative">
                <div class="card-body text-white text-center">
                    <img class="card-icon" src="{{ asset('assets/images/avatars/Vector (3).png') }}">
                    <p class="mb-1 card-text">Ranked Keyword  </p>
                    <h5 class="mb-0 card-h5-dashboard">58</h5>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-red position-relative">
                <div class="card-body text-white text-center">
                    <img class="card-icon" src="{{ asset('assets/images/avatars/Vector (2).png') }}">
                     <p class="mb-1 card-text">Backlinks</p>
                    <h5 class="mb-0 card-h5-dashboard">204</h5>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-orange position-relative">
                <div class="card-body text-white text-center">
                    <img class="card-icon" src="{{ asset('assets/images/avatars/Vector (4).png') }}">
                     <p class="mb-1 card-text">Technical Errors</p>
                    <h5 class="mb-0 card-h5-dashboard">13</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
