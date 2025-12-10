<?php

namespace App\View\Components;

use DOMDocument;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Vite;

class ResponsiveImage extends Component
{
    private $name;

    private $breakpoints;

    private $sizes;

    private $rootPath;

    private $bootstrapBp = [
        'xs' => 479,
        'sm' => 480,
        'md' => 768,
        'lg' => 992,
        'xl' => 1200
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $breakpoints, $sizes, $path)
    {
        $this->rootPath = $path;
        $this->name = $name;
        $this->breakpoints = explode(",", $breakpoints);
        $this->sizes = explode(",", $sizes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.responsive-image');
    }

    /**
     * Determine if the given option is the currently selected option.
     */
    public function routeImage() : string
    {
        return Vite::asset("{$this->rootPath}/{$this->name}/{$this->name}-xs.webp");
    }

    /**
     * Determine if the given option is the currently selected option.
     */
    public function srcSet()
    {
        $setStr = "";
        $counter = 0;
        foreach ($this->breakpoints as $size) {
            if($size !== 'xs') {
                $wnhSizes = explode(";", $this->sizes[$counter]);

                $setStr .= '<source srcset="' . Vite::asset("{$this->rootPath}/{$this->name}/{$this->name}-{$size}.webp") . '" media="(min-width: ' . $this->bootstrapBp[$size] . 'px)" width="'. $wnhSizes[0] .'" height="'. $wnhSizes[1] .'"></source>';
            }
            $counter++;
        }
        return $setStr;
    }
}
