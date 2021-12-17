@extends('layouts.application')

@section('content')

    <div class="session">
        <div class="change-profile">
            <?php if (!empty($_SESSION['errors'])) : ?>
            <div class="flash flash--danger">
                <?php foreach ($_SESSION['errors'] as $err) : ?>
                <p class="message"><?php Helper::print_filtered($err); ?></p>
                <?php endforeach ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
            <?php endif ?>
            <h3>プロフィールの変更</h3>
            <form action="/author/store_update_profile/<?php Helper::print_filtered($author['id']); ?>" method="POST">
                <div class="form-group">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                </div>
                <div class="form-group">
                    <input type="text" name="fullname" id="fullname" value="<?php Helper::print_filtered($author['fullname'] ?: ''); ?>" class="form-control"
                        placeholder="名前" required />
                    <i class="fas fa-signature"></i>
                </div>
                <div class="form-group">
                    <input type="text" name="address" id="address" value="<?php Helper::print_filtered($author['address'] ?: ''); ?>" class="form-control"
                        placeholder="住所" />
                    <i class="fas fa-address-card"></i>
                </div>
                <div class="form-group">
                    <input type="date" name="birthday" id="birthday" value="<?php Helper::print_filtered($author['birthday'] ?: ''); ?>" class="form-control"
                        placeholder="生年月日" />
                    <i class="fas fa-birthday-cake"></i>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" id="phone" value="<?php Helper::print_filtered($author['phone'] ?: ''); ?>" class="form-control"
                        placeholder="電話番号" />
                    <i class="fas fa-phone"></i>
                </div>
                <input type="submit" id="submit-update-profile" value="確認" class="btn btn-submit" />
            </form>
        </div>
    </div>

@endsection
