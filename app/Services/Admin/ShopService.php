<?php


namespace App\Services\Admin;


use App\Http\Requests\Admin\StoreShopRequest;
use App\Models\Shop;
use Illuminate\Support\Collection;

class ShopService
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
            'column' => 'name',
            'title' => 'Название',
            'align' => 'start',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'address',
            'title' => 'Адрес',
            'align' => 'start',
            'is_sortable' => true,
            'is_searchable' => true,
        ],
        [
            'column' => 'is_active',
            'title' => 'Активно',
            'align' => '',
            'is_sortable' => true,
            'is_searchable' => false,
        ],
    ];


    public function create(StoreShopRequest $request): Shop
    {
        $validated = $request->validated();
        $opening_hours = $this->parseOpeningHours($validated['opening_hours']);
        $location = $this->parseLocation($validated['location']);
        $this->updateSort($validated['sort']);

        $shop = new Shop();
        $shop->name = $validated['name'];
        $shop->address = $validated['address'];
        $shop->location = $location;
        $shop->opening_hours = $opening_hours;
        $shop->info = $validated['info'];
        $shop->sort = $validated['sort'];
        $shop->is_active = $validated['is_active'];
        $shop->save();

        return $shop;
    }


    public function update(
        StoreShopRequest $request,
        int $id
    ): Void {
        $validated = $request->validated();
        $opening_hours = $this->parseOpeningHours($validated['opening_hours']);
        $location = $this->parseLocation($validated['location']);
        $this->updateSort($validated['sort'], $request->input('sort_old'));

        Shop::where('id', $id)->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'location' => $location,
            'opening_hours' => $opening_hours,
            'info' => $validated['info'],
            'sort' => $validated['sort'],
            'is_active' => $validated['is_active'],
        ]);
    }


    public function getHoursList(array $opening_hours = []): string
    {
        $days_list = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        $hours_list = '';
        for ($i = 0; $i < 7; $i++) {
            $hours_list .= $days_list[$i] . ':';
            if ($opening_hours && $opening_hours[$i]) {
                $hours_list .= ' ' . $opening_hours[$i][0] . '-' . $opening_hours[$i][1];
            }
            if ($i != 6) $hours_list .= "\n";
        }

        return $hours_list;
    }


    public function parseOpeningHours(string $hours_input): array
    {
        $hours = [];
        $lines = explode("\n", trim($hours_input));
        foreach ($lines as $line) {
            $line_arr = explode(':', trim($line));
            if (count($line_arr) > 1 && !empty(trim($line_arr[1]))) {
                $hours_str = trim($line_arr[1]);
                $hours_arr = explode('-', $hours_str);
                if (count($hours_arr) > 1
                    && !empty(trim($hours_arr[0]))
                    && !empty(trim($hours_arr[1]))
                ) {
                    array_push($hours, [intval(trim($hours_arr[0])), intval(trim($hours_arr[1]))]);
                    continue;
                }
            }

            array_push($hours, []);
        }

        return $hours;
    }


    public function parseLocation(string $location_input): string
    {
        $location = '[]';
        if (preg_match('/^\[?\s?(\d{1,3}\.\d+)\s?,\s?(\d{1,3}\.\d+)\s?\]?$/', $location_input, $matches)) {
            $location = '[' . $matches[1] . ', ' . $matches[2] . ']';
        }

        return $location;
    }


    public function updateSort(int $new_sort, ?int $old_sort = null)
    {
        if ($old_sort) {
            if ($new_sort > $old_sort) {
                Shop::where('sort', '>', $old_sort)
                    ->where('sort', '<=', $new_sort)
                    ->decrement('sort');

            } elseif ($new_sort < $old_sort) {
                Shop::where('sort', '>=', $new_sort)
                    ->where('sort', '<', $old_sort)
                    ->increment('sort');
            }

        } else {
            Shop::where('sort', '>=', $new_sort)
                ->increment('sort');
        }
    }


    /**
     * Gets possible sort numbers as a collection for a new shop.
     *
     * @return Collection
     */
    public function getSortCollection(): Collection
    {
        $sort_num = Shop::count() + 1;
        $sort_arr = [];
        for ($i=0; $i<$sort_num; $i++) {
            $root_sort_obj = new \stdClass();
            $root_sort_obj->sort = $i + 1;
            array_push($sort_arr, $root_sort_obj);
        }
        return new Collection($sort_arr);
    }
}
