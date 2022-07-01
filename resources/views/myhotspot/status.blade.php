@extends('myhotspot.layout')


@section('content')
    @minify('html')
    <div class="container">
        <div class="d-flex justify-content-center h-100">
          
            <div class="card">
              
                    @if($mybannerenable)
                    <div class="carousel-container">
                        <div id="mycarousel" class="carousel carousel-fade slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($mybanners as $key => $banner)
                                <li data-target="#mycarousel" data-slide-to="{{$key}}" @if($key == 0) class="active" @endif></li>
                                @endforeach
                              </ol>                        
                            <div class="carousel-inner ">                            
                                @foreach($mybanners as $key => $banner)
                                  <div class="carousel-item @if($key == 0) active @endif">
                                    <img class="d-block w-100" src="{{$banner->image}}" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{$banner->text}}</h5>
                                    </div>
                                  </div>                            
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#mycarousel" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#mycarousel" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                            </a>
                        </div> 
                    </div>
                    @else
                    <div class="mt-5 pt-5"></div>
                    @endif   
                     
                <div class="card-body ">
                  
                    <div class="tab-content">
                        <div id="member" class="tab-pane text-light mb-3 active">
                            <div class="container mb-2">
                                <div class="text-center">
                                    <div class="text-center text-light small">
                                        @isset($uid)
                                            ID: {{ $uid }}
                                        @endisset
                                    </div>
                                    <div class="text-center text-light small">
                                        @isset($ip)
                                            IP: {{ $ip }}
                                        @endisset
                                    </div>
                                    <div class="text-center text-light small">
                                        @isset($mac)
                                            MAC: {{ $mac }}
                                        @endisset
                                    </div>
                                    <div id="timeleft" class="text-center text-light small">
                                        @isset($timeleft)
                                            00 : 00 : 00 : 00
                                        @endisset
                                    </div>
                                    <div class="text-center text-light small">
                                        @isset($sessiontime)
                                            SESSION-TIME: {{ $sessiontime }}
                                        @endisset
                                    </div>
                                    <div class="text-center text-light small">
                                        @isset($sessionid)
                                            SESSION: {{ $sessionid }}
                                        @endisset
                                    </div>
                                </div>
                            </div>
                            <form name="mylogin" action="http://{{ $myuamip }}:{{ $myuamport }}/login" method="get">
                                <input type="hidden" name="username" />
                                <input type="hidden" name="response" />
                                <input type="hidden" name="userurl" value="{{ $userurl }}" />
                            </form>
                            <form name="login" onSubmit="return doLogin()">
                                <div class="input-group form-group">
                                    @if($mymembershipenable)
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>                                    
                                        <input type="text" class="form-control" placeholder="username" name="username" required>
                                    @else
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-ticket-alt"></i></span>
                                    </div>                                    
                                        <input type="text" class="form-control" placeholder="voucher" name="username" required>
                                    @endif
                                </div>
                                @if($mymembershipenable)
                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="password" name="password">
                                </div>
                                @endif
                                <div class="form-group">
                                    <input type="submit" value="Login" class="btn float-right login_btn">
                                    @if ($res == 'notyet' || $res == 'failed' || $res == 'logoff')
                                        @if($mytrialenable)
                                        <input type="button" value="{{$mytrialtext}}" class="btn float-right login_btn">
                                        @endif
                                    @endif                                     
                                </div>
                            </form>
                            @if ($res == 'already' || $res == 'success')
                            <form name="logout" onSubmit="return doLogout()"
                            class="mt-3">            
                                @csrf
                                <input type="submit" value="Logout" class="btn float-right login_btn">
                            </form>
                            @endif
                        </div>
                        <div id="vendo" class="tab-pane text-light">
                            @foreach($mybuttons as $key => $button)
                            <button type="button" id="btn{{$key}}" onclick="autologinClick({{$key}})" class="btn float-right login_btn" style="background-color:{{$mybuttoncolors[$key]}}">{{$button}}</button>
                            @endforeach                           
                        </div>

                        <div id="rates" class="tab-pane text-light">
                            <h3>Rates</h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                laudantium, totam
                                rem aperiam.</p>
                        </div>
                        <div id="terms" class="tab-pane text-light small">
                            <h3>Terms</h3>
                            <p>
                                @if($mytermsenable)
                                {!!$mytermstext!!}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs nav-justified position-relative">
                    <li class="nav-item"><a class="active" href="#member">Member</a></li>
                    <li class="nav-item"><a href="#vendo">Vendo</a></li>
                    <li class="nav-item"><a href="#rates">Rates</a></li>
                    <li class="nav-item"><a href="#terms">Terms</a></li>
                </ul>
                <!-- Modal -->
                <div class="modal fade" id="autologin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6>Status: <span id="state">Inactive</span></h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body ">                           
                                <div class="container">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <h5>Time: <span class="badge badge-secondary font-weight-bold"
                                                    id="time">0</span></h5>
                                        </div>
                                        <div class="col-6">
                                            <h5>Credit: <span class="badge badge-secondary font-weight-bold"
                                                    id="credit">0</span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="alert alert-success w-100 text-center" role="alert">
                                        <h5><span id="ddhhmm">DD:HH:MM</span></h5>                                        
                                    </div>                                    
                                </div>
                                <div class='progress progress-custom'>
                                    <div id='progress'
                                        class='progress-bar bg-warning progress-bar-striped progress-bar-animated'
                                        role='progressbar' style='width: 100%' aria-valuenow='50' aria-valuemin='0'
                                        aria-valuemax='100'>0%</div>
                                </div>                                                                                                
                                <hr>
                                <div class="container">
                                    <div id="toggle-package" class="btn-group btn-group-toggle w-100" role="group" aria-label="Package">
                                 
                                        <button id="toggle-time" value="time"  type="button" class="btn btn-outline-primary w-100">
                                            Time</button>
                                  
                                   
                                        <button id="toggle-data" value="data" type="button" class="btn btn-outline-success w-100">
                                            Data</button>
                                                                                
                                     
                                        <button id="toggle-charge" value="charge" type="button" class="btn btn-outline-danger  w-100">
                                            Charge</button>
                                                                                 
                                    </div>  
                                </div>
                             
                                <div class="container mt-1">
                                    <div id="toggle-service" class="btn-group btn-group-toggle w-100" role="group" aria-label="Service">
                                        <button id="toggle-autologin" value="autologin" type="button" class="btn btn-outline-info w-100">
                                            Autologin
                                        </button>
                                        <button id="toggle-generate" value="generate"  type="button" class="btn btn-outline-warning w-100">
                                             Generate
                                        </button>
                                        
                                    </div>                              
                                </div>
                               
                            </div>
                            <div class="modal-footer">
                                <button id="donepay" type="button" class="btn btn-info disabled">Done Paying</button>
                                <button id="cancelpay" type="button" class="btn btn-secondary disabled">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    @include('myhotspot.partials.footer')
    @endminify       
    <script>
    @minify('js')
        $(document).ready(function() {
            $(".nav-tabs a").click(function() {
                $(this).tab('show');
            });
            // $('#formlogout').submit(function(e){
            //    //e.preventDefault();
            // });

            @if($mybannerenable)
            $('.carousel').carousel({
                interval: {{$mybannerinterval}}
            })
            @endif
            @isset($reply)
                new Noty({
                type: "error",
                theme: "bootstrap-v4",
                layout: 'topRight',
                text: '{{ $reply }}',
                progressBar: true,
                timeout: 3500
                }).show();
            @endisset
            var currenttime = 0;
            @isset($timeleft)
                currenttime = {{ $timeleft }};
            @endif

            function pad2(num) {
                return (num < 10 ? '0' : '') + num;
            }

            function ConvertSeconds(num) {
                num = Number(num);
                var d = Math.floor(num / (3600 *
                    24));
                var h = Math.floor(num % (3600 * 24) / 3600);
                var m = Math.floor(num % 3600 / 60);
                var s = Math.floor(num % 60);
                return (pad2(d) + "d : " + pad2(h) + "h : " + pad2(m) + "m : " + pad2(s)) + "s";
            }


            function countdown(count) {
                if (count) {
                    document.getElementById('timeleft').innerHTML = ConvertSeconds(count);
                    setTimeout(() => countdown(count - 1), 1000);
                }
            }
            countdown(currenttime);

            function ConvertMinutes(e) {
                return d = Math.floor(e / 1440), h = Math.floor((e - 1440 * d) / 60), m = Math.round(e % 60), pad2(
                    d) + "d : " + pad2(h) + "h : " + pad2(m) + "m";
            }

            @if ($res == 'already' || $res == 'success')
                /* setTimeout(function(){
                $.ajax({
                url:"",
                method: 'get',
                CrossDomain:true,
                })
                .done(function() {
                console.log("second success");
                });
                });*/
            @endif
        });

        function doLogin() {
            var myMD5 = new MyMD5();
            document.mylogin.username.value = encodeURI(document.login.username.value);
            @isset($challenge)
                @if($mymembershipenable)
                    document.mylogin.response.value = myMD5.chap('00', document.login.password.value, '{{ $challenge }}');
                @else
                    document.mylogin.response.value = myMD5.chap('00', '', '{{ $challenge }}');
                @endif
            @endisset       
            document.mylogin.submit();
            return false;
        }

        function doLogout(){ // temporary fix logout
            var jqxhr = $.get("http://{{ $myuamip }}:{{ $myuamport }}/logout",function(){});           
        }

        function authenticate(username) {
            var myMD5 = new MyMD5();
            document.mylogin.username.value = username;
            @isset($challenge)
                document.mylogin.response.value = myMD5.chap('00', '', '{{ $challenge }}');
            @endisset
            document.mylogin.submit();
            return false;
        }

        function modalButtons(time,data,charge,service){
            if(time && !data && !charge){
                $('#toggle-package').hide();
            }
            if(!time){
                $('#toggle-time').hide();
            } else {
                $('#toggle-time').show();
            }
            if(!data){
                $('#toggle-data').hide();
            } else {
                $('#toggle-data').show();
            }
            if(!charge){
                $('#toggle-charge').hide();
            } else {
                $('#toggle-charge').show();
            }
            if(!service){
                $('#toggle-service').hide();
            } else {
                $('#toggle-service').show();
            }
        }

        var source;
        var time = 0;
        var credit = 0;
        var progress = 0;
        
        function autologinClick(id) {
            var ips = JSON.parse('@json($myips)');
            var states = JSON.parse('@json($mystates)');
            var time_enables = JSON.parse('@json($mytimeenables)');
            var data_enables = JSON.parse('@json($mydataenables)');
            var charge_enables = JSON.parse('@json($mychargeenables)');
            var generate_enables = JSON.parse('@json($mygenerateenables)');
            modalButtons(time_enables[id],data_enables[id],charge_enables[id],generate_enables[id])
            console.log(time_enables[id], data_enables[id], charge_enables[id], generate_enables[id]);
                    if(states[id] == "down"){
                        new Noty({
                            type: "error",
                            theme: "bootstrap-v4",
                            layout: 'topRight',
                            text: 'Vendo '+ document.getElementById('btn'+id).innerHTML +' Offline',
                            progressBar: true,
                            timeout: 3500
                        }).show();  
                        return;
                    }
            $('#autologin').modal('show');            
            setTimeout(function() {
                autologinEvent(id,ips[id]);
            }, 1500);
        }

        $('#autologin').on('hide.bs.modal', function(e) {
            if (time <= 1) {
                if (credit == 0) {
                    source.close();
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                }
            }
        })

        function jsonCallback(json){
            if(!json.clientState) location.reload(); 
        }

        function checkRedirect(){
            var jqxhr = $.ajax({
                dataType: "jsonp",
                url: "http://10.1.0.1:3991/json/status?callback=jsonCallback",
                });         
        }

        // checkRedirect();

        function handleDoneClick() {
            var jqxhr = $.post("/node/login", function(data) {
                    console.log(data);
                    if (data) {
                        var username = JSON.parse(data);
                        authenticate(username.username);
                    }
                })
                .done(function() {
                    console.log("second success");
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("finished");
                });

            // Perform other work here ...

            // Set another completion function for the request above
            jqxhr.always(function() {
                console.log("second finished");
            });
        }

        function handleCancelClick() {
            // Assign handlers immediately after making the request,
            // and remember the jqxhr object for this request
            var jqxhr = $.post("/node/cancel", function(data) {
                    console.log(data);
                    if (data == "done") {
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }
                })
                .done(function() {
                    console.log("second success");
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("finished");
                });

            // Perform other work here ...

            // Set another completion function for the request above
            jqxhr.always(function() {
                console.log("second finished");
            });
        }

        function autologinEvent(id,server) {
            if (!!window.EventSource) {
                if (time == 0) {
                    
                    source = new EventSource('http://'+server+'/node/register');
                    source.addEventListener('message', function(e) {
                        var data = JSON.parse(e.data);
                        time = data.time;
                        progress = data.progress;
                        credit = data.credit;
                        var progress_element = document.getElementById('progress');
                        progress_element.style.width = progress.toString() + "%";
                        progress_element.innerText = progress.toFixed().toString() + "%";
                        document.getElementById('time').innerHTML = time;
                        document.getElementById('credit').innerHTML = credit;
                        if (time <= 1) {
                            setTimeout(function() {
                                $('#autologin').modal('hide')
                            }, 2000);
                        }
                        if (credit > 0) {
                            $('#cancelpay').addClass('disabled');
                            $('#donepay').removeClass('disabled');
                        } else {
                            $('#donepay').addClass('disabled');
                        }
                    }, false)

                    source.addEventListener('open', function(e) {
                        document.getElementById('state').innerHTML = "Connected"
                    }, false)

                    source.addEventListener('error', function(e) {
                        const id_state = document.getElementById('state')
                        if (e.eventPhase == EventSource.CLOSED)
                            source.close()
                        if (e.target.readyState == EventSource.CLOSED) {
                            id_state.innerHTML = "Disconnected"
                        } else if (e.target.readyState == EventSource.CONNECTING) {
                            id_state.innerHTML = "Connecting..."
                        }
                    }, false)
                }
            } else {
                console.log("Your browser doesn't support SSE")
            }
        }

        $('#donepay').click(function() {
            console.log('done paying clicked');
            if (credit > 0) {
                handleDoneClick();
            }
        });
        $('#cancelpay').click(function() {
            console.log('cancel clicked');
            if (credit == 0) {
                handleCancelClick();
            }
        });
        var package_selected = "time";
        var service_selected = "autologin";
        $('#toggle-package button').on('click', function() {
            var thisBtn = $(this);
            thisBtn.addClass('active').siblings().removeClass('active');
            var btnText = thisBtn.text();
            var btnValue = thisBtn.val();
            package_selected = btnValue;
            console.log(package_selected, service_selected);
        });
        $('#toggle-service button').on('click', function() {
            var thisBtn = $(this);
            thisBtn.addClass('active').siblings().removeClass('active');
            var btnText = thisBtn.text();
            var btnValue = thisBtn.val();
            service_selected = btnValue;
            console.log(package_selected, service_selected);
        });        

        // $('#toggle-time').click(function(e) {
        //     e.preventDefault();
        //     $('#toggle-data').removeClass('active');
        //     $('#toggle-charge').removeClass('active');
        //     $(this).addClass('active');
        // });

        // $('#toggle-data').click(function(e) {
        //     e.preventDefault();
        //     $('#toggle-time').removeClass('active');
        //     $('#toggle-charge').removeClass('active');
        //     $(this).addClass('active');
        // });

        // $('#toggle-charge').click(function(e) {
        //     e.preventDefault();
        //     $('#toggle-data').removeClass('active');
        //     $('#toggle-time').removeClass('active'); 
        //     $(this).addClass('active');
        // });        


        @endminify 
        /*
        var serviceElement = document.getElementById('toggle-service');
        var isData = false;
        var isOnce = false;
        
        $(function() {
            $('#toggle-package').change(function() {
                console.log($(this).prop('checked'));
                if ($(this).prop('checked') == false) {
                    isData = true;
                    $('#toggle-service').bootstrapToggle('on');
                } else {
                    isData = false;
                    isOnce = false;
                    serviceElement.removeAttribute('disabled');
                }
            })
        })
        $(function() {
            $('#toggle-service').change(function() {
                console.log($(this).prop('checked'));
                if (isData == true && isOnce == false) {
                    isOnce = true;
                    $('#toggle-service').bootstrapToggle('on');
                    serviceElement.setAttribute('disabled', true);
                }
            })
        })
        */
        
    </script>
@endsection
