@extends('layouts.application')

@section('content')

    <div class="session">
        <div class="change-password">
            @if ($errors->any())
                <div class="flash flash--danger">
                    @foreach ($errors->all() as $error)
                        <p class="message">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <h3>パスワード変更</h3>
            <form action="/authentication/store_change_password/<?php Helper::print_filtered($author_id); ?>" method="POST">
                @csrf
                <div class="form-group">
                    <input type="password" name="old_password" id="old_password" class="form-control" placeholder="古いパスワード"
                        required />
                    <i class="fas fa-lock fa-lg"></i>
                    <span class="show-hide-pw">表示</span>
                </div>
                <div class="form-group">
                    <input type="password" name="new_password" id="new_password" class="form-control"
                        placeholder="新たなパスワード" required />
                    <i class="fas fa-key"></i>
                    <span class="show-hide-pw">表示</span>
                </div>
                <div class="form-group">
                    <input type="password" name="cnew_password" id="cnew_password" class="form-control"
                        placeholder="新たなパスワードの確認" required />
                    <i class="fas fa-check"></i>
                    <span class="show-hide-pw">表示</span>
                </div>
                <input type="submit" id="submit-update-password" value="確認" class="btn btn-submit" />
            </form>
        </div>
    </div>

@endsection
