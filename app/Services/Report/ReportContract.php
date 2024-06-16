<?php

namespace App\Services\Report;

class ReportContract
{
    public static function fileMode(): array
    {
        return [
            [
                'text' => 'Print',
                'value' => 'print'
            ],
            [
                'text' => 'PDF',
                'value' => 'pdf'
            ],
        ];
    }

    public static function reportMode(): array
    {
        return [
            [
                'text' => 'Total Pieces',
                'value' => 'total_pieces'
            ],
            [
                'text' => 'Individual Pieces',
                'value' => 'individual_pieces'
            ],
        ];
    }

    public static function selectPrice(): array
    {
        return [
            [
                'text' => 'Select Price',
                'value' => '',
                'total' => 0
            ],
            [
                'text' => 'Purchase Price',
                'value' => 'purchase_price',
                'total' => 0
            ],
            [
                'text' => 'Sell Price',
                'value' => 'total_sell_price',
                'total' => 0
            ],
            [
                'text' => 'Profit Price',
                'value' => 'profit_price',
                'total' => 0
            ],
        ];
    }

    public static function selectPieces(): array
    {
        return [
            [
                'text' => 'Select Pieces',
                'value' => '',
                'total' => 0
            ],
            [
                'text' => 'Sell Pieces',
                'value' => 'sell_pieces',
                'total' => 0
            ],
            [
                'text' => 'Available Pieces',
                'value' => 'available_pieces',
                'total' => 0
            ]
        ];
    }
}
