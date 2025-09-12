@extends('backend.global.master')

@section('title', 'Leave Allocation ' . ($leave_allocation->id ? 'Update' : 'Create'))
@section('heading', 'Leave Allocation ' . ($leave_allocation->id ? 'Update' : 'Create'))


@section('backend_custom_style')
@endsection

@section('backend_content')
    <div class="card card-default mb-4">
        <div class="card-header">
            <h2>Leave Allocation {{ $leave_allocation->id ? 'Update' : 'Create' }}</h2>
            <a href="{{ route('leaveAllocationList') }}" class="btn btn-outline-primary btn-pill btn-sm">Back To list</a>
        </div>
        <div class="card-body">
            <form action="{{ route('leaveAllocationSave', $leave_allocation->id ?? '') }}" method="post">
                @csrf

                {{-- Select User --}}
                <div class="mb-3">
                    <label for="user_id">Select User</label>
                    <select name="user_id" id="user_id" class="form-control" required
                        {{ isset($leave_allocation->id) ? 'disabled' : '' }}>
                        <option value="">-- Select User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ ($leave_allocation->id ? $leave_allocation->id : old('user_id')) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                        {{-- Hidden input to actually submit the value --}}
    @if(isset($leave_allocation->id))
        <input type="hidden" name="user_id" value="{{ $leave_allocation->id }}">
    @endif
                </div>

                {{-- Assign Leave Types --}}
                <div class="mb-3">
                    @foreach ($leave_types as $leave_type)
                        @php
                            $existing = 0;
                            if (isset($leave_allocation->leaveAllocations) && $leave_allocation->leaveAllocations) {
                                $allocation = $leave_allocation->leaveAllocations
                                    ->where('leave_type_id', $leave_type->id)
                                    ->first();
                                $existing = $allocation->total_leave ?? 0;
                            }
                        @endphp

                        <div class="form-group mb-2">
                            <label>{{ $leave_type->name }}</label>
                            <input type="number" name="leave_types[{{ $leave_type->id }}]"
                                value="{{ old('leave_types.' . $leave_type->id, $existing) }}" class="form-control"
                                min="0" required>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-outline-primary btn-sm">
                    {{ isset($leave_allocation->id) ? 'Update' : 'Submit' }}
                </button>
            </form>


        </div>
    </div>
@endsection

@section('backend_custom_js')
@endsection
