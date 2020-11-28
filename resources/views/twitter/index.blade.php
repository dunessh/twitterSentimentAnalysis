@extends('layouts.app')

@section('content')


<h1>User Twitter Profile</h1>
    
<div class="container">
   
       <div class="row">
          <div class="col-sm-4">

            <div class="card">
                <img src="{{($profile_image)}}" alt="John" style="width:100%">
                <h1>{{($screen_name)}}</h1>
            <p class="title">Status count {{$statuses_count}}</p>
            <p>Followers count {{$followers_count}}</p>
            <p>Created at {{$created_at}}</p>
              </div>
             
        
            </div>
          
          <div class="col-sm-8">
            @if(!empty($data))

            @foreach($data as $key => $value)

                
                @if(!empty($value['extended_entities']['media']))
                <div class="w3-content" style="max-width:800px">
                   
                    @foreach($value['extended_entities']['media'] as $v)
                    
                        <img class="mySlides" src="{{ $v['media_url_https'] }}" style="width:100%;">
                        
                    @endforeach
                  </div>
                    
                @endif


            @endforeach
                  
            <div class="w3-center">
                <div class="w3-section">
                  <button class="w3-button w3-light-grey" onclick="plusDivs(-1)">❮ Prev</button>
                  <button class="w3-button w3-light-grey" onclick="plusDivs(1)">Next ❯</button>
                </div>
              </div>





            @else
            <tr>
                <td colspan="6">There are no data.</td>
            </tr>
            @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-8"><a href="/analyze">Analyze your Images</a></div>
            <div class="col-sm-4"></div>
        </div>
        
      </div>

      <script>
        var slideIndex = 1;
        showDivs(slideIndex);
        
        function plusDivs(n) {
          showDivs(slideIndex += n);
        }
        
        function currentDiv(n) {
          showDivs(slideIndex = n);
        }
        
        function showDivs(n) {
          var i;
          var x = document.getElementsByClassName("mySlides");
          var dots = document.getElementsByClassName("demo");
          if (n > x.length) {slideIndex = 1}    
          if (n < 1) {slideIndex = x.length}
          for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";  
          }
          for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" w3-red", "");
          }
          x[slideIndex-1].style.display = "block";  
          dots[slideIndex-1].className += " w3-red";
        }
        </script>
          
@endsection
