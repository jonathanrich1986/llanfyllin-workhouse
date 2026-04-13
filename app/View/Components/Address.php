<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Address extends Component
{
    public ?string $addressId;
    public ?string $format;
    public ?array $addresses;
    public ?array $address;
    public ?array $addressLines;
    public ?string $phone;
    public ?string $email;

    public function __construct(
        ?string $addressId = null,
        ?string $format = null,
    ) {
        $this->addressId = $addressId;
        $this->format = $format;

        $this->addresses = get_field('wr_addresses', 'option') ?: [];
        $collection = collect($this->addresses);

        $address = $collection->firstWhere('id', $addressId) ?? $collection->first();
        $defaults = [
            'title' => null,
            'address_1' => null,
            'address_2' => null,
            'town' => null,
            'county' => null,
            'postcode' => null,
            'phone' => null,
            'email' => null,
        ];

        $this->address = array_merge($defaults, $address ?? []);
        $this->addressLines = array_filter([
            $this->address['address_1'],
            $this->address['address_2'],
            $this->address['town'],
            $this->address['county'],
            $this->address['postcode'],
        ]);
        $this->phone = $this->address['phone'];
        $this->email = $this->address['email'];
    }

    public function render()
    {
        return $this->view('components.address');
    }
}