@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
<div class="col-md-4">
    @include('msg.alerts')
</div>
    </div>
    <div class="row justify-content-center">
       
       

      <div class="col-md-4">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">    
               <h1>
                   Firmado correcatamente
               </h1>
                <hr>
                 
                </div>
        </div> 
    </div>

</div>
@endsection

@push('scripts')




@endpush