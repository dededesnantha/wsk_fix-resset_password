        
        @if (count($web_review) != 0)                
        <section style="margin-bottom:40px;">        
            <div class="w3-light-grey w3-card-2" style="bottom: 15px;position: relative;">
                <h3 style="text-align: left;padding-left: 30px">Review</h3>
            </div>
            @foreach ($web_review as $item)            
                <article class="w3-row-padding" itemprop="review" itemscope itemtype="http://schema.org/Review">                                          
                    <div class="w3-col l12 m12 w3-margin-bottom" style="border-bottom: 1px solid #eee;">
                        <div class="w3-display-container">
                            <div class="w3-padding">
                                <div class="w3-col" style="margin-bottom: 15px;">
                                    <div class="w3-left-align" style="display: inline-flex;">
                                        
                                        @for ($i = 0; $i < (int)$item->count; $i++)                                            
                                            <span style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px">
                                                <i class="fa fa-circle" style="border: 2px solid #38AA4B;padding: 2px 2.5px;border-radius: 100%;color: #38AA4B;height: 23px;width: 22px;font-size: 15px;display: inline-block;"></i>
                                            </span>
                                        @endfor
                                        
                                        @for ($i = 0; $i < (5- (int)$item->count); $i++)
                                            <span style="font-size: 20px;color: #504f4f;background: transparent;padding: 0 5px">
                                                <i class="fa fa-circle" style="border: 2px solid #504f4f;padding: 2px 2.5px;border-radius: 100%;color: #504f4f;height: 23px;width: 22px;font-size: 15px;display: inline-block;"></i>
                                            </span>
                                        @endfor
                                        
                                    </div>                                    

                                    <small style="color: #545454;"><i itemprop="datePublished" content="{{$item->created_at}}">{{$item->filter_created_at}}</i></small>
                                    <h3 style="margin:5px 3px;2px 3px" itemprop="name">{{$item->subject}}</h3>
                                    <div style="margin-bottom:5px;margin-left:3px;">
                                        <small>From : </small><small itemprop="author">{{$item->name}}</small>
                                    </div>
                                    <div style="font-size: 13.5px;padding-left: 3px;line-height: 1.7;">                                
                                        {{$item->message}}
                                    </div>                                
                                </div>
                            </div> 
                        </div>            
                    </div>
                </article>            
            @endforeach
            <center class="w3-row-padding">                    
                @if ($foot == 'paging')                    
                    <?php echo $web_review->render(); ?>    
                @elseif ($foot == 'show-more')                                            
                    <a href="{{url('review.html')}}" title="review" class="w3-button w3-black">Show More Review <i class="fa  fa-external-link"></i></a>
                @endif                            
            </center>
        </section>
        @endif