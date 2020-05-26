    <div class="w3-row-padding" style="border: 1px solid #cacaca;margin-bottom: 35px;">
        <div>
            <h3 style="text-align: left;font-weight: 700;padding: 11px;border-bottom: 1.4px solid #eee;padding-top: 7px;">Review</h3>
        </div>
        <form action="{{ url('send_review') }}" method="POST">
            {{ csrf_field() }}
            <div class="w3-row-padding">
                <div class="w3-col l6 m6 ">
                    <span>Your Name : </span>
                    <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="your name" name="name"></p>
                </div>
                <div class="w3-col l6 m6  ">
                    <span>Email : </span>
                    <p><input class="w3-input w3-padding-16 w3-border" type="email" placeholder="your email" name="email"></p>
                </div>
                <div class="w3-col l12 m12">
                    <span>Subject : </span>
                    <p><input class="w3-input w3-padding-16 w3-border" type="text" placeholder="your subject" name="subject"></p>
                </div>
                <div class="w3-col l3 m3 ">
                    <span class="w3-tag w3-light-grey w3-wide w3-card-2" style="position: relative;top: 10px;">Give Poin</span>
                </div>
                <div class="w3-col l6 m6 ">
                    
                    <div class="w3-left-align" id="round" style="display: inline-flex;">
                        <label for="round1" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="round(1)"><i class="fa fa-circle" style="border: 2px solid #504f4f;padding: 1px 2.2px;border-radius: 100%;width: 25.5px;font-size: 19.3px;height: 25.5px;color: #504f4f;"></i></label>
                        <label for="round2" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="round(2)"><i class="fa fa-circle" style="border: 2px solid #504f4f;padding: 1px 2.2px;border-radius: 100%;width: 25.5px;font-size: 19.3px;height: 25.5px;color: #504f4f;"></i></label>
                        <label for="round3" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="round(3)"><i class="fa fa-circle" style="border: 2px solid #504f4f;padding: 1px 2.2px;border-radius: 100%;width: 25.5px;font-size: 19.3px;height: 25.5px;color: #504f4f;"></i></label>
                        <label for="round4" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="round(4)"><i class="fa fa-circle" style="border: 2px solid #504f4f;padding: 1px 2.2px;border-radius: 100%;width: 25.5px;font-size: 19.3px;height: 25.5px;color: #504f4f;"></i></label>
                        <label for="round5" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="round(5)"><i class="fa fa-circle" style="border: 2px solid #504f4f;padding: 1px 2.2px;border-radius: 100%;width: 25.5px;font-size: 19.3px;height: 25.5px;color: #504f4f;"></i></label>
                    </div>
                    
                    {{ csrf_field() }}

                
                    <input type="radio" name="count" value="1" id="round1"  hidden />
                    <input type="radio" name="count" value="2" id="round2"  hidden />
                    <input type="radio" name="count" value="3" id="round3"  hidden />
                    <input type="radio" name="count" value="4" id="round4"  hidden />
                    <input type="radio" name="count" value="5" id="round5"  hidden />

                </div>
                <div class="w3-col l12 m12 ">
                    <span>Message :</span>            
                    <textarea name="message" id="message" cols="30" rows="5" class="w3-input w3-padding-16 w3-border"></textarea>
                </div>
                <div class="w3-col l12 m12  ">
                    <br>
                    <div class="g-recaptcha" data-sitekey="{{env('CAPCHA_KEY')}}"></div>
                </div>
                <div class="w3-col l12 m12  ">
                    <p style="text-align:right"><button class="w3-button w3-black" type="submit">{{ $main['label']['Submit'] }}</button></p>
                </div>
            </div>
        </form>
    </div>
    