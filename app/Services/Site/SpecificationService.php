<?php


namespace App\Services\Site;


use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SpecificationService
{
    /**
     * Gets specifications for catalog filtering and collect all values
     * for all products of specified category.
     *
     * @param Category $category
     * @return Collection - specifications with a new 'values' property containing
     *                      array of pairs [value => quantity].
     */
    public function getFilterSpecs(Category $category): Collection
    {
        // Note: this query requires setting the 'modes' parameter
        // in app/config/database.php file ('connection' => ['mysql' => ['modes' => [...]]])
        // From this 'modes' array the 'ONLY_FULL_GROUP_BY' value should be removed.
        // Another way is to set the 'strict' ('connection' => ['mysql' => ['strict']])
        // parameter to false.

        $filter_specs_db = DB::table('specifications AS s')
            ->selectRaw('s.id, s.name, s.sort, ps.spec_value, s.units, COUNT(spec_value) as qty')
            ->rightJoin('product_specification AS ps', 's.id', '=', 'ps.specification_id')
            ->where('s.category_id', $category->id)
            ->where('s.is_filter', 1)
            ->groupBy('spec_value')
            ->orderBy('s.sort')
            ->orderByRaw('LENGTH(spec_value)')
            ->orderBy('spec_value')
            ->get();

        $filter_specs = collect([]);

        foreach ($filter_specs_db as $spec_db) {
            $is_spec_exists = false;
            foreach ($filter_specs as $spec) {
                if ($spec_db->id === $spec->id) {
                    $spec->values[$spec_db->spec_value] = $spec_db->qty;
                    $is_spec_exists = true;
                }
            }
            if (!$is_spec_exists) {
                $spec_db->values = [
                    $spec_db->spec_value => $spec_db->qty
                ];
                unset($spec_db->spec_value, $spec_db->qty);
                $filter_specs->push($spec_db);
            }
        }

        return $filter_specs;
    }
}
