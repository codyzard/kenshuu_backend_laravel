$(document).ready(function () {
    // dynamic select
    $("#categories").select2({
        placeholder: "カテゴライズを1以上選んで。。。",
    });

    // show list of image's name when seleted images
    $("#images").change(function () {
        let files = Array.from(this.files);
        if ($(".images-choosen").children().length > 0)
            $(".images-choosen").empty();
        files.forEach((f, i) => {
            let rd = document.createElement("input");
            let label = document.createElement("label");
            let file_group = document.createElement("div");
            file_group.classList.add("images-choosen__item");
            rd.type = "radio";
            rd.name = "thumbnail";
            rd.value = f.name;
            rd.id = "rd" + i;
            rd.required = true;
            label.textContent = f.name;
            label.htmlFor = rd.id;
            file_group.append(rd);
            file_group.append(label);
            $(".images-choosen").append(file_group);
        });
    });

    // create condition show/hidden password
    $(".show-hide-pw").each(function () {
        let show_pw_btn = this;
        $(this).click(function () {
            let input_pw = this.parentNode.querySelector("input");
            if (input_pw && input_pw.type == "password") {
                input_pw.type = "text";
                show_pw_btn.textContent = "非表示";
            } else {
                input_pw.type = "password";
                show_pw_btn.textContent = "表示";
            }
        });
    });

    //register check password matched
    $("#submit-register").click((e) => {
        if ($("#password").val() !== $("#cpassword").val()) {
            alert("パスワードとコンファメーションは一致しません！");
            e.preventDefault();
        }
    });

    //update profile avatar by AJAX
    $("#profile-change").on("change", function () {
        let author_id = window.location.pathname.split("/").pop();
        let selected_avatar = $("#form-avatar")[0];
        let form_data = new FormData($("#form-avatar")[0]);
        form_data.append("author_id", author_id);
        form_data.append("file", selected_avatar);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/authors/profile/update_avatar",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data) {
                alert("アバターの変更が成功でした！");
                $(".profile__avatar img").attr(
                    "src",
                    "/assets/image/authors/" + data.image_src
                );
                console.log(data);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    //update_password check password matched
    $("#submit-update-password").click((e) => {
        if ($("#new_password").val() !== $("#cnew_password").val()) {
            alert("新たなパスワードと新たなパスワードの確認は一致しません！");
            e.preventDefault();
        }
    });
});
