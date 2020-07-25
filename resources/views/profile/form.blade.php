<form class="card-body pd-30" action="{{ route('profile.update') }}" method="post">
    @csrf
    <h6 class="slim-card-title">Обновить информацию</h6>

    <div class="form-group">
        @if($model->flags === \App\Models\User::FLAG_NAME)
            <label class="form-control-label">Укажите Ник</label>
            <input type="text" name="nickname" class="form-control"
                   value="{{ old('nickname', $model->nickname) }}" required>
            @error('nickname')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        @elseif($model->flags = \App\Models\User::FLAG_STEAM_ID)
            <label class="form-control-label">Укажите Steam_ID</label>
            <input type="text" name="steam_id" class="form-control"
                   value="{{ old('steam_id', $model->steam_id) }}" required>
            @error('steam_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        @else
            <b class="text-danger">Тип админки не определен. Обратитесь к администрации.</b>
        @endif
    </div>

    <div class="form-group">
        <label class="form-control-label">Новый пароль <b class="text-danger">(Вводить БЕЗ setinfo _pw)</b></label>
        <input type="text" name="password" class="form-control">
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mg-t-30">
        <button type="submit" class="btn btn-primary pd-x-20">Сохранить</button>
    </div>
</form>
