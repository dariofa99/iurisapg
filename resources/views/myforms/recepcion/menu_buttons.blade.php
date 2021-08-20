
  <input type="hidden" value="{{$active}}" id="innumdv">
<div class="row pasos-recepcion">

  <div class="col-md-2" style="max-width: 75px !important;">
  Pasos:                
  </div>          
    <div class="{{$active == 1 ? "col-md-3" : "col-md-1"}}">
      <span class="btn_menu icon {{$active == 1 ? "icon_active" : ""}}">1</span>   
      @if($active == 1) En recepción @endif                  
    </div>
    <div class="{{$active == 2 ? "col-md-3" : "col-md-1"}}">
      <span class="btn_menu icon {{$active == 2 ? "icon_active" : ""}} ">2</span>   
      @if($active == 2) Sala de espera @endif                     
    </div>
    <div class="{{$active == 3 ? "col-md-3" : "col-md-1"}}">
        <span class="btn_menu icon {{$active == 3 ? "icon_active" : ""}} ">3</span>   
        @if($active == 3) En atención @endif                     
    </div>
    <div class="{{($active == 4 || $active == 5)  ? "col-md-4" : "col-md-1"}}">
      <span class="btn_menu icon {{($active == 4 || $active == 5) ? "icon_active" : ""}} ">4</span>   
      @if($active == 4) Registrarse @endif 
      @if($active == 5) Iniciar Sesión  @endif                     
  </div>
  {{-- <div class="{{$active == 5 ? "col-md-4" : "col-md-1"}}">
    <span class="icon {{$active == 5 ? "icon_active" : ""}} ">4</span>   
    @if($active == 5) Iniciar Sesión @endif                     
</div> --}}
  
     
  </div>