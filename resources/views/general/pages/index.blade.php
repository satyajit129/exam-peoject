@extends('general.global.master')


@section('general_custom_style')
@endsection

@section('general_content')
<div class="card-default card">
    <div class="card-header">
        <h2 class="card-title">শিক্ষক সেকশন</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- 1 মাসের সাবস্ক্রিপশন -->
            <div class="col-lg-6 col-xl-3">
                <div class="card mb-4 text-center">
                    <img class="card-img-top" src="{{ asset('general/images/img_1.jpg') }}" alt="1 মাসের সাবস্ক্রিপশন">
                    <div class="card-body">
                        <h5 class="card-title">1 মাসের সাবস্ক্রিপশন</h5>
                        <p class="card-text">১ মাসের জন্য সমস্ত অ্যাক্সেস।</p>
                        <p class="h4 text-primary">$10</p>
                        <a href="#" class="btn btn-outline-primary btn-pill mt-2">সাবস্ক্রাইব করুন</a>
                    </div>
                </div>
            </div>

            <!-- 3 মাসের সাবস্ক্রিপশন -->
            <div class="col-lg-6 col-xl-3">
                <div class="card mb-4 text-center">
                    <img class="card-img-top" src="{{ asset('general/images/img_1.jpg') }}" alt="3 মাসের সাবস্ক্রিপশন">
                    <div class="card-body">
                        <h5 class="card-title">3 মাসের সাবস্ক্রিপশন</h5>
                        <p class="card-text">৩ মাসের পূর্ণ অ্যাক্সেস এবং ডিসকাউন্টসহ।</p>
                        <p class="h4 text-success">$27</p>
                        <a href="#" class="btn btn-outline-success btn-pill mt-2">সাবস্ক্রাইব করুন</a>
                    </div>
                </div>
            </div>

            <!-- 6 মাসের সাবস্ক্রিপশন -->
            <div class="col-lg-6 col-xl-3">
                <div class="card mb-4 text-center">
                    <img class="card-img-top" src="{{ asset('general/images/img_1.jpg') }}" alt="6 মাসের সাবস্ক্রিপশন">
                    <div class="card-body">
                        <h5 class="card-title">6 মাসের সাবস্ক্রিপশন</h5>
                        <p class="card-text">৬ মাসের সম্পূর্ণ অ্যাক্সেস এবং অতিরিক্ত সুবিধাসহ।</p>
                        <p class="h4 text-warning">$50</p>
                        <a href="#" class="btn btn-outline-warning btn-pill mt-2">সাবস্ক্রাইব করুন</a>
                    </div>
                </div>
            </div>

            <!-- 12 মাসের সাবস্ক্রিপশন -->
            <div class="col-lg-6 col-xl-3">
                <div class="card mb-4 text-center">
                    <img class="card-img-top" src="{{ asset('general/images/img_1.jpg') }}" alt="12 মাসের সাবস্ক্রিপশন">
                    <div class="card-body">
                        <h5 class="card-title">12 মাসের সাবস্ক্রিপশন</h5>
                        <p class="card-text">এক বছরের পূর্ণ অ্যাক্সেস এবং প্রাধান্য সহ সাপোর্ট।</p>
                        <p class="h4 text-danger">$90</p>
                        <a href="#" class="btn btn-outline-danger btn-pill mt-2">সাবস্ক্রাইব করুন</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="card-default card">
    <div class="card-header">
        <h2 class="card-title">শিক্ষার্থী সেকশন</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-xl-3">
                <div class="card mb-4">
                    <img class="card-img-top" src="assets/img/elements/cc1.jpg" alt="ছাত্র সাবস্ক্রিপশন">
                    <div class="card-body">
                        <h5 class="card-title">কার্ড শিরোনাম</h5>
                        <p class="card-text pb-3">লোরেম ইপসাম ডোলর সিট অ্যামেট, কনসেকটেচার এডিপিসিং এলিট, সেড ডো ইইউসমোড টেম্পর।</p>
                        <a href="#" class="btn btn-outline-primary btn-pill">বিস্তারিত দেখুন</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3">
                <div class="card mb-4 p-0">
                    <h5 class="card-title pt-4 px-6">কার্ড শিরোনাম</h5>
                    <div class="card-body">
                        <img class="card-img-top mb-4 rounded" src="assets/img/elements/cc1a.jpg" alt="ছাত্র সাবস্ক্রিপশন">
                        <p class="card-text pb-3">লোরেম ইপসাম ডোলর সিট অ্যামেট, কনসেকটেচার এডিপিসিং এলিট।</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3">
                <div class="card mb-4 p-0">
                    <h5 class="card-title pt-4 px-6">কার্ড শিরোনাম</h5>
                    <div class="card-body">
                        <p class="card-text pb-2">লোরেম ইপসাম ডোলর সিট অ্যামেট, কনসেকটেচার এডিপিসিং এলিট।</p>
                        <a href="#" class="btn btn-outline-primary btn-pill">বিস্তারিত দেখুন</a>
                    </div>
                    <img class="card-img rounded-0" src="assets/img/elements/cc1b.jpg" alt="ছাত্র সাবস্ক্রিপশন">
                </div>
            </div>

            <div class="col-lg-6 col-xl-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-1">কার্ড শিরোনাম</h5>
                        <p class="pb-3">উপ-শিরোনাম টেক্সট</p>
                        <img class="mb-4 card-img" src="assets/img/elements/cc1c.jpg" alt="ছাত্র সাবস্ক্রিপশন">
                        <p class="card-text pb-2">লোরেম ইপসাম ডোলর সিট অ্যামেট, কনসেকটেচার এডিপিসিং এলিট।</p>
                        <a href="#" class="btn btn-link px-0 text-info mr-3">বিস্তারিত দেখুন</a>
                        <a href="#" class="btn btn-link px-0 text-danger">বিস্তারিত দেখুন</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('general_custom_js')
@endsection
