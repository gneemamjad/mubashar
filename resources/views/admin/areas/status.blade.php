<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="status_{{ $area->id }}"
        {{ $area->status ? 'checked' : '' }} onchange="updateAreaStatus({{ $area->id }}, this.checked)">
    <label class="custom-control-label" for="status_{{ $area->id }}"></label>
</div> 