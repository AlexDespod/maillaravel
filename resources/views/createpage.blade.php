@include('header')

<div class="container-sm col-4">
    @if (session('error_for_store'))
        <div class="alert alert-danger">
            <h1>{{session('error_for_store')["message"]}}</h1>
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
    @if (session('success_for_temp'))
        <div class="alert alert-success">
            <h1>{{session('success_for_temp')['message']}}</h1>
        </div>
    @endif
   <form  method="post" action="{{ route('home.actions.store') }}">

            <!-- CROSS Site Request Forgery Protection -->
            @csrf

            <div class="form-group">
                <label>sender name</label>
                <input type="text" class="form-control" name="sender_name" id="sender_name" value="{{ old('sender_name') }}">
            </div>

            <div class="form-group">
                <label>Recipient</label>
                <input type="text" class="form-control" name="recipient" id="recipient" value="{{ old('recipient') }}">
            </div>

            <div class="form-group">
                <label>Endpoint</label>
                <input type="text" class="form-control" name="endpoint" id="endpoint" value="{{ old('endpoint') }}">
            </div>

            <div class="form-group">
                <label>Product</label>
                <input type="text" class="form-control" name="product" id="product" value="{{ old('product') }}">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}">
            </div>
            <input type="submit" name="send" value="Submit" class="btn btn-primary btn-block">
        </form>
</div>
</body>
