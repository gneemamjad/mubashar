@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Area</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.areas.update', $area) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>City</label>
                            <select name="city_id" class="form-control @error('city_id') is-invalid @enderror">
                                <option value="">Select City</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $area->city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name_en }} - {{ $city->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Name (English)</label>
                            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{ old('name_en', $area->name_en) }}">
                            @error('name_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Name (Arabic)</label>
                            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ old('name_ar', $area->name_ar) }}">
                            @error('name_ar')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 