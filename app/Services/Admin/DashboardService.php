<?php


namespace App\Services\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Services\Site\CategoryService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardService
{
    private \stdClass $dashboard;
    private CategoryService $categoryService;
    private string $oldest_date;
    private array $dates;
    private int $category_id;
    private array $categoryBranch;


    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->setOldestDate();
    }


    public function getDashboard(int $year, int $month, int $category_id): \stdClass
    {
        $this->dashboard = new \stdClass();
        $this->setStartAndEndDates($year, $month);
        $this->category_id = $category_id;
        $this->setCategoryBranch();

        $this->getOrders();
        $this->getUserCount();

        $this->dashboard->categories = $this->categoryService->getCategories();
        $this->getCategorySaleSum();
        $this->getAddedProductsCount();
        $this->getReviewsCount();
        $this->getProductRatings();

        return $this->dashboard;
    }


    public function getDashboardContent(int $year, int $month, int $category_id): View
    {
        $dashboard = $this->getDashboard($year, $month, $category_id);

        return view('admin.includes.dashboard', compact(
            'dashboard',
            'category_id'
        ));
    }


    /**
     * Set oldest date by an oldest order creating date.
     *
     * @return void
     */
    public function setOldestDate(): void
    {
        $oldest_order = Order::select(['id', 'created_at'])
            ->oldest()
            ->first();

        $this->oldest_date = $oldest_order ? $oldest_order->created_at : '';
    }


    /**
     * Gets years for the dashboard select element.
     *
     * @return array
     */
    public function getYears(): array
    {
        $year_list = [];
        $curYear = intval(date('Y'));

        if ($this->oldest_date) {
            $oldest_year = Carbon::parse($this->oldest_date)->year;

            for ($i = $oldest_year; $i <= $curYear; $i++) {
                array_push($year_list, $i);
            }
        } else {
            $year_list = [$curYear];
        }

        return $year_list;
    }


    /**
     * Gets months for the dashboard select element.
     *
     * @param int $year
     * @return array
     */
    public function getMonths(int $year): array
    {
        $month_list = [];
        $curYear = intval(date('Y'));
        $curMonth = intval(date('n'));

        if ($year <= $curYear) {
            $curMonth = $year === $curYear ? $curMonth : 12;

            if ($this->oldest_date) {
                $oldest_year = Carbon::parse($this->oldest_date)->year;

                if ($year >= $oldest_year) {
                    $oldest_month = $year === $oldest_year
                        ? Carbon::parse($this->oldest_date)->month
                        : 1;

                    for ($i = $oldest_month; $i <= $curMonth; $i++) {
                        array_push($month_list, [$i, mb_ucfirst(Carbon::create()->month($i)->monthName)]);
                    }
                }
            } else {
                if ($year === $curYear) {
                    array_push($month_list, [$curMonth, mb_ucfirst(Carbon::create()->month($curMonth)->monthName)]);
                }
            }
        }

        return $month_list;
    }


    public function setStartAndEndDates(int $year, int $month): void
    {
        if ($month === 0) {
            $start_date = Carbon::parse($year . '-01-01')->startOfYear();
            $end_date = Carbon::parse($year . '-12-31')->endOfYear();
        } else {
            $start_date = Carbon::parse($year . '-' . sprintf('%02d', $month) . '-01')->startOfMonth();
            $end_date = Carbon::parse($year . '-' . sprintf('%02d', $month) . '-28')->endOfMonth();
        }

        $this->dates = [$start_date->toDateTimeString(), $end_date->toDateTimeString()];
    }


    public function getOrders(): void
    {
        $orders = Order::select('id', 'items_cost')
            ->where('status', 'completed')
            ->whereBetween('created_at', $this->dates)
            ->get();

        $this->dashboard->completed_orders_count = $orders->count();

        $orders_sum = '0';
        foreach ($orders as $order) {
            $orders_sum = bcadd($orders_sum, $order->items_cost);
        }
        $this->dashboard->completed_orders_sum = $orders_sum;
    }


    public function getUserCount()
    {
        $this->dashboard->registered_users_count = User::whereBetween('created_at', $this->dates)->count();
    }


    public function setCategoryBranch(): void
    {
        $this->categoryBranch = [0]; // All categories
        if ($this->category_id > 0) {
            $this->categoryBranch = $this->categoryService->getBranchFrom($this->category_id)
                ->pluck('id')
                ->all();
            array_unshift($this->categoryBranch, $this->category_id);
        }
    }


    /**
     * Gets a sum of sold products belonging to given category
     * between given dates.
     */
    public function getCategorySaleSum()
    {
        $query = OrderItem::query();

        if ($this->categoryBranch[0] > 0) {
            $query = $query->whereHas('product', function (Builder $query) {
                $query->whereIn('category_id', $this->categoryBranch);
            });
        }

        $order_items = $query->whereHas('order', function (Builder $query) {
            $query->where('status', 'completed')
                ->whereBetween('created_at', $this->dates);
        })->get();

        $sum = '0';
        foreach ($order_items as $item) {
            $sum = bcadd($sum, bcmul($item->price, $item->quantity));
        }

        $this->dashboard->category_sale_sum = $sum;
    }


    public function getAddedProductsCount()
    {
        $query = Product::query();

        if ($this->categoryBranch[0] > 0) {
            $query = $query->whereIn('category_id', $this->categoryBranch);
        }

        $this->dashboard->added_products_count = $query->whereBetween('created_at', $this->dates)
            ->count();
    }


    public function getReviewsCount()
    {
        $query = Review::query();

        if ($this->categoryBranch[0] > 0) {
            $query = $query->whereHas('product', function (Builder $query) {
                $query->whereIn('category_id', $this->categoryBranch);
            });
        }

        $this->dashboard->added_reviews_count = $query->whereBetween('created_at', $this->dates)
            ->count();
    }


    public function getProductRatings()
    {
        $query = OrderItem::selectRaw('product_id, sum(quantity) as qty, sum(price) as cost');

        if ($this->categoryBranch[0] > 0) {
            $query = $query->whereHas('product', function (Builder $query) {
                $query->whereIn('category_id', $this->categoryBranch);
            });
        }

        $order_items = $query->whereHas('order', function (Builder $query) {
            $query->where('status', 'completed')
                ->whereBetween('created_at', $this->dates);
        })
            ->with('product:id,name,slug,category_id')
            ->groupBy('product_id')
            ->get();

        $this->dashboard->products_by_qty = $order_items->sortByDesc('qty')->take(5);
        $this->dashboard->products_by_cost = $order_items->sortByDesc('cost')->take(5);
    }
}
