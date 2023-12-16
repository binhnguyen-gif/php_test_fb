<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $listMeal = $this->getDataByMeal();
        return view('pre-order', compact('listMeal'));
    }

    public function step2(Request $request): \Illuminate\Http\JsonResponse
    {
        $meal = $request->input('meal');
        $restaurant = $this->getRestaurantByMeal($meal);
        return response()->json(['code' => 200, 'data' => ['restaurant' => $restaurant]], 200);
    }

    public function step3(Request $request): \Illuminate\Http\JsonResponse
    {
        $meal = $request->input('meal');
        $restaurant = $request->input('restaurant');
        $dish = $this->getDishByRestaurant($meal, $restaurant);
        return response()->json(['code' => 200, 'data' => ['dish' => $dish]], 200);
    }

    public function review(Request $request)
    {
        $data = [];
        return response()->json($data);
    }

    public function getRestaurantByMeal(string $meal = null): array
    {
        if($meal) {
            $collection = collect(data_get($this->getDataJson(), 'dishes'));
            return $restaurants = $collection->filter(function ($item) use($meal) {
                return in_array($meal, $item->availableMeals);
            })->pluck('restaurant')->unique()->values()->toArray();
        }

        return [];
    }

    public function getDishByRestaurant(string $meal, string $restaurant): array
    {
        if($restaurant && $meal) {
            $collection = collect(data_get($this->getDataJson(), 'dishes'));
            return $collection->filter(function ($item) use($meal) {
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
