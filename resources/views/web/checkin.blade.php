@extends('layouts.web')
@section('title', '登入頁面')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <p><h2>{{config('view.company.name')}}</h2></p>
            <div class="card">
                <div class="card-header">打卡     <a  href="{{ route('logout') }}" class="btn btn-danger d-inline" style="float: right">登出</a> <a  href="{{ route('password.change') }}" class="btn d-inline btn-secondary" style="float: right;margin-right:5px">换密码</a></div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div id="successAlert" class="alert alert-success  d-none" role="alert"></div>
                    <div id="errorAlert" class="alert alert-danger d-none" role="alert"></div>
                   
                        <div class="form-group">
                            <label for="username">姓名： {{$user->name}}<br>日期時間: {{$currentDateTime}}</label>                 
                        </div>
                         <div class="form-group">
                            <label>顯示定位地點： {{$location->loc_name??"還沒有固定工作地點"}}</label> <br>
                            <label id="location" for="location"> </label> <br>               
                            <label id="distance"> </label>                     

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
            checkinData.loc_longitude= {{$location->latitude??''}};
           
        
            // fetch('{{route('validatelocation')}}', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     },
            //     body: JSON.stringify({
            //         latitude: latitude,
            //         longitude: longitude,
            //         loc_latitude: {{$location->latitude??''}},
            //         loc_longitude: {{$location->longitude??""}}
            //     })
            // })
            // .then(response => response.json())
            // .then(data => {
              
            //          checkinData.distance=data.distance;
            //       document.getElementById("distance").innerHTML = '<p>距離工作定點是: '+data.distance+'m';
            //         $('#successAlert').text('定位成功').removeClass('d-none');
            //         $('#errorAlert').addClass('d-none');
            // })
            // .catch(error => {
            //     console.error('Error:', error);
            // });
           
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