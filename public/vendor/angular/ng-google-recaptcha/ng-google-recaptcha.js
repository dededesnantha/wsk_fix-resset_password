'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

{
  (function () {
    'use strict';

    var RECAPTCHA_URL = 'https://www.google.com/recaptcha/api.js?onload=_ngGoogleRecaptchaOnloadCallback&render=explicit',
        CREATED_LOG_MSG = 'ngGoogleRecaptcha was successfully created with widgetId: {{id}}',
        RELOADED_LOG_MSG = 'ngGoogleRecaptcha with widgetId: {{id}} was reloaded';

    var RecaptchaFactory = function RecaptchaFactory($http, $log, $q) {
      var recaptchaScript = document.createElement('script'),
          recaptchaDeferred = $q.defer();

      recaptchaScript.src = RECAPTCHA_URL;
      recaptchaScript.async = true;
      recaptchaScript.defer = true;

      window._ngGoogleRecaptchaOnloadCallback = function () {
        recaptchaDeferred.resolve();
      };

      document.body.appendChild(recaptchaScript);

      var Recaptcha = function () {
        function Recaptcha(el, config) {
          var _this = this;

          _classCallCheck(this, Recaptcha);

          this.dom = this._defineDomElement(el);
          this.widgetId = null;
          this.isVerified = false;
          this.errors = [];

          this.config = {
            sitekey: this._domAttr('data-sitekey') || '',
            success: angular.noop,
            expired: angular.noop,
            created: angular.noop,
            theme: this._domAttr('data-theme') || 'light',
            type: this._domAttr('data-type') || 'image',
            size: this._domAttr('data-size') || 'normal',
            tabindex: this._domAttr('data-tabindex') || 0
          };

          this.callbacks = {
            success: function success() {
              var response = window.grecaptcha.getResponse(_this.widgetId);
              _this.config.success.call(_this, response);
            },
            expired: function expired() {
              _this.config.expired.call(_this, _this.widgetId);
            },
            created: function created(dom) {
              _this.config.created.call(_this, dom, _this.widgetId);
            }
          };

          this.setConfig(config);
        }

        _createClass(Recaptcha, [{
          key: 'render',
          value: function render() {
            recaptchaDeferred.promise.then(this._render.bind(this));
          }
        }, {
          key: 'reload',
          value: function reload() {
            var widgetId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.widgetId;

            if (widgetId === null) return;

            window.grecaptcha.reset(widgetId);
            this.errors = [];
            this.isVerified = false;
            this._log(RELOADED_LOG_MSG, { id: this.widgetId });
          }
        }, {
          key: 'verify',
          value: function verify(url) {
            var _this2 = this;

            var params = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
            var callback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : angular.noop;

            $http.get(url, params).success(function (response) {
              _this2.isVerified = true;
              _this2.errors = [];
              callback(response);
            });
          }
        }, {
          key: 'setConfig',
          value: function setConfig() {
            var config = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

            Object.assign(this.config, config);
          }

          /* Private */

        }, {
          key: '_render',
          value: function _render() {
            this.widgetId = window.grecaptcha.render(this.dom, {
              'sitekey': this.config.sitekey,
              'callback': this.callbacks.success,
              'expired-callback': this.callbacks.expired,
              'theme': this.config.theme,
              'type': this.config.type,
              'size': this.config.size,
              'tabindex': this.config.tabindex
            });
            this.dom.setAttribute('data-widgetid', this.widgetId);
            this.callbacks.created(this.dom);
            this._log(CREATED_LOG_MSG, { id: this.widgetId });
          }
        }, {
          key: '_defineDomElement',
          value: function _defineDomElement(el) {
            switch (true) {
              case window.jQuery && el instanceof window.jQuery:
                return el.get(0);
              case typeof el === 'string':
                return document.querySelector(el);
              case el instanceof Element:
                return el;
              case Array.isArray(el):
                return el[0];
              default:
                return el;
            }
          }
        }, {
          key: '_log',
          value: function _log(msg) {
            var attrs = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

            var pattern = void 0;
            for (var key in attrs) {
              pattern = new RegExp('{{' + key + '}}', 'g');
              msg = msg.replace(pattern, attrs[key]);
            }
            $log.debug(msg);
          }
        }, {
          key: '_domAttr',
          value: function _domAttr(attr) {
            if (this.dom === null) return null;
            return this.dom.getAttribute(attr);
          }
        }]);

        return Recaptcha;
      }();

      return {
        create: function create(el) {
          var config = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

          return new Recaptcha(el, config);
        }
      };
    };

    angular.module('ngGoogleRecaptcha', []).factory('recaptchaFactory', ['$http', '$log', '$q', RecaptchaFactory]);
  })();
}
