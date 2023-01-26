<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PromoCards extends Component
{

    /**
     * The alert type.
     *
     * @var string
     */
    public $discount;

    /**
     * The alert type.
     *
     * @var string
     */
    public $price;

    /**
     * The alert type.
     *
     * @var string
     */
    public $months;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($discount, $price, $months)
    {
        $this->discount = $discount;
        $this->price = $price;
        $this->months = $months;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.promo-cards');
    }
}
