<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pre-order food from restaurants</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
<h2>Pre-order food from restaurants</h2>
<br>
<div class="warpper">
    <input class="radio" id="one" name="group" type="radio" checked>
    <input class="radio" id="two" name="group" type="radio">
    <input class="radio" id="three" name="group" type="radio">
    <input class="radio" id="four" name="group" type="radio">

    <div class="tabs">
        <label class="tab" id="one-tab" >Step1</label>
        <label class="tab" id="two-tab" >Step2</label>
        <label class="tab" id="three-tab" >Step3</label>
        <label class="tab" id="four-tab" >Review</label>
    </div>
{{--    <div class="tabs">--}}
{{--        <label class="tab" id="one-tab" for="one">Step1</label>--}}
{{--        <label class="tab" id="two-tab" for="two">Step2</label>--}}
{{--        <label class="tab" id="three-tab" for="three">Step3</label>--}}
{{--        <label class="tab" id="four-tab" for="four">Review</label>--}}
{{--    </div>--}}

    <div class="panels">
        <div class="panel" id="one-panel">
            <div class="panel-title">
                <form method="POST" id="meal_form">
                    @csrf
                    <div class="panel__inner-item">
                        <label for="">Please Select a meal</label>
                        <br>
                        <label>
                            <select name="meal" id="meal">
                                @foreach($listMeal as $meal)
                                    <option value="{{ $meal }}">{{ $meal }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="panel__inner-item">
                        <label for="">Please Enter Number of people</label>
                        <br>
                        <input type="number" name="number" id="" max="10" value="1">
                    </div>
                    <a href="#" id="meal_sb" class="btn-meal">Next</a>
                </form>
            </div>
        </div>
        <div class="panel" id="two-panel">
            <div class="panel-title">Step2</div>
            <form method="POST" id="restaurant_form">
                @csrf
                <div class="panel__inner-item">
                    <label for="">Please Select a Restaurant</label>
                    <br>
                    <label>
                        <select name="restaurant" id="restaurant">
                        </select>
                    </label>
                </div>
                <a href="#" class="btn-previous">Previous</a>
                <a href="#" id="restaurant_sb" class="btn-meal">Next</a>
            </form>
        </div>
        <div class="panel" id="three-panel">
            <div class="panel-title">Step3</div>
            <form method="POST" id="dish_form">
                @csrf
                <div class="panel__inner-item">
                    <label for="">Please Select a Restaurant</label>
                    <br>
                    <label>
                        <select name="dish" id="dish">
                        </select>
                    </label>
                </div>
                <a href="#" class="btn-previous">Previous</a>
                <a href="#" id="dish_sb" class="btn-meal">Next</a>
            </form>
        </div>
        <div class="panel" id="four-panel">
            <div class="panel-title">Review</div>
            <p>Content3</p>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#meal_sb").on("click", function () {
            let meal_form = $('form#meal_form');
            let formData = new FormData(meal_form[0]);
            let url = '{{ route('step2') }}';
            callAjax(url, formData, 'restaurant');
            $('#one').prop('checked', false);
            $('#two').attr( 'checked', 'checked' );
        });

        $("#restaurant_sb").on("click", function () {
            let restaurant_form = $('form#restaurant_form');
            let formData = new FormData(restaurant_form[0]);
            formData.append('meal', $('#meal').val());
            let url = '{{ route('step3') }}';
            callAjax(url, formData, 'dish');
            $('#two').prop('checked', false);
            $('#three').attr( 'checked', 'checked' );
        });

        $("#dish_sb").on("click", function () {

        });

        function callAjax(url, formData, form_id) {
            $.ajax({
                method: 'POST',
                url: url,
                enctype: 'multipart/form-data',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response)
                    if (response.code === 200) {
                        setData(form_id, response.data);

                    }
                },
                error: function (data) {

                },
                complete: function (data) {
                }
            });
        }


        function setData(form_id, data) {
            let option = '';
            // let meal = `<input type="hidden" name="meal" value="${data[form_id]}">`;
            let formId = $('#'+form_id);
            $.each(data[form_id], function (key, item) {
                option += `<option value="${item}">${item}</option>`
            });
            // formId.parent().append();
            formId.append(option);
        }
    });
</script>
</body>
</html>
