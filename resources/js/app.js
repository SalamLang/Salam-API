import "../../node_modules/sweetalert2/dist/sweetalert2.all.min.js"
import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", () => {
    const APP_URL = "http://127.0.0.1:8000";
    const $ = document;
    const elm_AuthBtn = $.querySelector("button#Auth");
    const elm_Email = $.querySelector("input#email");
    const elm_ForgotEmail = $.querySelector("input#email_forgot");
    const Auth = $.querySelector(".auth")
    const Register = $.querySelector(".register")
    const Forgot = $.querySelector(".forgot")
    const elm_Forgot_Btn = $.querySelector(".forgot-password")
    const SendRequestDelay = 200; //ms
    const elm_BackLevel1 = $.querySelectorAll(".back-level-1")
    const elm_SendForgot = $.querySelector("#send-forgot")

    let change_data = null
    let title = $.querySelector("title").innerHTML;

    function errors_to_persian(error) {
        if (error === "email is required.") {
            return "ایمیل اجباری است."
        } else if (error === "email must be type email.") {
            return "ورودی باید از نوع ایمیل باشد."
        }
    }

    function show_errors(my_element, errorName, errors) {
        my_element.classList.add("invalid")
        let template = ''
        try {
            $.querySelector(".error-box").remove()
        } catch (error) {
        }
        template += '<div class="error-box mt-1">'
        switch (errorName) {
            case "email":
                errors.email.forEach(function (error) {
                    error = errors_to_persian(error)
                    template += `<span class="error text-[#FF5C00] mt-1 block">${error}</span>`;
                });
                break;
            default:
                console.error("not found errorName")
        }
        template += '</div>'
        my_element.insertAdjacentHTML("afterend", template)
        console.log(my_element)
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
            $.querySelector(".error-box").style.display = "none"
        } catch (error) {
        }
    }

    function back_level_1() {
        change_data = null
        Auth.style.right = "50%"
        Register.style.right = "200%"
        Forgot.style.right = "200%"
    }

    function show_loading_btn(element) {
        element.disabled = true;
        element.innerHTML = `<img id="loading" src='${APP_URL + "/" + "assets/images/loading.png"}' alt=''>`;
    }

    function send_request(btn, onload, method, url, data) {
        show_loading_btn(btn)
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

    $.addEventListener('visibilitychange', function () {
        if ($.visibilityState === 'hidden') {
            $.title = 'کجا رفتی؟ بیا😒';
        } else {
            $.title = title;
        }
    });

    elm_AuthBtn.addEventListener("click", function () {
        if (change_data !== elm_Email.value) {
            send_request(
                elm_AuthBtn,
                function (xhr) {
                    elm_AuthBtn.disabled = false;
                    if (JSON.parse(xhr.response).status === "Success") {
                        elm_AuthBtn.innerHTML = "مرحله بعد";
                        hide_errors()
                        Auth.style.right = "-100%"
                        Register.style.right = "50%"
                    } else {
                        elm_AuthBtn.innerHTML = "مرحله بعد";
                        let errors = JSON.parse(xhr.response).data.errors
                        show_errors(elm_Email, "email", errors)
                    }
                },
                "POST",
                APP_URL + "/" + "api/v1/auth",
                {email: elm_Email.value}
            )
            change_data = elm_Email.value
        }
    })

    elm_Forgot_Btn.addEventListener("click", function () {
        Auth.style.right = "-100%"
        Forgot.style.right = "50%"
        change_data = null
    })

    elm_BackLevel1.forEach((item) => {
        item.addEventListener("click", function () {
            back_level_1();
        })
    })

    elm_SendForgot.addEventListener("click", function () {
        if (change_data !== elm_ForgotEmail.value) {
            console.log("ok")
            send_request(
                elm_SendForgot,
                function (xhr) {
                    elm_SendForgot.disabled = false;
                    if (JSON.parse(xhr.response).status === "Success") {
                        elm_SendForgot.innerHTML = "بازیابی";
                        hide_errors()
                        Swal.fire({
                            title: "ایمیل ارسال شد.",
                            text: "ما براش شما ایمیلی فرستادیم.لطفا ایمیل خود را چک کنید.",
                            icon: "success",
                        });
                        document.querySelectorAll(".swal2-confirm").forEach((item) => {
                            let value = item.innerHTML
                            if (value === "OK") {
                                item.innerHTML = "باشه"
                            }
                        })
                    } else {
                        elm_SendForgot.innerHTML = "بازیابی";
                        let errors = JSON.parse(xhr.response).data.errors
                        show_errors(elm_ForgotEmail, "email", errors)
                    }
                },
                "POST",
                APP_URL + "/" + "api/v1/forgot_password",
                {email: elm_ForgotEmail.value}
            )
            change_data = elm_ForgotEmail.value
        }
    })
})