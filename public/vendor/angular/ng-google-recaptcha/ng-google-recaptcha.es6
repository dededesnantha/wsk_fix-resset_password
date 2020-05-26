{
  'use strict';

  const RECAPTCHA_URL = 'https://www.google.com/recaptcha/api.js?onload=_ngGoogleRecaptchaOnloadCallback&render=explicit',
        CREATED_LOG_MSG = 'ngGoogleRecaptcha was successfully created with widgetId: {{id}}',
        RELOADED_LOG_MSG = 'ngGoogleRecaptcha with widgetId: {{id}} was reloaded';

  let RecaptchaFactory = function ($http, $log, $q) {
    let recaptchaScript = document.createElement('script'),
        recaptchaDeferred = $q.defer();

    recaptchaScript.src = RECAPTCHA_URL;
    recaptchaScript.async = true;
    recaptchaScript.defer = true;

    window._ngGoogleRecaptchaOnloadCallback = () => {
      recaptchaDeferred.resolve();
    };

    document.body.appendChild(recaptchaScript);

    class Recaptcha {
      constructor (el, config) {
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
          success: () => {
            let response = window.grecaptcha.getResponse(this.widgetId);
            this.config.success.call(this, response);
          },
          expired: () => { this.config.expired.call(this, this.widgetId); },
          created: (dom) => { this.config.created.call(this, dom, this.widgetId); }
        };

        this.setConfig(config);
      }

      render () {
        recaptchaDeferred.promise.then(this._render.bind(this));
      }

      reload (widgetId = this.widgetId) {
        if (widgetId === null) return;

        window.grecaptcha.reset(widgetId);
        this.errors = [];
        this.isVerified = false;
        this._log(RELOADED_LOG_MSG, {id: this.widgetId});
      }

      verify (url, params = {}, callback = angular.noop) {
        $http
          .get(url, params)
          .success((response) => {
            this.isVerified = true;
            this.errors = [];
            callback(response);
          });
      }

      setConfig (config = {}) {
        Object.assign(this.config, config);
      }

      /* Private */

      _render () {
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
        this._log(CREATED_LOG_MSG, {id: this.widgetId});
      }

      _defineDomElement (el) {
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

      _log (msg, attrs = {}) {
        let pattern;
        for (let key in attrs) {
          pattern = new RegExp(`{{${key}}}`, 'g');
          msg = msg.replace(pattern, attrs[key]);
        }
        $log.debug(msg);
      }

      _domAttr (attr) {
        if (this.dom === null) return null;
        return this.dom.getAttribute(attr);
      }
    }

    return {
      create: (el, config = {}) => {
        return new Recaptcha(el, config);
      }
    };
  }

  angular.module('ngGoogleRecaptcha', [])
    .factory('recaptchaFactory', [
    	'$http',
      '$log',
      '$q',
      RecaptchaFactory
    ]);
}
