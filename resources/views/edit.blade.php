@include('header')

<div class="container-sm col-4">
    @if (session('error_for_edit'))
        <div class="alert alert-danger">
            <h1>{{session('error_for_edit')["message"]}}</h1>
        </div>
    @endif
    @if (session('success_for_edit'))
        <div class="alert alert-success">
            <h1>{{session('success_for_edit')['message']}}</h1>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
   <form  method="post" action="{{ route('home.actions.update',$order->parcel_id) }}">
            @method('PATCH')
            <!-- CROSS Site Request Forgery Protection -->
            @csrf

            <div class="form-group">
                <label>sender name</label>
                <input type="text" class="form-control" name="sender_name" id="sender_name" value="{{ old('sender_name',$order->sender_name) }}">
            </div>

            <div class="form-group">
                <label>Recipient</label>
                <input type="text" class="form-control" name="recipient" id="recipient" value="{{ old('recipient',$order->recipient) }}">
            </div>

            <div class="form-group">
                <label>Endpoint</label>
                <input type="text" class="form-control" name="endpoint" id="endpoint" value="{{ old('endpoint',$order->endpoint) }}">
            </div>

            <div class="form-group">
                <label>Product</label>
                <input type="text" class="form-control" name="product" id="product" value="{{ old('product',$order->product) }}">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone',$order->parcels->phone) }}">
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" name="price" id="price" value="{{ old('price',$order->parcels->price) }}">
            </div>
            <input type="submit"  value="Submit" class="btn btn-primary btn-block">
        </form>
</div>
</body>
