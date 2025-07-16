@extends('layouts.app')

@section('content')
<div class="container-fluid">    
    <h2 class="text-start mb-5 h2">🎉 Welcome to the Admin Dashboard</h2>

    <div class="row g-4 align-items-stretch bdyrow">
        <!-- 🎂 Today's Birthdays -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <i class="bi bi-calendar-heart me-2"></i> Today's Birthdays
                    </div>
                    <div class="card-body">
                        @if(count($todayBirthdays) > 0)
                           <!-- 
                            <h2 class="birthday-title text-center">Happy Birthday!</h2>
                            <div class="pyro">
                                <div class="before"></div>
                                <div class="after"></div>
                            </div>
                            <div class="box">
                              <div class="plate"></div>
                              <div class="layer">
                                <div class="fill"></div>
                              </div>
                              <div class="layer">
                                <div class="fill"></div>
                              </div>
                              <div class="icing">
                                <div class="icing-sm"></div>
                                <div class="icing-sm"></div>
                                <div class="icing-sm"></div>
                                <div class="icing-sm"></div>
                                <div class="icing-sm"></div>
                                <div class="icing-sm"></div>
                              </div>
                              <div class="candles">
                                <div class="candle">
                                  <div class="flame"></div>
                                </div>
                                <div class="candle">
                                  <div class="flame"></div>
                                </div>
                                <div class="candle">
                                  <div class="flame"></div>
                                </div>
                              </div>
                            </div> -->
                            <div class="bady-emp">
                                 @foreach($todayBirthdays as $emp)
                                 @php
                                    $initials = collect(explode(' ', $emp->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->join('');
                                    $imgPath = $emp->profile_image  && file_exists(public_path('storage/'.$emp->profile_image ))
                                                ? asset('storage/'.$emp->profile_image )
                                                : null;
                                @endphp
                                    
                                    <div class="d-flex align-items-center mb-3 p-2 rounded shadow-sm bdycelb">
                                        <div class="emp-profile me-3">
                                            @if($imgPath)
                                                <img src="{{ $imgPath }}" alt="Profile" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-weight: bold;">
                                                    {{ $initials }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="empData flex-grow-1">
                                            <div class="fw-semibold text-dark text-capitalize">{{ $emp->name }}</div>
                                            <div class="text-muted small">{{ $emp->designation }}</div>
                                        </div>
                                        <div class="text-nowrap text-dark">
                                            <span class="badge bg-success text-white py-2 px-3">
                                                🎂 Today
                                            </span>
                                        </div>
                                        
                                    </div>
                                  @endforeach
                            </div>
                            <canvas class="confetti" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 999;"></canvas>
                        @else
                            <p class="text-muted text-center py-4">No birthdays today 🎂</p>
                        @endif
                    </div>
                </div>
            </div>

        <!-- 📆 Upcoming Birthdays -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 upbdy">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-calendar-event me-2"></i> Upcoming Birthdays
                </div>
                <div class="card-body">
                @if(count($upcomingBirthdays) > 0)
                    @foreach($upcomingBirthdays as $emp)
                        @php
                            $initials = collect(explode(' ', $emp->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->join('');
                            $imgPath = $emp->profile_image  && file_exists(public_path('storage/'.$emp->profile_image ))
                                        ? asset('storage/'.$emp->profile_image )
                                        : null;
                        @endphp
                        <div class="d-flex align-items-center mb-3 p-2 rounded shadow-sm" >
                            {{-- Profile image or initials --}}
                            <div class="me-3">
                                @if($imgPath)
                                    <img src="{{ $imgPath }}" alt="Profile" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-weight: bold;">
                                        {{ $initials }}
                                    </div>
                                @endif
                            </div>

                            {{-- Name and Designation --}}
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark text-capitalize">{{ $emp->name }}</div>
                                <div class="text-muted small">{{ $emp->designation }}</div>
                            </div>

                            {{-- Celebration Date with Cake Icon --}}
                            <div class="text-nowrap text-dark">
                                <span class="badge bg-success text-white py-2 px-3">
                                    🎂 {{ \Carbon\Carbon::parse($emp->celb_dob)->format('M d') }}
                                </span>
                            </div>
                            
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-4">No upcoming birthdays 🎈</p>
                @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 align-items-stretch bdyrow">
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <strong>Upcoming Holidays</strong>
            </div>
            <div class="card-body p-3">
                @if ($upcomingHolidays->count())
                    <ul class="list-group list-group-flush">
                        @foreach ($upcomingHolidays as $holiday)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                
                                <div class="dateUp d-flex g-5">
                                    <!-- <i class="bi bi-calendar3 me-1"></i> -->
                                    <div class="">
                                        <strong>{{ $holiday->title }}</strong><br>
                                        <small class="text-muted">
                                            
                                            {{ \Carbon\Carbon::parse($holiday->holiday_date)->format('l, d M Y') }}
                                        </small>
                                    </div>
                                </div>
                                <span class="badge bg-success">
                                    {{ \Carbon\Carbon::parse($holiday->holiday_date)->diffForHumans() }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No holidays in the next 30 days.</p>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
:root {
  --biscuit: #5D4037;
  --icing: #fff;
  --fill: #F6D8D1;
  --purple: #94AEFF;
  --grey: #ccc;
  --green: #008773;
  --sky: #0CBAE8;
  --rose: #D16D6B;
  --background: #2b2d42;
  --white: #ffffff
}
.bdyrow .card {
    max-height: 548px;
    overflow-y: auto;
}
.birthday-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 1rem;
    animation: colorCycle 3s linear infinite;
    margin-top: 1rem;
}
.bday-emp {
    margin: 25px 0;
}
.birthday-name {
    font-size: 2rem;
    font-weight: bold;
    animation: colorCycle 3s linear infinite;
    margin-bottom: 0;
}
.birthday-pos {
    font-size: 1.5rem;
    font-weight: bold;
}


/* Keyframes for text color animation */
@keyframes colorCycle {
    0%   { color: #206957; }   /* Teal */
    25%  { color: #d63384; }   /* Pink */
    50%  { color: #ff9800; }   /* Orange */
    75%  { color: #007bff; }   /* Blue */
    100% { color: #206957; }   /* Back to Teal */
}

.confetti {
  position: absolute;
  top: 0;
  left: 0;
  pointer-events: none;
  width: 100%;
  height: 100%;
  z-index: 999;
}
.bdycelb{
    position: relative;
}

</style>  
<script>
    
     document.addEventListener("DOMContentLoaded", function () {
      var retina = window.devicePixelRatio,
          PI = Math.PI,
          sqrt = Math.sqrt,
          round = Math.round,
          random = Math.random,
          cos = Math.cos,
          sin = Math.sin,
          rAF = window.requestAnimationFrame;

      var duration = 1.0 / 50,
          confettiPaperCount = 35,
          DEG_TO_RAD = PI / 180,
          colors = [
            ["#df0049", "#660671"],
            ["#00e857", "#005291"],
            ["#2bebbc", "#05798a"],
            ["#ffd200", "#b06c00"]
          ];

      function Vector2(_x, _y) {
        this.x = _x;
        this.y = _y;
        this.Length = function () {
          return sqrt(this.SqrLength());
        }
        this.SqrLength = function () {
          return this.x * this.x + this.y * this.y;
        }
        this.Add = function (_vec) {
          this.x += _vec.x;
          this.y += _vec.y;
        }
        this.Sub = function (_vec) {
          this.x -= _vec.x;
          this.y -= _vec.y;
        }
        this.Div = function (_f) {
          this.x /= _f;
          this.y /= _f;
        }
        this.Mul = function (_f) {
          this.x *= _f;
          this.y *= _f;
        }
        this.Normalized = function () {
          var sqrLen = this.SqrLength();
          if (sqrLen != 0) {
            var factor = 1.0 / sqrt(sqrLen);
            return new Vector2(this.x * factor, this.y * factor);
          }
          return new Vector2(0, 0);
        }
      }

      function ConfettiPaper(_x, _y) {
        this.pos = new Vector2(_x, _y);
        this.rotationSpeed = (random() * 600 + 800);
        this.angle = DEG_TO_RAD * random() * 360;
        this.rotation = DEG_TO_RAD * random() * 360;
        this.cosA = 1.0;
        this.size = 5.0;
        this.oscillationSpeed = (random() * 1.5 + 0.5);
        this.xSpeed = 40.0;
        this.ySpeed = (random() * 60 + 50.0);
        this.corners = new Array();
        this.time = random();
        var ci = round(random() * (colors.length - 1));
        this.frontColor = colors[ci][0];
        this.backColor = colors[ci][1];

        for (var i = 0; i < 4; i++) {
          var dx = cos(this.angle + DEG_TO_RAD * (i * 90 + 45));
          var dy = sin(this.angle + DEG_TO_RAD * (i * 90 + 45));
          this.corners[i] = new Vector2(dx, dy);
        }

        this.Update = function (_dt) {
          this.time += _dt;
          this.rotation += this.rotationSpeed * _dt;
          this.cosA = cos(DEG_TO_RAD * this.rotation);
          this.pos.x += cos(this.time * this.oscillationSpeed) * this.xSpeed * _dt;
          this.pos.y += this.ySpeed * _dt;
          if (this.pos.y > ConfettiPaper.bounds.y) {
            this.pos.x = random() * ConfettiPaper.bounds.x;
            this.pos.y = 0;
          }
        }

        this.Draw = function (_g) {
          _g.fillStyle = this.cosA > 0 ? this.frontColor : this.backColor;
          _g.beginPath();
          _g.moveTo((this.pos.x + this.corners[0].x * this.size) * retina, (this.pos.y + this.corners[0].y * this.size * this.cosA) * retina);
          for (var i = 1; i < 4; i++) {
            _g.lineTo((this.pos.x + this.corners[i].x * this.size) * retina, (this.pos.y + this.corners[i].y * this.size * this.cosA) * retina);
          }
          _g.closePath();
          _g.fill();
        }
      }
      ConfettiPaper.bounds = new Vector2(0, 0);

      var confetti = {};
      confetti.Context = function (id) {
        var canvas = document.querySelector('.' + id);
         if (!canvas) {
            console.warn('Confetti: Canvas with class "' + id + '" not found. Skipping.');
            return; // prevent further errors
        }
        var canvasParent = canvas.parentNode;
        var canvasWidth = canvasParent.offsetWidth;
        var canvasHeight = canvasParent.offsetHeight;
        canvas.width = canvasWidth * retina;
        canvas.height = canvasHeight * retina;
        var context = canvas.getContext("2d");
        var confettiPapers = [];

        ConfettiPaper.bounds = new Vector2(canvasWidth, canvasHeight);
        for (var i = 0; i < confettiPaperCount; i++) {
          confettiPapers[i] = new ConfettiPaper(random() * canvasWidth, random() * canvasHeight);
        }

        this.resize = function () {
          canvasWidth = canvasParent.offsetWidth;
          canvasHeight = canvasParent.offsetHeight;
          canvas.width = canvasWidth * retina;
          canvas.height = canvasHeight * retina;
          ConfettiPaper.bounds = new Vector2(canvasWidth, canvasHeight);
        }

        this.update = function () {
          context.clearRect(0, 0, canvas.width, canvas.height);
          for (var i = 0; i < confettiPaperCount; i++) {
            confettiPapers[i].Update(duration);
            confettiPapers[i].Draw(context);
          }
          rAF(() => this.update());
        }

        this.start = () => this.update();
      };

      var confetti = new confetti.Context("confetti");
      if (confetti && typeof confetti.start === "function") {
      confetti.start();

      window.addEventListener("resize", function () {
        confetti.resize();
      });
    } else {
        console.log("Confetti: Skipped initialization as canvas not found.");
    }
    });
</script>
@endsection
  