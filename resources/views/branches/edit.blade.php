@extends('layouts.app')

@section('title', 'Edit Branch')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50">
    <div class="p-6 max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3">
                Edit Branch
            </h1>
            <a href="{{ route('branches.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline">← Back to Branches</a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/50 p-8">
            <form method="POST" action="{{ route('branches.update', $branch) }}" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="business_id" class="block text-sm font-semibold text-slate-700 mb-2">Business *</label>
                        <select id="business_id" name="business_id" required
                                class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium bg-white">
                            @foreach($businesses as $business)
                                <option value="{{ $business->id }}" {{ (old('business_id', $branch->business_id) == $business->id) ? 'selected' : '' }}>
                                    {{ $business->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Branch Name *</label>
                        <input type="text" id="name" name="name" required value="{{ old('name', $branch->name) }}"
                               class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                    </div>

                    <div class="md:col-span-2">
                        <label for="location" class="block text-sm font-semibold text-slate-700 mb-2">Location</label>
                        <textarea id="location" name="location" rows="2"
                                  class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">{{ old('location', $branch->location) }}</textarea>
                    </div>

                    <div>
                        <label for="geo_lat" class="block text-sm font-semibold text-slate-700 mb-2">Latitude</label>
                        <input type="number" step="any" id="geo_lat" name="geo_lat" value="{{ old('geo_lat', $branch->geo_lat) }}"
                               class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                    </div>

                    <div>
                        <label for="geo_lng" class="block text-sm font-semibold text-slate-700 mb-2">Longitude</label>
                        <input type="number" step="any" id="geo_lng" name="geo_lng" value="{{ old('geo_lng', $branch->geo_lng) }}"
                               class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all text-slate-700 font-medium">
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl">
                        Update Branch
                    </button>
                    <a href="{{ route('branches.index') }}" class="flex-1 bg-slate-100 text-slate-700 px-6 py-4 rounded-xl hover:bg-slate-200 transition-all font-semibold border border-slate-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

