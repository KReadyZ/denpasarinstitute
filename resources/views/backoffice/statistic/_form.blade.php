<div class="mb-3">
    <label class="form-label">Icon (font-awesome, tanpa prefix "fas", mis: fa-users)</label>
    <input type="text" name="icon" class="form-control" value="{{ old('icon', $statistic->icon ?? '') }}" required>
    @error('icon')<small class="text-danger">{{ $message }}</small>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Angka (target akhir counter)</label>
    <input type="number" name="number" class="form-control" value="{{ old('number', $statistic->number ?? '') }}" required>
    @error('number')<small class="text-danger">{{ $message }}</small>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Label</label>
    <input type="text" name="label" class="form-control" value="{{ old('label', $statistic->label ?? '') }}" required>
    @error('label')<small class="text-danger">{{ $message }}</small>@enderror
</div>

<div class="row mb-3">
    <div class="col">
        <label class="form-label">Persentase Trend</label>
        <input type="number" name="trend_percentage" class="form-control" value="{{ old('trend_percentage', $statistic->trend_percentage ?? '') }}">
    </div>
    <div class="col">
        <label class="form-label">Arah Trend</label>
        <select name="trend_direction" class="form-select">
            <option value="up" {{ old('trend_direction', $statistic->trend_direction ?? 'up') === 'up' ? 'selected' : '' }}>Naik</option>
            <option value="down" {{ old('trend_direction', $statistic->trend_direction ?? '') === 'down' ? 'selected' : '' }}>Turun</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <label class="form-label">Urutan Tampil</label>
        <input type="number" name="order" class="form-control" value="{{ old('order', $statistic->order ?? 0) }}">
    </div>
    <div class="col d-flex align-items-center">
        <div class="form-check mt-4">
            <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $statistic->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">Aktif (tampil di homepage)</label>
        </div>
    </div>
</div>