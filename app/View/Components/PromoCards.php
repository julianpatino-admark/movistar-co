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
    public $speed;

    /**
     * The alert type.
     *
     * @var string
     */
    public $promo;

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
    public $text;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($speed, $promo, $price, $text)
    {
        $this->speed = $speed;
        $this->price = $price;
        $this->promo = $promo;
        $this->text = $text;
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
