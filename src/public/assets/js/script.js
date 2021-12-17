/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/script.js":
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  // dynamic select
  $("#categories").select2({
    placeholder: "カテゴライズを1以上選んで。。。"
  }); // show list of image's name when seleted images

  $("#images").change(function () {
    var files = Array.from(this.files);
    if ($(".images-choosen").children().length > 0) $(".images-choosen").empty();
    files.forEach(function (f, i) {
      var rd = document.createElement("input");
      var label = document.createElement("label");
      var file_group = document.createElement("div");
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
  }); // create condition show/hidden password

  $(".show-hide-pw").each(function () {
    var show_pw_btn = this;
    $(this).click(function () {
      var input_pw = this.parentNode.querySelector("input");

      if (input_pw && input_pw.type == "password") {
        input_pw.type = "text";
        show_pw_btn.textContent = "非表示";
      } else {
        input_pw.type = "password";
        show_pw_btn.textContent = "表示";
      }
    });
  }); //register check password matched

  $("#submit-register").click(function (e) {
    if ($("#password").val() !== $("#cpassword").val()) {
      alert("パスワードとコンファメーションは一致しません！");
      e.preventDefault();
    }
  }); //update profile avatar by AJAX

  $("#profile-change").on("change", function () {
    var author_id = window.location.pathname.split("/").pop();
    var selected_avatar = $("#form-avatar")[0];
    var form_data = new FormData($("#form-avatar")[0]);
    form_data.append("author_id", author_id);
    form_data.append("file", selected_avatar);
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      }
    });
    $.ajax({
      url: "/authors/profile/update_avatar",
      type: "POST",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function success(data) {
        alert("アバターの変更が成功でした！");
        $(".profile__avatar img").attr("src", "/assets/image/authors/" + data.image_src);
        console.log(data);
      },
      error: function error(err) {
        console.log(err);
      }
    });
  }); //update_password check password matched

  $("#submit-update-password").click(function (e) {
    if ($("#new_password").val() !== $("#cnew_password").val()) {
      alert("新たなパスワードと新たなパスワードの確認は一致しません！");
      e.preventDefault();
    }
  });
});

/***/ }),

/***/ 0:
/*!**************************************!*\
  !*** multi ./resources/js/script.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\mrahn\Desktop\hoc css\project\prtimes_kenshu\book\BE\PHP-Docker-SQL\Exercise\article_app_laravel\src\resources\js\script.js */"./resources/js/script.js");


/***/ })

/******/ });