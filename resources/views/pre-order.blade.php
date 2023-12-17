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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>

<div class="container">
    <header>Pre-order food from restaurants</header>
    <div class="progress-bar">
        <div class="step">
            <p>Step1</p>
            <div class="bullet">
                <span>1</span>
            </div>
            <div class="check fas fa-check"></div>
        </div>
        <div class="step">
            <p>Step2</p>
            <div class="bullet">
                <span>2</span>
            </div>
            <div class="check fas fa-check"></div>
        </div>
        <div class="step">
            <p>Step3</p>
            <div class="bullet">
                <span>3</span>
            </div>
            <div class="check fas fa-check"></div>
        </div>
        <div class="step">
            <p>Review</p>
            <div class="bullet">
                <span>4</span>
            </div>
            <div class="check fas fa-check"></div>
        </div>
    </div>
    <div class="form-outer">
        <form action="#" id="form_order" method="POST">
            <div class="page slide-page">
                @csrf
                <div class="panel__inner">
                    <div class="panel__inner-item">
                        <label class="label" for="meal">Please Select a meal</label>
                        <select name="meal" id="meal">
                            @foreach($listMeal as $meal)
                                <option value="{{ $meal }}">{{ $meal }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="panel__inner-item">
                        <label class="label" for="number">Please Enter Number of people</label>
                        <input type="number" name="number" id="number" min="1" max="10" value="1">
                    </div>
                </div>
                <div class="field">
                    <button class="firstNext next">Next</button>
                </div>
            </div>
            <div class="page">
                <div class="panel__inner">
                    <div class="panel__inner-item">
                        <label class="label" for="">Please Select a Restaurant</label>
                        <select name="restaurant" id="restaurant">
                        </select>
                    </div>
                </div>
                <div class="field btns">
                    <button class="prev-1 prev">Previous</button>
                    <button class="next-1 next">Next</button>
                </div>
            </div>

            <div class="page">
                <div class="panel__inner">
                    <div class="item-add">
                        <div class="add-title">
                            <p>Please Select a Dish</p>
                            <p>Please enter no. of servings</p>
                        </div>
                        <div class="add-desc">
                            <select name="dish[]" id="dish" class="dish1">
                            </select>
                            <input type="number" name="number_serving[]" class="serving1" min="1" max="10" value="1">
                        </div>
                    </div>
                    <a href="#" class="btn-add">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="field btns">
                    <button class="prev-2 prev">Previous</button>
                    <button class="next-2 next">Next</button>
                </div>
            </div>
            <div class="page">
                <div class="panel__inner">
                    <table>
                        <tr>
                            <td>Meal</td>
                            <td class="view-meal"></td>
                        </tr>
                        <tr>
                            <td>No. of. People</td>
                            <td class="view-people"></td>
                        </tr>
                        <tr>
                            <td>Restaurant</td>
                            <td class="view-restaurant"></td>
                        </tr>
                        <tr>
                            <td>Dishes</td>
                            <td class="view-dish">
                                <div class="panel__inner-desc">

                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="field btns">
                    <button class="prev-3 prev">Previous</button>
                    <button class="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/alert.js') }}"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const slidePage = $(".slide-page");
        const nextBtnFirst = $(".firstNext");
        const prevBtnSec = $(".prev-1");
        const nextBtnSec = $(".next-1");
        const prevBtnThird = $(".prev-2");
        const nextBtnThird = $(".next-2");
        const prevBtnFourth = $(".prev-3");
        const submitBtn = $(".submit");
        const progressText = $(".step p");
        const progressCheck = $(".step .check");
        const bullet = $(".step .bullet");
        let current = 1;
        const progressAdd = $(".btn-add");
        let optionDish = '';

        nextBtnFirst.on("click", function (event) {
            event.preventDefault();
            let url = '{{ route('step2') }}';
            let data = {meal: $('#meal').val(), number: $('#number').val()};
            callAjax(url, data, 'restaurant');
        });

        function nextFirst() {
            slidePage.css("margin-left", "-25%");
            bullet.eq(current - 1).addClass("active");
            progressCheck.eq(current - 1).addClass("active");
            progressText.eq(current - 1).addClass("active");
            current += 1;
        }

        nextBtnSec.on("click", function (event) {
            event.preventDefault();
            let url = '{{ route('step3') }}';
            let data = {meal: $('#meal').val(), restaurant: $('#restaurant').val()};
            callAjax(url, data, 'dish');
        });

        function nextSec() {
            slidePage.css("margin-left", "-50%");
            bullet.eq(current - 1).addClass("active");
            progressCheck.eq(current - 1).addClass("active");
            progressText.eq(current - 1).addClass("active");
            current += 1;
        }

        nextBtnThird.on("click", function (event) {
            event.preventDefault();
            viewData();
        });

        function nextThird() {
            slidePage.css("margin-left", "-75%");
            bullet.eq(current - 1).addClass("active");
            progressCheck.eq(current - 1).addClass("active");
            progressText.eq(current - 1).addClass("active");
            current += 1;
        }

        submitBtn.on("click", function () {
            bullet.eq(current - 1).addClass("active");
            progressCheck.eq(current - 1).addClass("active");
            progressText.eq(current - 1).addClass("active");
            current += 1;
            setTimeout(function () {
                alert("Your Form Successfully Signed up");
                location.reload();
            }, 800);
        });

        prevBtnSec.on("click", function (event) {
            event.preventDefault();
            slidePage.css("margin-left", "0%");
            bullet.eq(current - 2).removeClass("active");
            progressCheck.eq(current - 2).removeClass("active");
            progressText.eq(current - 2).removeClass("active");
            current -= 1;
        });

        prevBtnThird.on("click", function (event) {
            event.preventDefault();
            slidePage.css("margin-left", "-25%");
            bullet.eq(current - 2).removeClass("active");
            progressCheck.eq(current - 2).removeClass("active");
            progressText.eq(current - 2).removeClass("active");
            current -= 1;
        });

        prevBtnFourth.on("click", function (event) {
            event.preventDefault();
            slidePage.css("margin-left", "-50%");
            bullet.eq(current - 2).removeClass("active");
            progressCheck.eq(current - 2).removeClass("active");
            progressText.eq(current - 2).removeClass("active");
            current -= 1;
        });

        function callAjax(url, data, form_id) {
            $.ajax({
                method: 'POST',
                url: url,
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response)
                    if (response.code === 200) {
                        setData(form_id, response.data);
                        if (form_id === 'restaurant') {
                            nextFirst();
                        } else if (form_id === 'dish') {
                            nextSec();
                        }
                    } else if (response.code === 422) {
                        danger(response.msg.message);
                    }
                },
                error: function (data) {
                },
                complete: function (data) {
                }
            });
        }

        function viewData() {
            let form_order = $('form#form_order');
            let formData = new FormData(form_order[0]);
            $.ajax({
                method: 'POST',
                url: '{{ route('review') }}',
                enctype: 'multipart/form-data',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response)
                    if (response.code === 200) {
                        setDataView(response.data);
                        nextThird();
                    } else if (response.code === 422) {
                        danger(response.msg.message);
                    }
                },
                error: function (data) {

                },
                complete: function (data) {
                }
            });
        }

        function setDataView(data) {
            let listDish = '';
            $.each(data.dishes, function (key, item) {
                listDish += `<p>${key} - ${item}</p>`
            });

            $('.view-meal').html(`<p>${data.meal}</p>`);
            $('.view-people').html(`<p>${data.number}</p>`);
            $('.view-restaurant').html(`<p>${data.restaurant}</p>`);
            $('.view-dish .panel__inner-desc').html(listDish);
        }



        function setData(form_id, data) {
            let option = '';
            $.each(data[form_id], function (key, item) {
                option += `<option value="${item}">${item}</option>`
            });
            $('#' + form_id).append(option);
            optionDish = option;
        }

        progressAdd.on('click', function(event) {
            event.preventDefault();
            addOption();
        });

        function addOption() {
            let html = ` <div class="add-desc">
                            <select name="dish[]" id="dish" class="dish">
                                ${optionDish}
                            </select>
                            <input type="number" name="number_serving[]" class="serving" min="1" max="10" value="1">
                        </div>`;

            $('.item-add').append(html);
        }
    });


    function info(message) {
        ava({
            icon: 'info',
            text: message,
            btnText: 'Okay',
            progressBar: true,
            toast: false,
        });
    }

    function success(message) {
        ava({
            icon: 'success',
            text: message,
            btnText: 'Okay',
            progressBar: true,
            toast: false,
        });
    }

    function danger(message) {
        ava({
            icon: 'danger',
            text: message,
            btnText: 'Okay',
            progressBar: true,
            toast: false,
        });
    }

    function white(message) {
        ava({
            icon: 'none',
            text: message,
            btnText: 'Okay',
            progressBar: true,
            toast: false,
            timer: 8000
        });
    }
</script>
</body>
</html>
