# ng-google-recaptcha

> AngularJS 1.x module that implements [Google's I'm not robot (reCaptcha)][recaptcha]

This module lets you to create and manage as many reCaptcha instances, as you want.

### Installation

**bower**
  ```
  bower install --save ng-google-recaptcha
  ```

**npm**
  ```
  npm install --save ng-google-recaptcha
  ```

### Usage

- Get recaptcha key for your domain [here][recaptcha].

- Include ng-google-recaptcha script.
```
<script src="ng-google-recaptcha.js"></script>
```

- Add ngGoogleRecaptcha to your app dependencies
```
var app = angular.module('myApp', ['ngGoogleRecaptcha']);
```

- Place a container to render recaptcha
```
<div class="my-recaptcha" data-sitekey="YOUR SITE KEY"></div>
```
> Note: You may define site key in js code, to make it reusable (for example, if you have more than 1 instances of recaptcha).

- Create and render recaptcha instance
```
var myCtrl = function (recaptchaFactory) {
    var recaptcha = recaptchaFactory.create('.my-recaptcha', {
        sitekey: 'yoursitekey'
    });
    recaptcha.render();
}

angular
    .module("app", ['ngGoogleRecaptcha'])
    .controller("myCtrl", [
        'recaptchaFactory',
        myCtrl
    ]);
```

- Define callbacks (optionally)
```
var callbacks = {
    /* executes when recaptcha is successfully rendered on page */
    created: function (widgetId) {
        console.log("I'm created with widgetId: " + widgetId);
    },
    /* executes when user submits successfull recaptcha response */
    success: function (response) {
        console.log('Successfully got response from Google:', response);
        var params = {
            response: response
        };
        /* makes GET request to given url with some params and executes callback on success */
        recaptcha.verify('/your_verification_url', params, function(data){
            console.log('Verified and get response: ', data);
        });
    },
    /* executes when recaptcha response expires */
    expired: function (widgetId) {
        console.log("Recaptcha with widgetId: " + widgetId + " is expired");
        recaptcha.reload();
    }
}
recaptcha.setConfig(callbacks);
recaptcha.render();
```

- Customize look (optional)
```
var lookConfig = {
    /* 'light' by default */
    theme: 'dark',
    /* 'image' by default */
    type: 'audio',
    /* 'normal' by default */
    size: 'compact',
    /* 0 by default */
    tabindex: 1
};
recaptcha.setConfig(lookConfig);
```

> Note: Better to define config before `render`

### License

[MIT License][mit]



[recaptcha]: <http://www.google.com/recaptcha>
[mit]: <https://en.wikipedia.org/wiki/MIT_License>
