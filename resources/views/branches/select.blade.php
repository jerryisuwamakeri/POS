@extends('layouts.app')

@section('title', 'Select Branch')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold mb-6">Select Branch</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-md">
        <form method="POST" action="{{ route('branches.store') }}">
            @csrf
            <div class="mb-4">
                <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-2">Branch</label>
                <select name="branch_id" id="branch_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Select a branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }} - {{ $branch->business->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Continue
            </button>
        </form>
    </div>
</div>
@endsection

