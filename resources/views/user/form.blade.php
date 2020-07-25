<form action="{{ $user->id ? route('users.update') : route('users.store') }}" method="post">
    @csrf
    @if($user->id)
        <input type="text" name="id" value="{{ $user->id }}" hidden>
    @endif

    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-control-label">
                    Почта: <span class="tx-danger">*</span>
                </label>
                <input class="form-control"
                       type="email"
                       name="email"
                       placeholder="Укажите почту"
                       value="{{ old('email', $user->email ) }}"
                       required>
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-control-label">
                    Логин: <span class="tx-danger">*</span>
                </label>
                <input class="form-control"
                       type="text"
                       name="name"
                       placeholder="Укажите логин"
                       value="{{ old('name', $user->name) }}"
                       required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-control-label">
                    Пароль: @if(!$user->id)<span class="tx-danger">*</span> @endif
                </label>
                <input class="form-control"
                       type="password"
                       name="password"
                       value="{{ old('password') }}"
                       placeholder="Укажите пароль"
                       @if(!$user->id) required @endif>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-control-label">Права:</label>
                <select class="form-control select2-show-search select2-hidden-accessible"
                        name="role"
                        required>
                    @foreach($user->role_list as $value => $title)
                        <option value="{{ $value }}" @if($user->role === $value) selected @endif>
                            {{ $title }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-control-label">
                    Уникальная ссылка: <span class="tx-danger">*</span>
                </label>

                <div class="input-group">
                    <div class="input-group-prepend refresh-key">
                        <span class="input-group-text"><i class="icon ion-refresh tx-16 lh-0 op-6"></i></span>
                    </div>
                    <input class="form-control"
                           type="text"
                           name="auth_key"
                           placeholder="Укажите ссылку"
                           value="{{ old('auth_key', $user->auth_key ?? \Illuminate\Support\Str::random(25)) }}"
                           readonly>
                    @error('auth_key')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-control-label">Тип админки:</label>
                <select class="form-control select2-show-search select2-hidden-accessible"
                        name="flags"
                        required>
                    @foreach($user->flag_list as $value => $title)
                        <option value="{{ $value }}" @if($user->flags === $value) selected @endif>
                            {{ $title }}
                        </option>
                    @endforeach
                </select>
                @error('flag_list')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-control-label">Steam ID<span
                        class="tx-danger">*</span></label>
                <input class="form-control"
                       type="text"
                       name="steam_id"
                       placeholder="Введите Steam ID"
                       value="{{ old('steam_id', $user->steam_id) }}"
                       required>
                @error('steam_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-control-label">Ник: <span
                        class="tx-danger">*</span></label>
                <input class="form-control"
                       type="text"
                       name="nickname"
                       placeholder="Введите Ник:"
                       value="{{ old('nickname', $user->nickname) }}"
                       required>
                @error('nickname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-control-label">Услуги на серверах:</label>
                @foreach($servers as $server)
                    <label class="ckbox">
                        <input type="checkbox"
                               name="servers[{{ $server->id }}][on]"
                               onclick="if($(this).prop('checked')) {
                                   $('.sc-{{ $server->id }}').show();
                                   } else {
                                   $('.sc-{{ $server->id }}').hide();
                                   }"
                               @if($server->pivot) checked @endif
                        >
                        <span>{{ $server->hostname }}</span>
                    </label>
                    <div class="card mb-3 sc-{{ $server->id }}"
                         @if(!$server->pivot) style="display: none;" @endif>
                        <div class="card-body">
                            <h5 class="card-title tx-dark tx-medium mg-b-10">{{ $server->hostname }}</h5>
                            <div class="form-group">
                                <label class="form-control-label">Флаги доступа:</label>
                                <select class="form-control select2-show-search select2-hidden-accessible"
                                        name="servers[{{ $server->id }}][access]">
                                    @forelse($server->privileges as $privilege)
                                        <option value="{{ $privilege->flags }}"
                                                @if($server->pivot && $server->pivot->access === $privilege->flags)
                                                selected
                                            @endif
                                        >{{ $privilege->title }}</option>
                                    @empty
                                        <option value="" disabled>На сервере не добавлены услуги.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Срок:</label>
                                <label class="ckbox">
                                    <input type="checkbox"
                                           name="servers[{{ $server->id }}][forever]"
                                           onclick="if($(this).prop('checked')) {
                                               $('.cl-{{ $server->id }}').hide();
                                               } else {
                                               $('.cl-{{ $server->id }}').show();
                                               }"
                                           @if($server->pivot && $server->pivot->getOriginal('expire') === null) checked @endif
                                    >
                                    <span>Навсегда</span>
                                </label>

                                <div class="input-group cl-{{ $server->id }}"
                                     @if($server->pivot && $server->pivot->getOriginal('expire') === null) style="display: none;" @endif
                                >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>

                                    <input type="text" class="form-control fc-datepicker" placeholder="ДД-ММ-ГГГГ"
                                           name="servers[{{ $server->id }}][expire]"
                                           @if($server->pivot)
                                           value="{{ $server->pivot->expire }}"
                                        @endif
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-2 mb-3">
            <button type="submit" class="btn btn-teal btn-block">Сохранить</button>
        </div>
        @if($user->id)
            <div class="col-sm-3 col-md-2">
                <a href="{{ route('users.delete', ['id' => $user->id]) }}"
                   class="btn btn-danger btn-block">
                    Удалить
                </a>
            </div>
        @endif
    </div>
</form>
