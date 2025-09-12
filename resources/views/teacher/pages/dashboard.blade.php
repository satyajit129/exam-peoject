@extends('teacher.global.master')


@section('teacher_custom_style')
@endsection


@section('teacher_content')
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">শিক্ষক ড্যাশবোর্ড</h2>
            <p>স্বাগতম, {{ Auth::guard('teacher')->user()->name }}!</p>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Total Batches -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card card-default text-center">
                <div class="card-body">
                    <h5 class="card-title">মোট ব্যাচ</h5>
                    <p class="h2">{{ $batchesCount ?? 0 }}</p>
                    <a href="" class="btn btn-primary btn-sm mt-2">বিস্তারিত দেখুন</a>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card card-default text-center">
                <div class="card-body">
                    <h5 class="card-title">মোট শিক্ষার্থী</h5>
                    <p class="h2">{{ $studentsCount ?? 0 }}</p>
                    <a href="" class="btn btn-success btn-sm mt-2">বিস্তারিত দেখুন</a>
                </div>
            </div>
        </div>

        <!-- Total Questions -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card card-default text-center">
                <div class="card-body">
                    <h5 class="card-title">মোট প্রশ্ন</h5>
                    <p class="h2">{{ $questionsCount ?? 0 }}</p>
                    <a href="" class="btn btn-warning btn-sm mt-2">বিস্তারিত দেখুন</a>
                </div>
            </div>
        </div>

        <!-- Pending Student Progress -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card card-default text-center">
                <div class="card-body">
                    <h5 class="card-title">প্রগতি পর্যবেক্ষণ</h5>
                    <p class="h2">{{ $pendingProgress ?? 0 }}</p>
                    <a href="" class="btn btn-danger btn-sm mt-2">বিস্তারিত দেখুন</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header justify-content-center">
                    <h2 class="card-title ">শিক্ষার্থীর প্রগতি চার্ট</h2>
                </div>
                <div class="card-body">
                    <div id="studentProgressChart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('general_custom_js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Completed Students',
                    data: [25, 18, 30, 12] // Static data
                }],
                xaxis: {
                    categories: ['ব্যাচ ১', 'ব্যাচ ২', 'ব্যাচ ৩', 'ব্যাচ ৪'], // Static batch names
                    title: {
                        text: 'ব্যাচ'
                    }
                },
                yaxis: {
                    title: {
                        text: 'শিক্ষার্থী সংখ্যা'
                    }
                },
                dataLabels: {
                    enabled: true
                },
                title: {
                    text: 'ব্যাচ অনুযায়ী শিক্ষার্থীর প্রগতি',
                    align: 'center'
                }
            };

            var chart = new ApexCharts(document.querySelector("#studentProgressChart"), options);
            chart.render();
        });
    </script>
@endsection
