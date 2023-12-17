<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishRequest;
use App\Http\Requests\MealRequest;
use App\Http\Requests\RestaurantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $listMeal = $this->getDataByMeal();
        return view('pre-order', compact('listMeal'));
    }

    public function step2(MealRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $items['restaurant'] = $this->getRestaurantByMeal($data['meal']);
        return $this::response(200, 'OK', $items);
    }

    public function step3(RestaurantRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $dish = $this->getDishByRestaurant($data['meal'], $data['restaurant']);
        $items['dish'] = $dish;

        return $this::response(200, 'OK', $items);
    }

    public function review(DishRequest $request)
    {
        $data = $request->validated();
        $items = $data;
        $items['dishes'] = array_combine($data['dish'], $data['number_serving']);
        return $this::response(200, 'OK', $items);
    }

    public function getRestaurantByMeal(string $meal = null): array
    {
        if ($meal) {
            $collection = collect(data_get($this->getDataJson(), 'dishes'));
            return $restaurants = $collection->filter(function ($item) use ($meal) {
                return in_array($meal, $item->availableMeals);
            })->pluck('restaurant')->unique()->values()->toArray();
        }

        return [];
    }

    public function getDishByRestaurant(string $meal, string $restaurant): array
    {
        if ($restaurant && $meal) {
            $collection = collect(data_get($this->getDataJson(), 'dishes'));
            return $collection->filter(function ($item) use ($meal) {
                return in_array($meal, $item->availableMeals);
            })->where('restaurant', $restaurant)->pluck('name')->unique()->values()->toArray();
        }

        return [];
    }

    public function getDataByMeal(): array
    {
        $collection = collect(data_get($this->getDataJson(), 'dishes'));
        return $collection->pluck('availableMeals')->flatten()->unique()->values()->toArray();
    }

    public function getDataJson()
    {
        $path = public_path('data/dishes.json');
        $json = File::get($path);
        if ($json) {
            return json_decode($json);
        }

        return null;
    }
}
