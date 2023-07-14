<?php


namespace App\Services\Admin;


use App\Http\Requests\Admin\StorePromoRequest;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PromoService
{
    public static array $table_settings = [
        [
            'column' => 'id',
            'title' => 'id',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'image',
            'title' => '',
            'align' => '',
            'is_sortable' => false,
            'is_searchable' => false,
        ],
        [
            'column' => 'name',
            'title' => 'Название',
            'align' => 'start',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'started_at',
            'title' => 'Дата начала',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
        [
            'column' => 'until',
            'title' => 'Дата окончания',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
    ];


    public function getPromoWithProducts(int $promo_id): Promo
    {
        return Promo::where('id', $promo_id)
            ->with('products:id,name,promo_id,discount_prc,final_price,images,is_active')
            ->first();
    }


    public function createPromo(StorePromoRequest $request): Promo
    {
        $validated = $request->validated();
        $image_file = $request->file('image');
        $img_orig_name = $image_file->getClientOriginalName();

        $promo = new Promo();
        $promo->name = $validated['name'];
        $promo->slug = str($validated['name'])->slug();
        $promo->started_at = Carbon::parse($validated['started_at'])->toDateTimeString();
        $promo->until = Carbon::parse($validated['until'])->toDateTimeString();
        $promo->image = $img_orig_name;
        $promo->description = $validated['description'];
        $promo->save();

        $image_file->storeAs('images/promos/' . $promo->id . '/', $img_orig_name);

        if ($request->validated('add_products')) {
            $id_list = parse_comma_list($request->validated('add_products'));
            if ($id_list) {
                Product::whereIn('id', $id_list)->update(['promo_id' => $promo->id]);
            }
        }

        return $promo;
    }


    public function updateMainData(StorePromoRequest $request, int $id): void
    {
        $validated = $request->validated();

        Promo::where('id', $id)->update([
            'name' => $validated['name'],
            // 'slug' => str($validated['name'])->slug(), // Disabled for Search Optimization reasons
            'started_at' => Carbon::parse($validated['started_at'])->toDateTimeString(),
            'until' => Carbon::parse($validated['until'])->toDateTimeString(),
            'description' => $validated['description'],
        ]);
    }


    public function updateImage(StorePromoRequest $request, int $id): void
    {
        if ($request->input('old_image')) {
            $old_img = 'storage/images/promos/' . $id . '/' . $request->input('old_image');
            if (file_exists($old_img)) {
                unlink($old_img);
            }
        }

        $image_file = $request->file('image');
        $orig_name = $image_file->getClientOriginalName();
        $image_file->storeAs('images/promos/' . $id . '/', $orig_name);

        Promo::where('id', $id)->update(['image' => $orig_name]);
    }


    public function removeProductFromPromo(int $promo_id, int $product_id): View
    {
        Product::where('id', $product_id)->update(['promo_id' => null]);

        $promo = $this->getPromoWithProducts($promo_id);

        return view('admin.promos.product-table', compact('promo'));
    }
}
