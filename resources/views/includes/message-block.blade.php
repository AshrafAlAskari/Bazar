@if(Session::has('message'))
    <br />
    <div class="row justify-content-lg-center">
        <div class="col col-lg-6 alert alert-success">
            {{Session::get('message')}}
        </div>
    </div>
@endif
@if(Session::has('alert'))
    <br />
    <div class="row justify-content-lg-center">
        <div class="col col-lg-6 alert alert-danger">
            {{Session::get('alert')}}
        </div>
    </div>
@endif
