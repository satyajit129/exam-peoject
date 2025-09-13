@extends('teacher.global.master')

@section('teacher_content')
<div class="card card-default">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="card-title mb-0">প্রশ্নসমূহ</h2>
        <a href="{{ route('questionForm') }}" class="btn btn-primary btn-sm">নতুন প্রশ্ন যোগ করুন</a>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>প্রশ্ন</th>
                    <th>ক্যাটাগরি</th>
                    <th>উত্তরের বিকল্প</th>
                    <th>বর্ণনা</th>
                    <th>পূর্ববর্তী পরীক্ষা</th>
                    <th>অবস্থা</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $q)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $q->question_text }}</td>
                        <td>{{ $q->category->name ?? '-' }}</td>
                        <td>
                            <ol>
                                @foreach($q->options as $option)
                                    <li>{{ $option->option_text }}</li>
                                @endforeach
                            </ol>
                        </td>
                        <td>{{ $q->description->description ?? '-' }}</td>
                        <td>
                            @if($q->previousExams->count())
                                <ul>
                                    @foreach($q->previousExams as $exam)
                                        <li>{{ $exam->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($q->status == 'active')
                                <span class="badge bg-success badge-square">সক্রিয়</span>
                            @else
                                <span class="badge bg-danger badge-square">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('questionForm', $q->id) }}" class="btn btn-sm btn-primary">সম্পাদনা</a>
                            <a href="{{ route('questionDelete', $q->id) }}" class="btn btn-sm btn-danger" 
                               onclick="return confirm('আপনি কি নিশ্চিত?')">মুছুন</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">কোনো প্রশ্ন পাওয়া যায়নি</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
