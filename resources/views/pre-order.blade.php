<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        <label class="tab" id="one-tab" for="one">Step1</label>
        <label class="tab" id="two-tab" for="two">Step2</label>
        <label class="tab" id="three-tab" for="three">Step3</label>
        <label class="tab" id="four-tab" for="four">Review</label>
    </div>

    <div class="panels">
        <div class="panel" id="one-panel">
            <div class="panel-title">
                <form action="">
                    <div>
                        <label for="">Please Select a meal</label>
                        <br>
                        <label>
                            <select name="food" id="option-food">
                                <option value=""></option>
                            </select>
                        </label>
                    </div>
                    <div>
                        <label for="">Please Enter of people</label>
                        <br>
                        <input type="number" name="number" id="" max="10" value="1">
                    </div>
                </form>
            </div>
        </div>
        <div class="panel" id="two-panel">
            <div class="panel-title">Step2</div>
            <p>Content2</p>
        </div>
        <div class="panel" id="three-panel">
            <div class="panel-title">Step3</div>
            <p>Content3</p>
        </div>
        <div class="panel" id="four-panel">
            <div class="panel-title">Review</div>
            <p>Content3</p>
        </div>
    </div>
</div>
<script>
    loadFood();
    async function loadFood() {
        try {
            const response = await fetch('{{ asset('data/dishes.json') }}');
            if (!response.ok) {
                throw new Error(`Failed to fetch data: ${response.status} ${response.statusText}`);
            }
            const food = await response.json();
            let option = document.getElementById('option-food');
            option.innerHTML = '';

            food.dishes.forEach(function (dish) {
                let optionElement = document.createElement('option');
                optionElement.textContent = dish.name;
                optionElement.value = dish.id;
                option.appendChild(optionElement);
            });
        } catch (error) {
            console.error('Error loading food data:', error);
        }
    }

    async function loadListRestaurant() {
        try {
            const response = await fetch('{{ asset('data/dishes.json') }}');
            if (!response.ok) {
                throw new Error(`Failed to fetch data: ${response.status} ${response.statusText}`);
            }
            const food = await response.json();
            let option = document.getElementById('option-food');
            option.innerHTML = '';

            food.dishes.forEach(function (dish) {
                let optionElement = document.createElement('option');
                optionElement.textContent = dish.name;
                optionElement.value = dish.id;
                option.appendChild(optionElement);
            });
        } catch (error) {
            console.error('Error loading food data:', error);
        }
    }


</script>
</body>
</html>
