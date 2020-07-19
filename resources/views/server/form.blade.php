<form action="{{ route('servers.store') }}" method="post">
    @csrf
    @if($model->id)
        <input type="text" name="id" value="{{ $model->id }}" hidden>
    @endif
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-control-label">
                    Название: <span class="tx-danger">*</span>
                </label>
                <input class="form-control"
                       type="text"
                       name="hostname"
                       placeholder="Укажите название"
                       value="{{ old('hostname', $model->hostname) }}"
                       required>
                @error('hostname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-control-label">
                    Адрес: <span class="tx-danger">*</span>
                </label>
                <input class="form-control"
                       type="text"
                       name="address"
                       placeholder="Укажите адрес сервера"
                       value="{{ old('address', $model->address) }}"
                       required>
                @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6 col-lg-8">
            <div class="form-group">
                <label class="form-control-label">Описание:</label>
                <textarea name="description" rows="16" class="form-control editor">
                    {{ old('description', $model->description) }}
                </textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-control-label">Правила:</label>
                <textarea name="rules" rows="16" class="form-control editor">
                    {{ old('rules', $model->rules) }}
                </textarea>
                @error('rules')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6 col-md-3 mg-b-10">
            <button type="submit" class="btn btn-teal btn-block">Сохранить</button>
        </div>
        @if($model->id)
            <div class="col-sm-3 col-md-2">
                <a href="{{ route('servers.delete', ['id' => $model->id]) }}"
                   class="btn btn-danger btn-block">
                    Удалить
                </a>
            </div>
        @endif
    </div>
</form>
