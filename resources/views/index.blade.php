@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Users Count</h5>
                        <p class="card-text">{{ $data['usersCount'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders Count</h5>
                        <p class="card-text">{{ $data['ordersCount'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Revenue</h5>
                        <p class="card-text">${{ $data['revenue'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders Over Time</h5>
                        <canvas id="ordersChart" width="400" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        console.log("here");
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('ordersChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $dates->toJson() !!}, // Dates for x-axis
                    datasets: [{
                        label: 'Orders',
                        data: {!! $orderCounts->toJson() !!}, // Order counts for y-axis
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
