import "../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"
import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", () => {
    const APP_URL = ""; // Empty so it will use current domain
    const $ = document;
    const elm_AuthBtn = $.querySelector("button#Auth");
    const elm_LoginBtn = $.querySelector("button#LoginBtn");
    const elm_RegisterBtn = $.querySelector("#RegisterBtn");
    const elm_Email = $.querySelector("input#email");
    const elm_ForgotEmail = $.querySelector("input#email_forgot");
    const elm_LoginEmail = $.querySelector("input#email_login");
    const elm_LoginPassword = $.querySelector("input#password_login");
    const elm_RegisterName = $.querySelector("input#name_register");
    const elm_RegisterEmail = $.querySelector("input#email_register");
    const elm_RegisterPassword = $.querySelector("input#password_register");
    const Auth = $.querySelector(".auth")
    const Register = $.querySelector(".register")
    const Login = $.querySelector(".login")
    const Forgot = $.querySelector(".forgot")
    const elm_Forgot_Btn = $.querySelector(".forgot-password")
    const SendRequestDelay = 0; //ms
    const elm_BackLevel1 = $.querySelectorAll(".back-level-1")
    const elm_SendForgot = $.querySelector("#send-forgot")
    const Eye = $.querySelectorAll('.eye')
    const Eye_Close = $.querySelectorAll('.eye-close')
    const ChangePasswordBtn = $.querySelector('#change_password')
    const NewPassword = $.querySelector('#new_password')

    let change_data = null
    let title = $.querySelector("title").innerHTML;

    function errors_to_persian(error) {
        if (error === "email is required.") {
            return "ایمیل اجباری است."
        } else if (error === "email must be type email.") {
            return "ایمیل باید از معتبر باشد."
        } else if (error === "password is required.") {
            return "رمز عبور اجباری است."
        } else if (error === "password must be at least 8 characters long.") {
            return "رمز عبور باید حداقل 8 کاراکتر باشد."
        } else if (error === "The input information is incorrect.") {
            return "اطلاعات ورودی صحیح نمی باشد."
        } else if (error === 'Failed to send email.') {
            return "ایمیل ارسال نشد. بعدا تلاش کنید."
        } else if (error === 'name is required.') {
            return "نام اجباری است."
        } else if (error === 'name must be at least 2 characters long.') {
            return "نام نباید کمتر از دو حرف باشد."
        }
    }

    function show_errors(element, errorName, errors, element2 = element) {
        element2.classList.add("invalid")
        let template = ''
        let er_box
        if (element.nextElementSibling === null) {
            er_box = element
        } else {
            er_box = element.nextElementSibling
        }
        if (er_box.classList.contains("error-box")) {
            er_box.remove()
        }
        template += '<div class="error-box mt-1">'
        switch (errorName) {
            case "email":
                errors.email.forEach(function (error) {
                    error = errors_to_persian(error)
                    template += `<span class="error text-[#FF5C00] mt-1 block">${error}</span>`;
                });
                break;
            case "password":
                errors.password.forEach(function (error) {
                    error = errors_to_persian(error)
                    template += `<span class="error text-[#FF5C00] mt-1 block">${error}</span>`;
                });
                break;
            case "name":
                errors.name.forEach(function (error) {
                    error = errors_to_persian(error)
                    template += `<span class="error text-[#FF5C00] mt-1 block">${error}</span>`;
                });
                break;
            case "message":
                errors.message.forEach(function (error) {
                    error = errors_to_persian(error)
                    template += `<span class="error text-[#FF5C00] mt-1 block">${error}</span>`;
                });
                break;
            default:
                console.error("not found errorName")
        }
        template += '</div>'
        element.insertAdjacentHTML("afterend", template)
    }

    function hide_errors(element = "all") {
        if (element !== "all") {
            element.classList.remove("invalid")
        } else {
            $.querySelectorAll(".invalid").forEach((i) => {
                i.classList.remove("invalid")
            })
        }
        try {
            $.querySelectorAll(".error-box").forEach((item) => {
                item.remove()
            })
        } catch (error) {
            console.log(error)
        }
    }

    function back_level_1() {
        change_data = null
        Auth.style.right = "50%"
        Register.style.right = "200%"
        Forgot.style.right = "200%"
        Login.style.right = "200%"
    }

    function show_loading_btn(element) {
        element.disabled = true;
        element.innerHTML = `<img id="loading" width="20" height="20" src='${APP_URL + "/" + "assets/images/loading.png"}' alt=''>`;
        return true;
    }

    function send_request(btn, onload, method, url, data) {
        if (show_loading_btn(btn)) {
            let xhr = new XMLHttpRequest()
            xhr.onload = () => {
                onload(xhr)
            }
            xhr.open(method, url);
            xhr.setRequestHeader('Content-type', 'application/json');
            setTimeout(() => {
                xhr.send(JSON.stringify(data))
            }, SendRequestDelay)
        }
    }

    $.addEventListener('visibilitychange', function () {
        if ($.visibilityState === 'hidden') {
            $.title = 'کجا رفتی؟ بیا😒';
        } else {
            $.title = title;
        }
    });

    try {
        elm_Forgot_Btn.addEventListener("click", function () {
            Auth.style.right = "-100%"
            Forgot.style.right = "50%"
            change_data = null
        })
    } catch (e) {
        console.log(e)
    }

    try {
        elm_BackLevel1.forEach((item) => {
            item.addEventListener("click", function () {
                back_level_1();
            })
        })
    } catch (e) {
        console.log(e)
    }

    try {
        Eye.forEach(function (eye) {
            eye.addEventListener('click', function () {
                let inputElement = eye.previousElementSibling;
                inputElement.setAttribute('type', 'text');
                eye.nextElementSibling.classList.remove('hidden');
                eye.classList.add('hidden');
            });
        });
    } catch (e) {
        console.log(e)
    }

    try {
        Eye_Close.forEach(function (eye_close) {
            eye_close.addEventListener('click', function () {
                let inputElement = eye_close.previousElementSibling.previousElementSibling;
                inputElement.setAttribute('type', 'password');
                eye_close.previousElementSibling.classList.remove('hidden');
                eye_close.classList.add('hidden');
            });
        });
    } catch (e) {
        console.log(e)
    }

    try {
        elm_AuthBtn.addEventListener("click", function () {
            if (change_data !== elm_Email.value) {
                send_request(elm_AuthBtn, function (xhr) {
                    elm_AuthBtn.disabled = false;
                    if (JSON.parse(xhr.response).status === "Success") {
                        elm_AuthBtn.innerHTML = "مرحله بعد";
                        hide_errors()
                        Auth.style.right = "-100%"
                        if (JSON.parse(xhr.response).data.status === "login") {
                            Login.style.right = "50%"
                            elm_LoginEmail.value = elm_Email.value
                            elm_LoginEmail.disabled = true
                            elm_LoginEmail.readOnly = true
                            elm_LoginPassword.focus()
                        } else if (JSON.parse(xhr.response).data.status === "register") {
                            Register.style.right = "50%"
                            elm_RegisterEmail.value = elm_Email.value
                            elm_RegisterEmail.disabled = true
                            elm_RegisterEmail.readOnly = true
                            elm_RegisterName.focus()
                        }
                    } else {
                        elm_AuthBtn.innerHTML = "مرحله بعد";
                        let errors = JSON.parse(xhr.response).data.errors
                        show_errors(elm_Email, "email", errors)
                    }
                }, "POST", APP_URL + "/" + "api/v1/auth", {email: elm_Email.value})
                change_data = elm_Email.value
            }
        })
    } catch (e) {
        console.log(e)
    }

    try {
        elm_SendForgot.addEventListener("click", function () {
            let start_time = performance.now();
            send_request(elm_SendForgot, function (xhr) {
                elm_SendForgot.disabled = false;
                if (JSON.parse(xhr.response).status === "Success") {
                    let end_time = performance.now();
                    let time = Math.floor((end_time - start_time) / 100)

                    function success(delay = 0) {
                        setTimeout(() => {
                            elm_SendForgot.innerHTML = "بازیابی";
                            hide_errors()
                            Swal.fire({
                                title: "ایمیل ارسال شد.",
                                text: "ما برای شما ایمیلی فرستادیم.لطفا ایمیل خود را چک کنید.",
                                icon: "success"
                            });
                            back_level_1()
                        }, delay)
                    }

                    if (time < 2000) {
                        success(2000)
                    } else {
                        success()
                    }
                } else {
                    elm_SendForgot.innerHTML = "بازیابی";
                    let errors = JSON.parse(xhr.response).data.errors
                    if (errors.email) {
                        show_errors(elm_ForgotEmail, "email", errors)
                    } else if (errors.message) {
                        show_errors(elm_ForgotEmail, "message", errors)
                    }
                }
            }, "POST", APP_URL + "/api/v1/" + "forgot_send_email", {email: elm_ForgotEmail.value})
        })
    } catch (e) {
        console.log(e)
    }

    try {
        elm_LoginBtn.addEventListener("click", function () {
            send_request(elm_LoginBtn, function (xhr) {
                elm_LoginBtn.disabled = false;
                if (JSON.parse(xhr.response).status === "Success") {
                    elm_LoginBtn.innerHTML = "ورود";
                    hide_errors()
                    let result = JSON.parse(xhr.response)
                    if (result.data.token) {
                        Swal.fire({
                            title: "ورود با موفقیت انجام شد.",
                            html: "در حال انتقال به صفحه اصلی",
                            timer: 3000,
                            timerProgressBar: true,
                        }).then((result) => {
                            location.href = "/"
                        });
                    }
                } else {
                    elm_LoginBtn.innerHTML = "ورود";
                    let errors = JSON.parse(xhr.response).data.errors
                    hide_errors()
                    if (errors.email) {
                        show_errors(elm_LoginEmail, "email", errors, elm_LoginEmail)
                    }
                    if (errors.password) {
                        show_errors(document.querySelector(".password-box:has(#password_login)"), "password", errors, elm_LoginPassword)
                    }
                    if (errors.message) {
                        show_errors(document.querySelector(".password-box:has(#password_login)"), "message", errors, elm_LoginPassword)
                    }
                }
            }, "POST", APP_URL + "/" + "api/v1/login", {
                email: elm_LoginEmail.value, password: elm_LoginPassword.value
            })
        })
    } catch (e) {
        console.log(e)
    }

    try {
        elm_RegisterBtn.addEventListener("click", function () {
            send_request(elm_RegisterBtn, function (xhr) {
                elm_RegisterBtn.disabled = false;
                if (JSON.parse(xhr.response).status === "Success") {
                    elm_RegisterBtn.innerHTML = "ثبت نام";
                    hide_errors()
                    let result = JSON.parse(xhr.response)
                    if (result.data.token) {
                        Swal.fire({
                            title: "ثبت نام با موفقیت انجام شد.",
                            html: "در حال انتقال به صفحه اصلی",
                            timer: 3000,
                            timerProgressBar: true,
                        }).then((result) => {
                            location.href = "/"
                        });
                    }
                } else {
                    elm_RegisterBtn.innerHTML = "ثبت نام";
                    let errors = JSON.parse(xhr.response).data.errors
                    hide_errors()
                    if (errors.name) {
                        show_errors(elm_RegisterName, "name", errors)
                    }
                    if (errors.email) {
                        show_errors(elm_RegisterEmail, "email", errors)
                    }
                    if (errors.password) {
                        show_errors($.querySelector(".password-box:has(#password_register)"), "password", errors, elm_RegisterPassword)
                    }
                    if (errors.message && errors.message[0] === "The input information is incorrect.") {
                        // go to login page
                        back_level_1()
                        Auth.style.right = "-100%"
                        Login.style.right = "50%"
                    }
                }
            }, "POST", APP_URL + "/" + "api/v1/register", {
                name: elm_RegisterName.value, email: elm_RegisterEmail.value, password: elm_RegisterPassword.value
            })
        })
    } catch (e) {
        console.log(e)
    }

    try {
        ChangePasswordBtn.addEventListener("click", function () {
            send_request(ChangePasswordBtn, function (xhr) {
                ChangePasswordBtn.disabled = false;
                if (JSON.parse(xhr.response).status === "Success") {
                    ChangePasswordBtn.innerHTML = "تغییر رمز عبور";
                    hide_errors()
                    Swal.fire({
                        title: "تغییر رمز با موفقیت انجام شد.",
                        html: "در حال انتقال به صفحه ورود",
                        timer: 3000,
                        timerProgressBar: true,
                    }).then((result) => {
                        location.href = "/auth"
                    });
                } else {
                    ChangePasswordBtn.innerHTML = "تغییر رمز عبور";
                    let errors = JSON.parse(xhr.response).data.errors
                    show_errors($.querySelector(".password-box:has(#new_password)"), "password", errors, NewPassword)
                }
            }, "POST", APP_URL + "/" + "api/v1/change_pass", {
                password: NewPassword.value, token: $.querySelector("#token").value
            })
        })
    } catch (e) {
        console.log(e)
    }
})
