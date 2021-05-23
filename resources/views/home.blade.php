
@include('header')

  @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  <form action="" method="get" class="container col-md-6 mb-5">
      <div class="row mb-3">
    <label for="sender_name" class="col-sm-3 col-form-label">Sender like :</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputEmail3" name="sender_name" value="{{isset($inputs) ? (isset($inputs['sender_name']) ? $inputs['sender_name']:''):''}}">
    </div>
  </div>
  <div class="row mb-3">
    <label for="recipient" class="col-sm-3 col-form-label">Recipient like :</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputPassword3" name="recipient" value="{{isset($inputs) ? (isset($inputs['recipient']) ? $inputs['recipient'] :''):''}}">
    </div>
  </div>
  <div class="row mb-3">
    <label for="product" class="col-sm-3 col-form-label">Product like :</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputPassword3" name="product" value="{{isset($inputs) ? (isset($inputs['product']) ? $inputs['product']:''):''}}">
    </div>
  </div>
  <div class="row mb-3">
    <label for="price_from" class="col-sm-2 col-form-label">price from</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="inputPassword3" name="price_from" value="{{isset($inputs) ? (isset($inputs['price_from']) ?$inputs['price_from'] : $price->price_from) : $price->price_from}}">
    </div>
    <label for="price_to" class="col-sm-1 form-label">to</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="inputPassword3" name="price_to" value="{{isset($inputs) ? (isset($inputs['price_to']) ? $inputs['price_to'] :$price->price_to) : $price->price_to}}">
    </div>
  </div>
  <div class="row mb-3">
    <label for="date_from" class="col-sm-2 col-form-label">date from</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" id="date_from" name="date_from" value="{{isset($inputs) ? (isset($inputs['date_from']) ? $inputs['date_from'] :$date->date_from) : $date->date_from}}">
    </div>
    <label for="date_to" class="col-sm-1 col-form-label">to</label>
    <div class="col-sm-4">
      <input type="date" class="form-control" id="inputPassword3" name="date_to" value="{{isset($inputs) ? (isset($inputs['date_from']) ? $inputs['date_to'] : $date->date_to) : $date->date_to}}">
    </div>
  </div>
    <div class="row col-md-5 mb-3 g-3">
    <label for="endpoint" class="col-sm-5 col-form-label">Cityes : </label>
    <div class="col-sm-7">
    <select class="form-select" name="endpoint">
        @foreach($endpoints as $key=>$endpointVal)
            @if(!isset($endpoint))
                @if($key == 0)
                    <option value="all" selected>all</option>
                    <option value="{{$endpointVal->endpoint}}">{{$endpointVal->endpoint}}</option>
                @else
                    <option value="{{$endpointVal->endpoint}}">{{$endpointVal->endpoint}}</option>
                @endif
            @else
                @if($endpoint == 'all')
                    @if($key == 0)
                        <option value="all" selected>all</option>
                        <option value="{{$endpointVal->endpoint}}">{{$endpointVal->endpoint}}</option>
                    @else
                        <option value="{{$endpointVal->endpoint}}">{{$endpointVal->endpoint}}</option>
                    @endif
                @else
                    @if($endpointVal->endpoint == $endpoint)
                       <option selected value="{{$endpointVal->endpoint}}">{{$endpointVal->endpoint}}</option>
                       <option value="all">all</option>
                    @else
                      <option value="{{$endpointVal->endpoint}}">{{$endpointVal->endpoint}}</option>
                    @endif
                @endif
            @endif

        @endforeach

    </select>
    </div>
  </div>

    <div>
    <div class="row col-md-5 mb-3 g-4">
    <label for="order_by" class="col-sm-5 col-form-label">Order by : </label>
    <div class="col-sm-7">
    <select class="form-select" name="order_by">
        @foreach($columns as $key=>$columnVal)
            @if(!isset($column))
                @if($key == "1")
                    <option value="id" selected>id</option>
                @else
                    <option value="{{$columnVal}}">{{$columnVal}}</option>
                @endif
            @else
                @if($column == $columnVal)
                    <option selected value="{{$columnVal}}">{{$columnVal}}</option>
                @else
                    <option value="{{$columnVal}}">{{$columnVal}}</option>
                @endif
            @endif
        @endforeach
    </select>
    </div>
  </div>
  <div class="row col-md-5 mb-3 g-4">
    <label for="order_by" class="col-sm-5 col-form-label">Order type : </label>
    <div class="col-sm-7">
    <select class="form-select" name="order_type">
        @if(isset($inputs) && ($inputs['order_type'] == 'desc'))
            <option value="desc" selected>decrease</option>
            <option value="asc">growth</option>
        @else
            <option value="asc" selected>growth</option>
            <option value="desc">decrease</option>
        @endif
    </select>

    </div>
  </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">search</button>
    </div>
  </div>
  </form>
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

  <table class="table" id="maintable">
        <thead>
          <tr>
          <th scope="col"><div class="th"><div>id</div><span id="orderby" data-name="id" data-rot="0">&#8593</span></div></th>
            <th scope="col"><div class="th"><div>sender_name</div><span id="orderby" data-name="sender_name" data-rot="0">&#8593</span></div></th>
            <th scope="col"><div class="th"><div>recipient</div><span id="orderby" data-name="recipient" data-rot="0">&#8593</span></div></th>
            <th scope="col"><div class="th"><div>endpoint</div><span id="orderby" data-name="endpoint" data-rot="0">&#8593</span></div></th>
            <th scope="col"><div class="th"><div>product</div><span id="orderby" data-name="product" data-rot="0">&#8593</span></div></th>
            <th scope="col"><div class="th"><div>date</div><span id="orderby" data-name="date" data-rot="0">&#8593</span></div></th>
            <th scope="col"><div class="th"><div>phone</div><span id="orderby" data-name="phone" data-rot="0">&#8593</span></div></th>
            <th scope="col"><div class="th"><div>price</div><span id="orderby" data-name="price" data-rot="0">&#8593</span></div></th>
          </tr>
        </thead>
        <tbody>

        @if(isset($orders))
        @foreach($orders as $order)
            <tr>
                <th scope="row"><a href="{{route('page.show',['id'=>$order->parcel_id])}}">{{$order->parcel_id}}</a></th>
                <td>{{$order->sender_name}}</td>
                <td>{{$order->recipient}}</td>
                <td>{{$order->endpoint}}</td>
                <td>{{$order->product}}</td>
                <td>{{$order->date}}</td>
                <td>{{$order->phone}}</td>
                <td>{{$order->price}}</td>
                <td>
                    <form action="{{ route('home.actions.destroy',['id'=>$order->parcel_id]) }}" method="POST">
                     @method('DELETE')
                     @csrf
                    <input type="submit" value="delete" class="btn btn-danger delete-button"/>
                </form></td>
                <td><a href="{{ route('page.edit',['id'=>$order->parcel_id]) }}"id="configure">configure</a></td>
            </tr>
        @endforeach
        @endif
        <script src="{{ asset('js/script.js') }}"></script>
  </body>

</html>
