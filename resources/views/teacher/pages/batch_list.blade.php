@extends('teacher.global.master')

@section('teacher_custom_style')
@endsection

@section('teacher_content')
    <div class="card card-default">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">ব্যাচ তালিকা</h2>
            <a href="{{ route('batchForm') }}" class="btn btn-primary btn-sm">
                নতুন ব্যাচ তৈরি করুন
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">ব্যাচের নাম</th>
                        <th scope="col">শিক্ষার্থী সংখ্যা</th>
                        <th scope="col">শুরুর তারিখ</th>
                        <th scope="col">শেষ তারিখ</th>
                        <th scope="col">অবস্থা</th>
                        <th scope="col">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batches as $batch)
                        <tr>
                            <td>{{ $batch->name }}</td>
                            <td>{{ $batch->max_students }}</td>
                            <td>{{ \Carbon\Carbon::parse($batch->start_date)->format('Y-m-d') }}</td>
                            <td>{{ $batch->end_date ? \Carbon\Carbon::parse($batch->end_date)->format('Y-m-d') : '-' }}</td>
                            <td>
                                @if($batch->status === 'active')
                                    <span class="badge badge-outline-success badge-square ">সক্রিয়</span>
                                @else
                                    <span class="badge badge-outline-danger badge-square ">নিষ্ক্রিয়</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('batchForm', $batch->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('batchDelete', $batch->id) }}"
                                   onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই ব্যাচটি মুছে ফেলতে চান?');"
                                   class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">কোনো ব্যাচ পাওয়া যায়নি</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('teacher_custom_script')
@endsection
