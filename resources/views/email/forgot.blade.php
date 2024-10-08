<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        @font-face {
            font-family: "estedad";
            font-weight: 100;
            src: url({{ asset("assets/fonts/Estedad-Thin.ttf") }});
        }

        @font-face {
            font-family: "estedad";
            font-weight: 300;
            src: url({{ asset("assets/fonts/Estedad-Light.ttf") }});
        }

        @font-face {
            font-family: "estedad";
            font-weight: 400;
            src: url({{ asset("assets/fonts/Estedad-Medium.ttf") }});
        }

        @font-face {
            font-family: "estedad";
            font-weight: 700;
            src: url({{ asset("assets/fonts/Estedad-Bold.ttf") }});
        }

        @font-face {
            font-family: "estedad";
            font-weight: 900;
            src: url({{ asset("assets/fonts/Estedad-Black.ttf") }});
        }

        * {
            font-family: "estedad",IRANYekan,"Segoe UI", sans-serif;
            direction: rtl;
        }
    </style>
</head>
<body>
<center style="">
    <div style="background-color: rgba(255, 92, 0, 0.06);width: 450px;border-radius: 20px;padding-right: 50px;padding-left: 50px">
        <a href="/"
           style="display: inline-block;width: 130px;padding: 20px;height: 130px;border-radius: 40px;background-color: white;margin-top: 20px">
            <img src="{{ asset("assets/images/salam.svg") }}" alt="logo" style="width: 100%;height: 100%">
        </a>
        <h1 style="font-size: 30px;font-weight: bold;margin: 0;color: black;">بازیابی رمز عبور</h1>
        <h1 style="font-size: 30px;font-weight: bold;margin: 0;color: #FF5C00;">سلام {{ $name }}</h1>
        <p style="width: 300px;font-size: 15px;color: #444444;margin: 5px 0 0 0;font-family: sans-serif">برای بازیابی رمز عبورت کافیه روی دکمه
            زیر بزنی تا به سایت منتقل بشی و بتونی رمز جدیدتو انتخاب کنی! میبینی چقدر راحته😉</p>
        <a href="{{ $url }}"
           style="width: 100%;height: 50px;border-radius: 15px;margin-top: 15px;margin-bottom:20px;background-color: #276EF6;display: inline-block;color: white;text-align: center;text-decoration: none;font-size: 18px;padding-top: 15px">بازیابی</a>
    </div>
</center>
</body>
</html>