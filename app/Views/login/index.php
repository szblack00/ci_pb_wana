<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PB WANA PUTRA | Login</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css?v=3.2.0">
    <script nonce="b2a469c2-7a52-4dac-8453-226583bcf64b">
    (function(w, d) {
        ! function(a, e, t, r) {
            a.zarazData = a.zarazData || {};
            a.zarazData.executed = [];
            a.zaraz = {
                deferred: []
            };
            a.zaraz.q = [];
            a.zaraz._f = function(e) {
                return function() {
                    var t = Array.prototype.slice.call(arguments);
                    a.zaraz.q.push({
                        m: e,
                        a: t
                    })
                }
            };
            for (const e of ["track", "set", "ecommerce", "debug"]) a.zaraz[e] = a.zaraz._f(e);
            a.zaraz.init = () => {
                var t = e.getElementsByTagName(r)[0],
                    z = e.createElement(r),
                    n = e.getElementsByTagName("title")[0];
                n && (a.zarazData.t = e.getElementsByTagName("title")[0].text);
                a.zarazData.x = Math.random();
                a.zarazData.w = a.screen.width;
                a.zarazData.h = a.screen.height;
                a.zarazData.j = a.innerHeight;
                a.zarazData.e = a.innerWidth;
                a.zarazData.l = a.location.href;
                a.zarazData.r = e.referrer;
                a.zarazData.k = a.screen.colorDepth;
                a.zarazData.n = e.characterSet;
                a.zarazData.o = (new Date).getTimezoneOffset();
                a.zarazData.q = [];
                for (; a.zaraz.q.length;) {
                    const e = a.zaraz.q.shift();
                    a.zarazData.q.push(e)
                }
                z.defer = !0;
                for (const e of [localStorage, sessionStorage]) Object.keys(e || {}).filter((a => a.startsWith(
                    "_zaraz_"))).forEach((t => {
                    try {
                        a.zarazData["z_" + t.slice(7)] = JSON.parse(e.getItem(t))
                    } catch {
                        a.zarazData["z_" + t.slice(7)] = e.getItem(t)
                    }
                }));
                z.referrerPolicy = "origin";
                z.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(a.zarazData)));
                t.parentNode.insertBefore(z, t)
            };
            ["complete", "interactive"].includes(e.readyState) ? zaraz.init() : a.addEventListener(
                "DOMContentLoaded", zaraz.init)
        }(w, d, 0, "script");
    })(window, document);
    </script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div>
            <center>
                <img src="<?= base_url(); ?>/dist/img/Wps.png" class="brand-image img-circle elevation-6"
                    style="opacity: .8" width="20%">
            </center>
        </div>
        <div class="login-logo">
            <a href="<?= base_url() ?>/index2.html"><b>E PROCUREMENT</b> WANA</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <?= form_open('login/cekUser') ?>
                <?= csrf_field(); ?>
                <p class="login-box-msg">Silahkan Login </p>
                <form action="<?= base_url() ?>/index3.html" method="post">
                    <div class="input-group mb-3">

                        <?php
                        $isInvalidUser = (session()->getFlashdata('errIdUser')) ? 'is-invalid' : '';
                        ?>
                        <input type="Text" class="form-control <?= $isInvalidUser ?> " placeholder="Username"
                            name="iduser" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <?php
                        if (session()->getFlashdata('errIdUser')) {
                            echo ' <div class="invalid-feedback">' . session()->getFlashdata('errIdUser') . ' </div>';
                        } ?>
                    </div>
                    <div class="input-group mb-3">
                        <?php
                        $isInvalidPassword = (session()->getFlashdata('errPassword')) ? 'is-invalid' : '';
                        ?>
                        <input type="Password" class="form-control <?= $isInvalidPassword; ?>" name="password"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <?php
                        if (session()->getFlashdata('errPassword')) {
                            echo ' <div class="invalid-feedback">' . session()->getFlashdata('errPassword') . ' </div>';
                        } ?>
                    </div>

                    <div class="input-group mb-3">
                        <button type="submit" class="btn btn-block btn-success">Login</button>
                    </div>
                    <?= form_close() ?>
                </form>
            </div>
        </div>




    </div>



    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>

    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url() ?>/dist/js/adminlte.min.js?v=3.2.0"></script>
</body>

</html>