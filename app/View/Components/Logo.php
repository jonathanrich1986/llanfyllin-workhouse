<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Logo extends Component
{
    public $logo;
    public $logoId;
    public $type;

    public function __construct($type = 'default')
    {
        $this->type = $type;
        $logos = get_field('logos', 'options');
        $found_logo = null;
        $default_logo = null;

        foreach($logos as $logo_data) {

            if ($logo_data['type'] === 'default') {
                $default_logo = $logo_data['image'];
            }
            if ($logo_data['type'] === $type) {
                $found_logo = $logo_data['image'];
                break;
            }
        }

        $this->logo = $found_logo ?? $default_logo;
        $this->logoId = $this->logo['id'] ?? null;
    }

    public function render()
    {
        return $this->view('components.logo');
    }
}