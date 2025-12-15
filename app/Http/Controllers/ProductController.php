<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

use App\Models\Product;


class ProductController extends Controller
{
    public function washmashine(Request $request)
    {
        $objects = Product::where('status', true)->where('category_id', '=', 2)->where('city', 'kor');

        return view('products.washmashine', [
            'products' => $objects->paginate(20)
        ]);
    }
    public function smart(Request $request)
    {
        $objects = Product::where('status', true)->where('category_id', '=', 7)->where('city', 'kor');
        return view('products.smart', [
            'products' => $objects->paginate(20)
        ]);
    }
    public function laptop(Request $request)
    {
        $objects = Product::where('status', true)->where('category_id', '=', 8)->where('city', 'kor');
        return view('products.laptop', [
            'products' => $objects->paginate(20)
        ]);
    }
    public function vacuum(Request $request)
    {
        $objects = Product::where('status', true)->where('category_id', '=', 9)->where('city', 'kor');
        return view('products.vacuum', [
            'products' => $objects->paginate(20)
        ]);
    }
    public function refrigerator(Request $request)
    {
        $objects = Product::where('status', true)->where('category_id', '=', 1)->where('city', 'kor');
        return view('products.refrigerator', [
            'products' => $objects->paginate(20)
        ]);
    }
    public function tv32(Request $request)
    {
        $objects = Product::where('status', true)->where('category_id', '=', 6)->where('city', 'kor');
        return view('products.tv32', [
            'products' => $objects->paginate(20)
        ]);
    }
    public function tv40(Request $request)
    {
        $objects = Product::where('status', true)->where('category_id', '=', 4)->where('city', 'kor');
        return view('products.tv40', [
            'products' => $objects->paginate(20)
        ]);
    }
    public function tv50(Request $request)
    {
        $objects = Product::where('status', true)->where('category_id', '=', 5)->where('city', 'kor');
        return view('products.tv50', [
            'products' => $objects->paginate(20)
        ]);
    }
    public function favorite(Request $request)
    {
        $models = Auth::user()->favoritesProduct()->where('status', true)->orderBy('count_learn', 'asc');

        return view('products.favorite', [
            'products' => $models->paginate(20)
        ]);
    }
    public function sales(Request $request)
    {
        $models = Product::where('status', false)->where('updated_at', '>=', Carbon::now()->subDays(7)->startOfDay())
            ->where('city', 'kor')
            ->orderBy('updated_at', 'desc');


        return view('products.sales', [
            'products' => $models->paginate(20)
        ]);

    }
    public function saveParceProduct(Request $request)
    {
        $data = json_decode($request->post()[0], true);
        //$data = $request->json()->all();
        $category_id = 0;
        foreach ($data as $item) {
            //$test = $item["figi"];
            $model = Product::firstOrCreate(
                ['link' => $item["link"],],
                [
                    'category_id' => $item["category_id"],
                    'name' => $item["name"],
                    'link' => $item["link"],
                    'city' => $item["city"],
                    'slug' => '-',
                    'price' => (int)filter_var($item["price"], FILTER_SANITIZE_NUMBER_INT),
                    'count_learn' => 0,
                ]
            );
            $model->price = (int)filter_var($item["price"], FILTER_SANITIZE_NUMBER_INT);
            $model->save();
            $list_link[] = $item["link"];
            $category_id = $item["category_id"];
        }
        //Исключить товары которых не оказалось при парсинге 
        $products = Product::where('category_id', $category_id)->where('city', 'kor')->get();
        foreach ($products as $item) {
            if (in_array($item->link, $list_link)) {
                $item->status = true;
                $item->save();
                echo "true\n";
            } else {
                $item->status = false;
                $item->save();
                echo "false\n";
            }
        }
        return response([
            'status' => true,
        ], 200);
    }

    public function learn(Request $request)
    {
        $rows = $request->ids;
        foreach ($rows as $value) {
            Product::where('id', $value)
                ->update([
                    'count_learn' => DB::raw('count_learn+1'),
                ]);
        }
    }

    public function setFavorite(Request $request)
    {
        $rows = $request->ids;
        foreach ($rows as $value) {
            $product = Product::findOrFail($value);

            if (!$product->isFavorite) {
                Auth::user()->favoritesProduct()->attach($value);
            } else {
                Auth::user()->favoritesProduct()->detach($value);
            }
        }

        return response([
            'status' => true,
        ], 200);
    }
    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', [
            'product' => $product,
        ]);
    }
    public function detail(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return view('products.detail', [
            'product' => $product,
        ]);
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update(attributes: [
            'description' => $request->description,
        ]);

        return redirect()
            ->route('products.edit', $product->id)
            ->with('success', 'Продукт успешно обновлён!');
    }
}
