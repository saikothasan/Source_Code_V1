<div class="pad margin">
    <div class="row"
        style="margin-bottom: 0!important; background-color: rgb(0,0,0);border-radius: 3px;margin: 0 0 20px 0;padding: 15px 30px 15px 15px;">
        <div class="col-md-6">
            <h2 style="color: #fff"><strong> {{ $supplier_info->name }}


                </strong><span>{{ translate('Suppliers') }}</span></h2>
            {{-- <div class="progress" style="border-radius: 10px;width: 65%">
                <div class="progress-bar" style="width: 95%">
                <span class="progress-description text-center"
                      style="background-color: rgb(0,214,0)">
                    {{ translate('Profit')}} {{ translate('level')}} 95%
                </span>
                </div>
            </div> --}}
        </div>


        <div class="col-md-6 row">

            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4 image text-center">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 image-div">
            @if ($supplier_info->photo)
                <img src="{{ asset($supplier_info->photo) }}" class="right-image" alt="" />
            @else
                <img src="{{ asset('images/blank.jpg') }}" class="right-image" alt="" />
            @endif

        </div>
    </div>

    <div class="pad margin heading"> {{ translate('Starting') }}
        {{ date('d F Y', strtotime($supplier_info->created_at)) }} </div>
    <hr class="hr" />
