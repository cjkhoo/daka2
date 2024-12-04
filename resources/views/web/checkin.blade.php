@extends('layouts.web')
@section('title', '登入頁面')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <p><h2>{{config('view.company.name')}}</h2></p>
            <div class="card">
                <div class="card-header">打卡     <a  href="{{ route('logout') }}" class="btn btn-danger d-inline" style="float: right">登出</a> <a  href="{{ route('password.change') }}" class="btn d-inline btn-secondary" style="float: right;margin-right:5px">换密码</a><a  href="{{ route('location.change') }}" class="btn d-inline btn-secondary" style="float: right;margin-right:5px">换地点</a></div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div id="successAlert" class="alert alert-success  d-none" role="alert"></div>
                    <div id="errorAlert" class="alert alert-danger d-none" role="alert"></div>
                        <div class="form-group">
                           <button onclick="window.location.reload();">請點擊刷新按鈕</button>
                        </div>
                        <div class="form-group">
                            <label for="username">姓名： {{$user->name}}<br>日期時間: {{$currentDateTime}}</label>                 
                        </div>
                         <div class="form-group">
                            <label>顯示定位地點： {{$location->loc_name??"還沒有固定工作地點"}}</label> <br>
                            <label id="location" for="location"> </label> <br>               
                            <label id="distance">請稍等</label>                     

                        </div>
                        <div class="form-group">
 <!--                      <input id="latitude" type="text" name="latitude" value="" />
                            <input id="longitude" type="text" name="longitude" value="" /> -->
                                                       
                           <!--  <button class="btn btn-secondary " onclick="getLocation()">定位</button> -->        

                        </div>
                        @if(isset($location->id))
                          <div class="form-group">     
                           
                            <input type="button"  onclick="checkin()" class="btn btn-primary d-inline" value="上班" />
                            <input type="button"  onclick="checkout()" class="btn btn-danger d-inline" value="下班" />
                         </div>
                         @else
                         請請管理員安排固定工作地點
                         @endif

                         <div class="form-group">
                            <a href="{{route('checkin.list')}}">打卡總表</a>
                        </div>
                  
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
        const checkinData = {};
        getLocation();
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                document.getElementById("location").innerHTML = "Geolocation is not supported by this browser.";
            }
        }
         function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById("location").innerHTML = "緯度: " + latitude + ", 經度: " + longitude;

            checkinData.latitude=latitude;
            checkinData.longitude=longitude;
            checkinData.loc_latitude= {{$location->latitude??''}};
            checkinData.loc_longitude= {{$location->longitude??''}};
            //const distance=haversineDistance(checkinData.latitude,checkinData.longitude,checkinData.loc_latitude,checkinData.loc_longitude);
            //console.log(checkinData.latitude+","+checkinData.longitude+","+checkinData.loc_latitude+","+checkinData.loc_longitude);
            checkinData.distance=haversineDistance(checkinData.latitude,checkinData.longitude,checkinData.loc_latitude,checkinData.loc_longitude);
            document.getElementById("distance").innerHTML =checkinData.loc_latitude+","+checkinData.loc_longitude+"<br>"+checkinData.distance.toFixed(6)+'M';
        
          }
            function haversineDistance(lat1, lon1, lat2, lon2) {
            const R = 6371000; // Earth's radius in meters
        
            // Convert degrees to radians
            const toRadians = (degree) => degree * (Math.PI / 180);
            
            const a1 = toRadians(lat1);
            const b1 = toRadians(lat2);
            const c1 = toRadians(lat2 - lat1);
            const d1 = toRadians(lon2 - lon1);
        
            // Haversine formula
            const a = Math.sin(c1 / 2) ** 2 + 
                      Math.cos(a1) * Math.cos(b1) * 
                      Math.sin(d1 / 2) ** 2;
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        
            // Distance in meters
            const distance = R * c;
            return distance;
        }


        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    document.getElementById("location").innerHTML = "使用者拒絕了地理位置請求。";
                    break;
                case error.POSITION_UNAVAILABLE:
                    document.getElementById("location").innerHTML = "無法獲取位置信息。";
                    break;
                case error.TIMEOUT:
                    document.getElementById("location").innerHTML = "請求獲取用戶位置超時。";
                    break;
                case error.UNKNOWN_ERROR:
                    document.getElementById("location").innerHTML = "發生未知錯誤。";
                    break;
            }

        }
        
        function checkin() {

                if(!checkinData.latitude){
                    alert('無法獲取位置信息, 請允許位置許可');
                    return false;
                }

                if(checkinData.distance>300){
                    alert('請點擊刷新按鈕');
                     return false;
                    
                }
                
                

               fetch('{{route('checkin')}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: checkinData.latitude,
                    longitude: checkinData.longitude,
                    loc_latitude: {{$location->latitude??''}},
                    loc_longitude: {{$location->longitude??''}}
                })
            })
             .then(response => {
        return response.json().then(data => ({ status: response.status, body: data }));
    })
             .then(({ status, body }) => {
                // document.getElementById("location").innerHTML = "";
                Object.assign(checkinData, {});
              
                if (status === 200) {
                    // Success case
                      document.getElementById("distance").innerHTML = '<p>距離工作定點是: '+body.distance+'m';
                    $('#successAlert').text(body.message).removeClass('d-none');
                    $('#errorAlert').addClass('d-none');
                    window.location.href="{{route('checkin.list')}}"
                    // window.location.href="{{route('checkin.list')}}"
                } else {
                    // Error case

                    $('#errorAlert').text(body.message).removeClass('d-none');
                    $('#successAlert').addClass('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function checkout() {
            
              if(!checkinData.latitude){
                    alert('無法獲取位置信息, 請允許位置許可');
                    return false;
                }
                if(checkinData.distance>300){
                    alert('請點擊刷新按鈕');
                      return false;  
                }

            
               fetch('{{route('checkout')}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: checkinData.latitude,
                    longitude: checkinData.longitude,
                    loc_latitude: {{$location->latitude??''}},
                    loc_longitude: {{$location->longitude??''}}
                })
            })
             .then(response => {
                return response.json().then(data => ({ status: response.status, body: data }));
            })
             .then(({ status, body }) => {
           
                Object.assign(checkinData, {});
              

                if (status === 200) {
                    // Success case
                    document.getElementById("distance").innerHTML = '<p>距離工作定點是: '+body.distance+'m';
                    $('#successAlert').text(body.message).removeClass('d-none');
                    $('#errorAlert').addClass('d-none');
                    window.location.href="{{route('checkin.list')}}"
                } else {
                    // Error case
                    $('#errorAlert').text(body.message).removeClass('d-none');
                    $('#successAlert').addClass('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }


 </script>


@endsection