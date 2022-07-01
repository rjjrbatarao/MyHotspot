@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_start')


<div class="{{ $widget['class'] ?? 'alert alert-primary' }}" role="alert">
	@if (isset($widget['content']))
	<div>{!! $widget['content'] !!}</div>
	@endif  
    @if (isset($widget['progress1']))
        <div  class='progress  mb-4'><div id='cpu' class='progress-bar bg-success progress-bar-striped progress-bar-animated' role='progressbar' style='width: 0%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'>0% Cpu </div></div>    
    @endif
    @if (isset($widget['progress2']))
        <div  class='progress  mb-4'><div id='ram' class='progress-bar bg-success progress-bar-striped progress-bar-animated' role='progressbar' style='width: 0%' aria-valuenow='60' aria-valuemin='0' aria-valuemax='100'>0% Ram </div></div>    
    @endif
    @if (isset($widget['progress3']))
        <div  class='progress  mb-4'><div id='swap' class='progress-bar bg-success progress-bar-striped progress-bar-animated' role='progressbar' style='width: 0%' aria-valuenow='70' aria-valuemin='0' aria-valuemax='100'>0% Swap </div></div>    
    @endif                   
</div>

@push('after_styles')
    <style> 
        .progress-bar {
            -webkit-transition: width 2.5s ease;
            transition: width 2.5s ease;
        }
    </style>
@endpush

@push('after_scripts')
<script>
$(document).ready(function() {
    console.log("{{ backpack_url() }}/dashboard/system-info");
setInterval(function(){
    var cpu_percentage = Math.floor(Math.random() * 101);
    var ram_percentage = Math.floor(Math.random() * 101);
    var swap_percentage = Math.floor(Math.random() * 101);
    var cpu_element = document.getElementById('cpu');
    cpu_element.style.width = cpu_percentage.toString() + "%";
    cpu_element.innerText = cpu_percentage.toString() + "% cpu";
    var ram_element = document.getElementById('ram');
    ram_element.style.width = ram_percentage.toString() + "%";
    ram_element.innerText = ram_percentage.toString() + "% ram";
    var swap_element = document.getElementById('swap');
    swap_element.style.width = swap_percentage.toString() + "%";
    swap_element.innerText = swap_percentage.toString() + "% swap";
    
},2000);
/*
progressBarSwing();
function progressBarSwing(){
    var delay = 500;
    $(".progress-bar").each(function(i) {
        $(this).delay(delay * i).animate({
            width: $(this).attr('aria-valuenow') + '%'
        }, delay);
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: delay,
            // easing: 'swing',
            step: function(now) {
            $(this).text(now + '%');
            }
        });
    });
}
*/
/* 
var export_route = "/system-info";
setInterval(function(){getSystemInfo();},2000);
function getSystemInfo(){
        $.ajax({
          url: export_route,
          type: 'POST',
          data: { entries: crud.checkedItems },
          success: function(result) {

          },
          error: function(result) {

            });
          }
        });
    }
*/  
});     
</script>
@endpush

@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_end')