<div class="container pb-70 v-box-stories" data-aos="fade-up" data-aos-duration="2000">
    @if($stories)
        <?php
            $i = 1; 
            $indicator = 0;
        ?>
        @foreach($stories as $story)
            <?php 
                $indicator = $i;
                // if($indicator%6==0){
                //     $i = 1;
                // }
            ?>
            @if($i==1)
                <a href="#link" class="v-stories" data-aos="fade-up" data-aos-duration="2000">
                    <div class="row mb-5 align-items-center">
                        <div class="col-md-5">
                            <div class="v-stories-img">
                                <div class="v-stories-img-slide">
                                    <img src="{{ asset('storage/'.$story->image)}}" alt="Stories">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 pt-lg-3">
                            <h3 class="v-title text-black ps-220">{{ $story->title }}</h3>
                            <h6 class="text-black ps-220"><b>Category:</b> {{ $story->category->name }}</h6>
                        </div>
                    </div>
                </a>
            @endif
            @if( $i > 1 && $i<=6)
                @if($i==2)
                <div class="row mb-lg-5 align-items-center justify-content-between">
                @endif
                    <div class="col-md-6 mb-5">
                        <a href="#link" class="v-stories-box" data-aos="fade-up" data-aos-duration="2000">
                            <div class="v-stories-img">
                                <div class="v-stories-img-slide">
                                    <img src="{{ asset('storage/'.$story->image)}}" alt="Stories">
                                </div>
                            </div>
                            <h3 class="v-title text-black">
                                {{ $story->title }}
                            </h3>
                            <h6 class="text-black"><b>Category:</b> {{ $story->category->name }}</h6>
                        </a>
                    </div>
                @if($i%2!=0)
            </div>
            <div class="row mb-lg-5 align-items-center justify-content-between">
            @endif
            @if($i==6)
            </div>
            @endif
            @endif
        <?php $i++;?>
        @endforeach
    @endif
</div>