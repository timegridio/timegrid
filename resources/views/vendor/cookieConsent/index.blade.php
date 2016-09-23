@if($cookieConsentConfig['enabled'] && !$alreadyConsentedWithCookies)

    <style type="text/css">
    .cookie-tease {
        display: block;
        padding: 15px 20px;
        font-weight: 700;
        color: #8A6D3B;
        text-align: center;
        background-color: #FCF8E3;
    }
    </style>

    @include('cookieConsent::dialogContents')

    <script>

        window.laravelCookieConsent = (function () {

            function consentWithCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', 1, 365 * 20);
                hideCookieDialog();
            }

            function hideCookieDialog() {
                var dialogs = document.getElementsByClassName('js-cookie-consent');

                for (var i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = 'none';
                }
            }

            function setCookie(name, value, expirationInDays) {
                var date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value + '; ' + 'expires=' + date.toUTCString() +';path=/';
            }

            var buttons = document.getElementsByClassName('js-cookie-consent-agree');

            for (var i = 0; i < buttons.length; ++i) {
                buttons[i].addEventListener('click', consentWithCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

@endif
