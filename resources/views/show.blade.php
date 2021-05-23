@include('header')

<div class="container col-md-7">
<div class="card mb-3" style="width: 18rem;">
  <ul class="list-group list-group-flush m-3">
    @foreach($record as $key=>$value)
        @if( !is_array($value))
            <li class="list-group-item">{{$key}} : {{$value}}</li>
        @else
             @foreach($value as $key=>$value)
                <li class="list-group-item">{{$key}} : {{$value}}</li>
             @endforeach
        @endif
    @endforeach
  </ul>
</div>

    @if (session('error_for_destroy'))
        <div class="alert alert-danger">
            <h1>{{session('error_for_destroy')["message"]}}</h1>
        </div>
    @endif
    @if (session('success_for_destroy'))
        <div class="alert alert-success">
            <h1>{{session('success_for_destroy')['message']}}</h1>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-3">
            <form action="{{ route('home.actions.destroy',['id'=>$record['parcel_id']]) }}" method="POST">
                @method('DELETE')
                @csrf
                <input type="submit" value="delete" class="btn btn-danger delete-button"/>
            </form>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('page.edit',['id'=>$record['parcel_id']]) }}" id="configure" class="btn btn-primary delete-button">configure</a>
        </div>
    </div>
    </div>
</body>
