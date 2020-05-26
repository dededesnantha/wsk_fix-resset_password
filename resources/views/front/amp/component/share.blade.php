    <div class="m-t-20 p-0-10">
        <strong class="share"> Share : </strong> 
        <a href="mailto:?Subject={{@$single->judul}}&amp;Body={{@$single->judul}} {{Request::fullUrl()}}" target="_blank" class="no-decoration" >          
        <amp-img alt="Email"
            src="{{asset('img/icon')}}/email.png"
            width="30px"
            height="30px" class="share-email">
        </amp-img>
        </a>
        <a href="whatsapp://send?text={{@$single->judul}} {{Request::fullUrl()}}" target="_blank" class="no-decoration" >          
        <amp-img alt="whatsapp"
            src="{{asset('img/icon')}}/wa.png"
            width="30px"
            height="30px" class="share-wa">
        </amp-img>
        </a>
        <a href="https://lineit.line.me/share/ui?url={{Request::fullUrl()}}" target="_blank" class="no-decoration">          
        <amp-img alt="line"
            src="{{asset('img/icon')}}/line.png"
            width="30px"
            height="30px" class="share-line">
        </amp-img>
        </a>
        <a href="http://www.facebook.com/sharer.php?u={{Request::fullUrl()}}" target="_blank" class="no-decoration">          
        <amp-img alt="facebook"
            src="{{asset('img/icon')}}/facebook.png"
            width="30px"
            height="30px" class="share-facebook">
        </amp-img>
        </a>
        <a href="https://twitter.com/share?url={{Request::fullUrl()}}&amp;text={{@$single->judul}}&amp;hashtags={{@$single->judul}}" target="_blank" class="no-decoration">          
        <amp-img alt="twitter"
            src="{{asset('img/icon')}}/twitter.png"
            width="30px"
            height="30px" class="share-twitter">
        </amp-img>
        </a>
    </div>