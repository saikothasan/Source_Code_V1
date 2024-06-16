@if (count($errors) > 0)
	 @foreach ($errors->all() as $error)
	  <p class="alert alert-error text-danger">{{$error}}</p>
	 @endforeach
@endif

@if (session()->has('message'))
	<p class="alert alert-success" id="alert-success">{{session('message')}}</p>
@endif

<script>
    $(function () {
        setTimeout(() => {
            $("#alert-success").hide();
        },2000);
    });
</script>
