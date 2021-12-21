@extends('layouts.application')

@section('content')

    <div class="session">
        <div class="change-profile">
            @if ($errors->any())
                <div class="flash flash--danger">
                    @foreach ($errors->all() as $error)
                        <p class="message">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <h3>プロフィールの変更</h3>
            <form action="{{ route('authors.update_profile', $author->id) }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <input type="text" name="fullname" id="fullname" value="{{ $author->fullname }}" class="form-control"
                        placeholder="名前" required />
                    <i class="fas fa-signature"></i>
                </div>
                <div class="form-group">
                    <input type="text" name="address" id="address" value="{{ $author->address }}" class="form-control"
                        placeholder="住所" />
                    <i class="fas fa-address-card"></i>
                </div>
                <div class="form-group">
                    <input type="date" name="birthday" id="birthday" value="{{ $author->birthday }}"
                        class="form-control" placeholder="生年月日" />
                    <i class="fas fa-birthday-cake"></i>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" id="phone" value="{{ $author->phone }}" class="form-control"
                        placeholder="電話番号" />
                    <i class="fas fa-phone"></i>
                </div>
                <input type="submit" id="submit-update-profile" value="確認" class="btn btn-submit" />
            </form>
        </div>
    </div>

@endsection
