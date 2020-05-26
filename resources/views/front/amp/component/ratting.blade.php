    <div style="border: 1px solid #ececec;padding-bottom: 2px;padding-top: 5px;border-top: 0;background:#f1f1f1"> 
        <div class="w3-left-align" style="display: inline-flex;margin-left: 5px;" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
            @for ($i=0; $i < (int)$review_ratting; $i++)    
                <span style="font-size: 16px;color: #504f4f;background: transparent;padding: 0 5px">
                    <i class="fa fa-star" style="color: #f9e54d"></i>
                </span>
            @endfor

            <span style="padding: 4px;font-size: 12.5px;font-weight: 500;letter-spacing: 0px;color: #525252;font-style: italic;top: 1px;position: relative;"> 
                <span itemprop="ratingValue">{{ $review_ratting }}</span> / <span itemprop="reviewCount">{{ $review_total }}</span> Reviews
            </span>    
        </div>
        <small class="w3-text-grey" style="float: right;position: inherit;padding-right: 10px;font-size: 14px;">
            <i class="fa fa-eye"></i> <small>{{ @$single->view }} view</small>
        </small>
    </div>