<div class="btn-group">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('Actions') }}
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('admin.users.ads', $id) }}">
            <i class="fas fa-ad mr-2"></i>{{ __('User Ads') }}
        </a>
    </div>
</div> 