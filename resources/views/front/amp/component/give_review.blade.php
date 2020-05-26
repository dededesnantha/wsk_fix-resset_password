    <form action="{{ url('give_review/'.$param) }}" method="POST" accept-charset="utf-8" id="form_review" style="text-align: center;">
        <span>{{ $main['label']['Give Review'] }} :</span>
        <div class="w3-left-align" id="rating" style="display: inline-flex;">
          <label for="rating1" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="rating(1)"><i class="fa fa-star"></i></label>          
          <label for="rating2" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="rating(2)"><i class="fa fa-star"></i></label>
          <label for="rating3" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="rating(3)"><i class="fa fa-star"></i></label>          
          <label for="rating4" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="rating(4)"><i class="fa fa-star"></i></label>          
          <label for="rating5" style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px" onclick="rating(5)"><i class="fa fa-star"></i></label>
        </div>
        <!-- <button type="submit" class="w3-button w3-black" id="btn_review" disabled="true">Review</button> -->
        {{ csrf_field() }}
        <input type="hidden" name="slug" value="{{$single->slug}}" >
        <input type="radio" name="rating" value="1" id="rating1"  hidden>
        <input type="radio" name="rating" value="2" id="rating2"  hidden>
        <input type="radio" name="rating" value="3" id="rating3"  hidden>
        <input type="radio" name="rating" value="4" id="rating4"  hidden>
        <input type="radio" name="rating" value="5" id="rating5"  hidden>
    </form>